@extends('admin.layout')

@section('title', 'Users')
@section('header', 'Users')

@section('content')
    <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="label text-dark/50">Manage</div>
            <div class="mt-2 font-display text-3xl sm:text-4xl">Users</div>
        </div>
        <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
            <form method="get" class="flex w-full flex-col gap-3 sm:flex-row sm:items-center">
                <input
                    name="q"
                    value="{{ $q }}"
                    placeholder="Search users…"
                    class="w-full min-w-0 rounded-full border border-dark/10 bg-white/70 px-4 py-2.5 text-sm outline-none focus:border-gold/60 focus:ring-2 focus:ring-gold/25 sm:w-72"
                />
                @if ($q !== '')
                    <a class="btn btn-dark-outline shrink-0 justify-center" href="{{ route('admin.users.index') }}">Clear</a>
                @endif
            </form>
            <a class="btn btn-gold shrink-0 justify-center" href="{{ route('admin.users.create') }}">New user →</a>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur">
        <div class="grid grid-cols-12 gap-0 border-b border-dark/10 px-6 py-4 text-xs uppercase tracking-[0.34em] text-dark/50">
            <div class="col-span-4">Name</div>
            <div class="col-span-5">Email</div>
            <div class="col-span-2">Role</div>
            <div class="col-span-1 text-right">Edit</div>
        </div>

        @foreach ($users as $u)
            <div class="grid grid-cols-12 gap-0 px-6 py-5 border-b border-dark/10 last:border-b-0">
                <div class="col-span-4 flex items-center font-medium text-dark">{{ $u->name }}</div>
                <div class="col-span-5 flex items-center text-sm text-dark/70">{{ $u->email }}</div>
                <div class="col-span-2 flex items-center">
                    <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs {{ $u->is_admin ? 'border-gold/40 bg-gold/10 text-dark' : 'border-dark/10 bg-white/50 text-dark/60' }}">
                        {{ $u->is_admin ? 'Admin' : 'User' }}
                    </span>
                </div>
                <div class="col-span-1 flex items-center justify-end">
                    <a class="inline-flex items-center gap-2 text-dark hover:text-dark/70" href="{{ route('admin.users.edit', $u) }}">
                        <span class="label text-dark/60">Edit</span>
                        <span class="text-gold">→</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $users->onEachSide(1)->links('components.pagination') }}
    </div>
@endsection

