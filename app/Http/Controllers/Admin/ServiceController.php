<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        $q = request('q');
        $services = Service::query()
            ->when($q, fn ($qq) => $qq->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")->orWhere('slug', 'like', "%{$q}%");
            }))
            ->orderBy('sort_order')
            ->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $nextSortOrder = (int) (Service::query()->max('sort_order') ?? 0) + 1;

        return view('admin.services.create', compact('nextSortOrder'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:services,slug'],
            'description' => ['nullable', 'string'],
            'icon_name' => ['nullable', 'string', 'max:255'],
        ]);

        $data['sort_order'] = (int) (Service::query()->max('sort_order') ?? 0) + 1;
        $service = Service::create($data);

        return redirect()->route('admin.services.edit', $service)->with('status', 'Service created.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('services', 'slug')->ignore($service->id)],
            'description' => ['nullable', 'string'],
            'icon_name' => ['nullable', 'string', 'max:255'],
        ]);
        unset($data['sort_order']);

        $service->update($data);
        return redirect()->route('admin.services.edit', $service)->with('status', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('status', 'Service deleted.');
    }
}
