@extends('admin.layout')

@section('title', 'Blog')
@section('header', 'Blog')

@section('content')
    <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="label text-dark/50">Manage</div>
            <div class="mt-2 font-display text-3xl sm:text-4xl">Blog</div>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <form method="get" class="w-full sm:w-auto">
                <input
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search posts…"
                    class="w-full rounded-full border border-dark/10 bg-white/70 px-4 py-2.5 text-sm outline-none focus:border-gold/60 sm:w-72"
                />
            </form>
            <a class="btn btn-gold shrink-0 justify-center" href="{{ route('admin.blogs.create') }}">New Post →</a>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur">
        <div class="grid grid-cols-12 gap-0 border-b border-dark/10 px-6 py-4 text-xs uppercase tracking-[0.34em] text-dark/50">
            <div class="col-span-5">Title</div>
            <div class="col-span-3">Status</div>
            <div class="col-span-4 text-right">Published</div>
        </div>
        @forelse ($blogs as $b)
            <div class="grid grid-cols-12 gap-0 px-6 py-5 border-b border-dark/10 last:border-b-0">
                <div class="col-span-5">
                    <div class="font-medium">{{ $b->title }}</div>
                    <div class="mt-1 text-xs text-dark/50">{{ $b->slug }}</div>
                    <div class="mt-3 flex gap-3 text-sm">
                        <a class="text-dark hover:text-dark/60" href="{{ route('admin.blogs.edit', $b) }}">Edit →</a>
                        @if ($b->isPublished())
                            <a class="text-dark/60 hover:text-dark" href="{{ route('blog.show', $b->slug) }}" target="_blank" rel="noreferrer">View ↗</a>
                        @endif
                        <form method="post" action="{{ route('admin.blogs.destroy', $b) }}" onsubmit="return confirm('Delete this post?')">
                            @csrf
                            @method('delete')
                            <button class="text-dark/60 hover:text-dark" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="col-span-3 flex items-center text-sm">
                    @if ($b->isPublished())
                        <span class="inline-flex rounded-full border border-emerald-500/30 bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-800">Published</span>
                    @else
                        <span class="inline-flex rounded-full border border-dark/10 bg-dark/5 px-3 py-1 text-xs font-medium text-dark/70">Draft</span>
                    @endif
                </div>
                <div class="col-span-4 flex items-center justify-end text-sm text-dark/70">
                    {{ $b->published_at?->format('M j, Y g:i A') ?? '—' }}
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center text-sm text-dark/60">No posts yet. Create one to get started.</div>
        @endforelse
    </div>

    @if ($blogs->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $blogs->onEachSide(1)->links('components.pagination') }}
        </div>
    @endif
@endsection
