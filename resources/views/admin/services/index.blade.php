@extends('admin.layout')

@section('title', 'Services')
@section('header', 'Services')

@section('content')
    <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="label text-dark/50">Manage</div>
            <div class="mt-2 font-display text-3xl sm:text-4xl">Services</div>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <form method="get" class="w-full sm:w-auto">
                <input
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search services…"
                    class="w-full rounded-full border border-dark/10 bg-white/70 px-4 py-2.5 text-sm outline-none focus:border-gold/60 sm:w-72"
                />
            </form>
            <a class="btn btn-gold shrink-0 justify-center" href="{{ route('admin.services.create') }}">New Service →</a>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur">
        <div class="grid grid-cols-12 gap-0 border-b border-dark/10 px-6 py-4 text-xs uppercase tracking-[0.34em] text-dark/50">
            <div class="col-span-6">Title</div>
            <div class="col-span-4">Icon</div>
            <div class="col-span-2 text-right">Order</div>
        </div>
        @foreach ($services as $s)
            <div class="grid grid-cols-12 gap-0 px-6 py-5 border-b border-dark/10 last:border-b-0">
                <div class="col-span-6">
                    <div class="font-medium">{{ $s->title }}</div>
                    <div class="mt-1 text-xs text-dark/50">{{ $s->slug }}</div>
                    <div class="mt-3 flex gap-3 text-sm">
                        <a class="text-dark hover:text-dark/60" href="{{ route('admin.services.edit', $s) }}">Edit →</a>
                        <form method="post" action="{{ route('admin.services.destroy', $s) }}" onsubmit="return confirm('Delete this service?')">
                            @csrf
                            @method('delete')
                            <button class="text-dark/60 hover:text-dark" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="col-span-4 flex items-center text-sm text-dark/70">{{ $s->icon_name ?? '—' }}</div>
                <div class="col-span-2 flex items-center justify-end text-sm text-dark/70">{{ $s->sort_order }}</div>
            </div>
        @endforeach
    </div>
@endsection

