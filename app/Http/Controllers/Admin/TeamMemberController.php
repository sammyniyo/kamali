<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index()
    {
        $q = request('q');
        $members = TeamMember::query()
            ->when($q, fn ($qq) => $qq->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")->orWhere('role', 'like', "%{$q}%");
            }))
            ->orderBy('sort_order')
            ->get();
        return view('admin.team.index', compact('members'));
    }

    public function create()
    {
        $nextSortOrder = (int) (TeamMember::query()->max('sort_order') ?? 0) + 1;

        return view('admin.team.create', compact('nextSortOrder'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'photo' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['sort_order'] = (int) (TeamMember::query()->max('sort_order') ?? 0) + 1;
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        $member = TeamMember::create($data);
        return redirect()->route('admin.team.edit', $member)->with('status', 'Team member created.');
    }

    public function edit(TeamMember $team)
    {
        $member = $team;
        return view('admin.team.edit', compact('member'));
    }

    public function update(Request $request, TeamMember $team)
    {
        $member = $team;
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'photo' => ['nullable', 'image', 'max:4096'],
            'photo_remove' => ['nullable', 'boolean'],
        ]);
        unset($data['sort_order']);

        if ($request->boolean('photo_remove') && $member->photo) {
            Storage::disk('public')->delete($member->photo);
            $member->photo = null;
        }

        if ($request->hasFile('photo')) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        $member->update($data);
        return redirect()->route('admin.team.edit', $member)->with('status', 'Team member updated.');
    }

    public function destroy(TeamMember $team)
    {
        if ($team->photo) {
            Storage::disk('public')->delete($team->photo);
        }
        $team->delete();
        return redirect()->route('admin.team.index')->with('status', 'Team member deleted.');
    }
}
