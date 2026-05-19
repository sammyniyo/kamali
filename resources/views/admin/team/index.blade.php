@extends('admin.layout')

@section('title', 'Team')
@section('header', 'Team')

@section('content')
    <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="label text-dark/50">Manage</div>
            <div class="mt-2 font-display text-3xl sm:text-4xl">Team</div>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <form method="get" class="w-full sm:w-auto">
                <input
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search team…"
                    class="w-full rounded-full border border-dark/10 bg-white/70 px-4 py-2.5 text-sm outline-none focus:border-gold/60 sm:w-72"
                />
            </form>
            <a class="btn btn-gold shrink-0 justify-center" href="{{ route('admin.team.create') }}">New Member →</a>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur">
        <div class="grid grid-cols-12 gap-0 border-b border-dark/10 px-6 py-4 text-xs uppercase tracking-[0.34em] text-dark/50">
            <div class="col-span-5">Name</div>
            <div class="col-span-5">Role</div>
            <div class="col-span-2 text-right">Order</div>
        </div>
        @foreach ($members as $m)
            <div class="grid grid-cols-12 gap-0 px-6 py-5 border-b border-dark/10 last:border-b-0">
                <div class="col-span-5">
                    <div class="flex items-start gap-4">
                        <div class="h-12 w-12 shrink-0 overflow-hidden rounded-2xl border border-dark/10 bg-cream">
                            <img class="h-full w-full object-cover" src="{{ \App\Support\KamaliMedia::teamPhoto($m->photo) }}" alt="" />
                        </div>
                        <div>
                            <div class="font-medium">{{ $m->name }}</div>
                            <div class="mt-1 text-xs text-dark/50">
                                {{ $m->linkedin_url ? 'LinkedIn' : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 flex gap-3 text-sm">
                        <a class="text-dark hover:text-dark/60" href="{{ route('admin.team.edit', $m) }}">Edit →</a>
                        <form method="post" action="{{ route('admin.team.destroy', $m) }}" onsubmit="return confirm('Delete this team member?')">
                            @csrf
                            @method('delete')
                            <button class="text-dark/60 hover:text-dark" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="col-span-5 flex items-center text-sm text-dark/70">{{ $m->role }}</div>
                <div class="col-span-2 flex items-center justify-end text-sm text-dark/70">{{ $m->sort_order }}</div>
            </div>
        @endforeach
    </div>
@endsection

