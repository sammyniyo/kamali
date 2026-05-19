<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $q = trim((string) request('q', ''));

        $users = User::query()
            ->when($q !== '', fn ($qq) => $qq->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            }))
            ->orderByDesc('is_admin')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'is_admin' => ['nullable', 'boolean'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'is_admin' => (bool) ($data['is_admin'] ?? false),
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.users.edit', $user)->with('status', 'User created.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'is_admin' => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $current = $request->user();
        $isAdmin = (bool) ($data['is_admin'] ?? false);
        if ($current && $current->id === $user->id) {
            // Never allow locking yourself out.
            $isAdmin = true;
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->is_admin = $isAdmin;

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('status', 'User updated.');
    }

    public function destroy(Request $request, User $user)
    {
        $current = $request->user();
        if ($current && $current->id === $user->id) {
            return back()->with('status', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'User deleted.');
    }
}

