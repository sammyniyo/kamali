@extends('admin.layout')

@section('title', 'Partners')
@section('header', 'Partners')

@section('content')
    <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="label text-dark/50">Manage</div>
            <div class="mt-2 font-display text-3xl sm:text-4xl">Partners</div>
            <p class="mt-2 max-w-lg text-sm leading-relaxed text-dark/60">
                Upload logos for the homepage “Trusted by” grid. Set a <strong class="font-medium text-dark/80">category</strong> label under each logo (e.g. Contractor, Developer).
            </p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <form method="get" class="w-full sm:w-auto">
                <input
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search partners…"
                    class="w-full rounded-full border border-dark/10 bg-white/70 px-4 py-2.5 text-sm outline-none focus:border-gold/60 sm:w-72"
                />
            </form>
            <a class="btn btn-gold shrink-0 justify-center" href="{{ route('admin.partners.create') }}">New Partner →</a>
        </div>
    </div>

    @forelse ($partners as $partner)
        @if ($loop->first)
            <div class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @endif
        <article class="overflow-hidden rounded-2xl border border-dark/10 bg-white/80 shadow-[0_2px_24px_rgba(26,26,24,0.04)] backdrop-blur">
            <div class="border-b border-dark/8 bg-cream/40 px-5 py-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <div class="font-display text-xl text-dark">{{ $partner->name }}</div>
                        @if ($partner->note)
                            <p class="mt-1 text-xs uppercase tracking-[0.14em] text-dark/50">{{ $partner->note }}</p>
                        @endif
                    </div>
                    @if ($partner->is_visible)
                        <span class="shrink-0 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-2.5 py-1 text-[10px] font-medium uppercase tracking-wider text-emerald-800">Live</span>
                    @else
                        <span class="shrink-0 rounded-full border border-dark/10 bg-dark/5 px-2.5 py-1 text-[10px] font-medium uppercase tracking-wider text-dark/55">Hidden</span>
                    @endif
                </div>
            </div>

            <div class="p-5">
                <p class="label text-dark/45">Public preview</p>
                <div class="mt-3 rounded-xl border border-dark/10 bg-white p-5">
                    <ul class="partners-trust__grid !grid-cols-1 !gap-y-0 mx-auto max-w-[11rem]" role="list">
                        <x-partner-logo-cell :partner="$partner" />
                    </ul>
                </div>

                <div class="mt-4 flex flex-wrap gap-2 text-[11px] uppercase tracking-[0.12em] text-dark/50">
                    @if ($partner->logo)
                        <span class="rounded-full border border-gold/30 bg-gold/10 px-2.5 py-1 text-dark/70">Logo</span>
                    @endif
                    @if ($partner->note)
                        <span class="rounded-full border border-dark/10 bg-white px-2.5 py-1">{{ $partner->note }}</span>
                    @endif
                    <span class="rounded-full border border-dark/10 bg-white px-2.5 py-1">Order #{{ $partner->sort_order }}</span>
                </div>

                @if ($partner->url)
                    <p class="mt-3 truncate text-xs text-dark/50">{{ $partner->url }}</p>
                @endif

                <div class="mt-5 flex flex-wrap gap-3 border-t border-dark/8 pt-4 text-sm">
                    <a class="text-dark hover:text-gold" href="{{ route('admin.partners.edit', $partner) }}">Edit →</a>
                    <form method="post" action="{{ route('admin.partners.destroy', $partner) }}" onsubmit="return confirm('Delete this partner?')">
                        @csrf
                        @method('delete')
                        <button class="text-dark/55 hover:text-dark" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        </article>
        @if ($loop->last)
            </div>
        @endif
    @empty
        <div class="mt-8 rounded-2xl border border-dashed border-dark/15 bg-white/50 px-6 py-16 text-center">
            <p class="font-display text-xl text-dark">No partners yet</p>
            <p class="mt-2 text-sm text-dark/60">Add press outlets and award bodies to populate the homepage and About page.</p>
            <a class="btn btn-gold mt-6 inline-flex" href="{{ route('admin.partners.create') }}">Add first partner →</a>
        </div>
    @endforelse
@endsection
