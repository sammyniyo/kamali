@extends('admin.layout')

@section('title', 'Edit user')
@section('header', 'Edit user')

@section('content')
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-dark/10 bg-white/70 backdrop-blur px-5 py-4 text-sm text-dark/80">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="text-sm text-dark/60">User ID: {{ $user->id }}</div>
        <form method="post" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-dark-outline">Delete</button>
        </form>
    </div>

    <form
        id="admin-user-form"
        method="post"
        action="{{ route('admin.users.update', $user) }}"
        x-data="adminUserForm({ isEdit: true })"
        @submit.prevent="submit()"
    >
        @csrf
        @method('PUT')
        @include('admin.users._form', ['user' => $user])
    </form>
@endsection

