@extends('admin.layout')

@section('title', 'Messages')
@section('header', 'Messages')

@section('content')
    <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="label text-dark/50">Inbox</div>
            <div class="mt-2 font-display text-3xl sm:text-4xl">Contact Messages</div>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
            <form method="get" class="w-full sm:w-auto">
                <input
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search messages…"
                    class="w-full rounded-full border border-dark/10 bg-white/70 px-4 py-2.5 text-sm outline-none focus:border-gold/60 sm:w-72"
                />
            </form>
            <div class="shrink-0 text-sm text-dark/60">{{ $messages->total() }} total</div>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur">
        <div class="hidden grid-cols-12 gap-0 border-b border-dark/10 px-6 py-4 text-xs uppercase tracking-[0.34em] text-dark/50 lg:grid">
            <div class="col-span-3">From</div>
            <div class="col-span-4">Subject</div>
            <div class="col-span-3">Email</div>
            <div class="col-span-2 text-right">Date</div>
        </div>
        @forelse ($messages as $m)
            <div class="space-y-3 border-b border-dark/10 px-5 py-5 last:border-b-0 lg:space-y-0 lg:px-6">
                <div class="grid grid-cols-1 gap-3 lg:grid-cols-12 lg:gap-0">
                    <div class="lg:col-span-3">
                        <div class="label text-dark/45 lg:hidden">From</div>
                        <div class="font-medium">{{ $m->name }}</div>
                        @if ($m->phone)
                            <div class="mt-1 text-xs text-dark/50">{{ $m->phone }}</div>
                        @endif
                    </div>
                    <div class="min-w-0 lg:col-span-4 lg:flex lg:items-center">
                        <div class="label text-dark/45 lg:hidden">Subject</div>
                        <div class="flex flex-wrap items-center gap-2 text-sm text-dark/70">
                            <a class="font-medium text-dark hover:text-dark/70" href="{{ route('admin.messages.show', $m) }}">{{ $m->subject ?? '—' }}</a>
                            @if (is_null($m->read_at))
                                <span class="inline-flex rounded-full bg-gold/20 px-2 py-1 text-[11px] text-dark">New</span>
                            @endif
                        </div>
                    </div>
                    <div class="break-all text-sm text-dark/70 lg:col-span-3 lg:flex lg:items-center">
                        <span class="label mb-1 block text-dark/45 lg:hidden">Email</span>
                        {{ $m->email }}
                    </div>
                    <div class="flex justify-between gap-4 text-sm text-dark/70 lg:col-span-2 lg:items-center lg:justify-end">
                        <span class="label text-dark/45 lg:hidden">Date</span>
                        <span class="tabular-nums">{{ $m->created_at->format('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="rounded-xl border border-dark/5 bg-cream/40 px-4 py-3 text-sm leading-relaxed text-dark/70 lg:col-span-12">
                    {{ \Illuminate\Support\Str::limit($m->message, 220) }}
                </div>
            </div>
        @empty
            <div class="px-6 py-16 text-center">
                <p class="font-display text-xl text-dark">No messages</p>
                <p class="mt-2 text-sm text-dark/60">When visitors use the contact form, threads will appear here.</p>
                <a class="btn btn-dark-outline mt-6 inline-flex" href="{{ route('contact') }}" target="_blank" rel="noreferrer">Open contact page ↗</a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $messages->onEachSide(1)->links('components.pagination') }}
    </div>
@endsection

