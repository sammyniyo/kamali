<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Support\ProjectPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    public function index()
    {
        $q = request('q');
        $projects = Project::query()
            ->when($q, fn ($qq) => $qq->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%");
            }))
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->paginate(ProjectPagination::adminPerPage(request()))
            ->withQueryString();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $nextSortOrder = (int) (Project::query()->max('sort_order') ?? 0) + 1;

        return view('admin.projects.create', compact('nextSortOrder'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:' . (int) date('Y')],
            'category' => ['required', Rule::in(['residential', 'commercial', 'civic'])],
            'status' => ['required', Rule::in(['finished', 'under_construction'])],
            'featured' => ['nullable', 'boolean'],
            'architect_name' => ['nullable', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'surface_area' => ['nullable', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'max:6144'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:6144'],
        ]);

        $this->assertNoDuplicateImageUploads($request);

        $data['featured'] = (bool) $request->boolean('featured');
        $data['sort_order'] = (int) (Project::query()->max('sort_order') ?? 0) + 1;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('projects/covers', 'public');
        }

        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery', []) as $file) {
                $galleryPaths[] = $file->store('projects/gallery', 'public');
            }
        }
        $data['gallery'] = $galleryPaths;

        $project = Project::create($data);
        return redirect()->route('admin.projects.edit', $project)->with('status', 'Project created.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($project->id)],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:' . (int) date('Y')],
            'category' => ['required', Rule::in(['residential', 'commercial', 'civic'])],
            'status' => ['required', Rule::in(['finished', 'under_construction'])],
            'featured' => ['nullable', 'boolean'],
            'architect_name' => ['nullable', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'surface_area' => ['nullable', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'max:6144'],
            'cover_remove' => ['nullable', 'boolean'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:6144'],
            'gallery_remove' => ['nullable', 'array'],
            'gallery_remove.*' => ['string'],
        ]);

        $this->assertNoDuplicateImageUploads($request);

        $data['featured'] = (bool) $request->boolean('featured');
        unset($data['sort_order']);

        if ($request->boolean('cover_remove') && $project->cover_image) {
            Storage::disk('public')->delete($project->cover_image);
            $project->cover_image = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::disk('public')->delete($project->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('projects/covers', 'public');
        }

        $gallery = is_array($project->gallery) ? $project->gallery : [];
        $toRemove = $request->input('gallery_remove', []);
        if (is_array($toRemove) && count($toRemove)) {
            foreach ($toRemove as $path) {
                Storage::disk('public')->delete($path);
            }
            $gallery = array_values(array_filter($gallery, fn ($p) => ! in_array($p, $toRemove, true)));
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery', []) as $file) {
                $gallery[] = $file->store('projects/gallery', 'public');
            }
        }

        $data['gallery'] = $gallery;

        $project->update($data);
        return redirect()->route('admin.projects.edit', $project)->with('status', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        if ($project->cover_image) {
            Storage::disk('public')->delete($project->cover_image);
        }
        if (is_array($project->gallery)) {
            foreach ($project->gallery as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $project->delete();
        return redirect()->route('admin.projects.index')->with('status', 'Project deleted.');
    }

    /**
     * Reject when the same binary is uploaded more than once (cover vs gallery or within gallery).
     *
     * @throws ValidationException
     */
    private function assertNoDuplicateImageUploads(Request $request): void
    {
        $hashes = [];

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $hash = hash_file('sha256', $file->getRealPath());
            if (isset($hashes[$hash])) {
                throw ValidationException::withMessages([
                    'cover_image' => 'This image was already included in the same request.',
                ]);
            }
            $hashes[$hash] = 'cover';
        }

        foreach ($request->file('gallery', []) as $index => $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }
            $hash = hash_file('sha256', $file->getRealPath());
            if (isset($hashes[$hash])) {
                $other = $hashes[$hash];
                $message = $other === 'cover'
                    ? 'A gallery image is identical to the cover image — use different files.'
                    : 'Duplicate gallery image detected — each file must be unique.';

                throw ValidationException::withMessages([
                    'gallery' => $message,
                ]);
            }
            $hashes[$hash] = 'gallery:'.$index;
        }
    }
}
