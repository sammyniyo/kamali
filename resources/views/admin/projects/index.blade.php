@extends('admin.layout')

@section('title', 'Projects')
@section('header', 'Projects')

@section('content')
    <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="label text-dark/50">Manage</div>
            <div class="mt-2 font-display text-3xl sm:text-4xl">Projects</div>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <form method="get" class="w-full sm:w-auto">
                <input
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search projects…"
                    class="w-full rounded-full border border-dark/10 bg-white/70 px-4 py-2.5 text-sm outline-none focus:border-gold/60 sm:w-72"
                />
            </form>
            <a class="btn btn-gold shrink-0 justify-center" href="{{ route('admin.projects.create') }}">New Project →</a>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur">
        <div class="hidden grid-cols-12 gap-0 border-b border-dark/10 px-6 py-4 text-xs uppercase tracking-[0.34em] text-dark/50 md:grid">
            <div class="col-span-5">Project</div>
            <div class="col-span-2">Status</div>
            <div class="col-span-3">Location</div>
            <div class="col-span-2 text-right">Year</div>
        </div>
        @forelse ($projects as $p)
            <div class="grid grid-cols-1 gap-4 border-b border-dark/10 px-5 py-5 last:border-b-0 md:grid-cols-12 md:gap-0 md:px-6">
                <div class="md:col-span-5">
                    <div class="flex items-start gap-4">
                        <div class="h-14 w-20 shrink-0 overflow-hidden rounded-xl border border-dark/10 bg-cream">
                            <img
                                class="h-full w-full object-cover"
                                src="{{ \App\Support\KamaliMedia::projectCover($p->cover_image, $loop->index) }}"
                                alt=""
                            />
                        </div>
                        <div class="min-w-0">
                            <div class="font-medium truncate">{{ $p->title }}</div>
                            <div class="mt-1 text-xs text-dark/50">
                                {{ ucfirst($p->category) }}
                                @if ($p->featured)
                                    · <span class="text-gold">Featured</span>
                                @endif
                                @if (is_array($p->gallery) && count($p->gallery))
                                    · {{ count($p->gallery) }} gallery
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 flex flex-wrap gap-x-4 gap-y-2 text-sm">
                        <a class="text-dark hover:text-dark/60" href="{{ route('admin.projects.edit', $p) }}">Edit →</a>
                        <form method="post" action="{{ route('admin.projects.destroy', $p) }}" onsubmit="return confirm('Delete this project?')">
                            @csrf
                            @method('delete')
                            <button class="text-dark/60 hover:text-dark" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="flex items-center gap-3 md:col-span-2">
                    <span class="label text-dark/45 md:hidden">Status</span>
                    <span class="inline-flex rounded-full border border-dark/10 bg-cream px-3 py-1 text-xs">
                        {{ $p->status === 'finished' ? 'Finished' : 'Under construction' }}
                    </span>
                </div>
                <div class="flex items-baseline gap-3 text-sm text-dark/70 md:col-span-3 md:items-center">
                    <span class="label shrink-0 text-dark/45 md:hidden">Location</span>
                    <span class="min-w-0">{{ $p->location }}</span>
                </div>
                <div class="flex items-baseline justify-between gap-3 text-sm text-dark/70 md:col-span-2 md:items-center md:justify-end">
                    <span class="label text-dark/45 md:hidden">Year</span>
                    <span>{{ $p->year }}</span>
                </div>
            </div>
        @empty
            <div class="px-6 py-16 text-center">
                <p class="font-display text-xl text-dark">No projects yet</p>
                <p class="mt-2 text-sm text-dark/60">Create your first project to populate the public portfolio.</p>
                <a class="btn btn-gold mt-6 inline-flex" href="{{ route('admin.projects.create') }}">New project →</a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $projects->onEachSide(2)->links('components.pagination', \App\Support\ProjectPagination::adminLinkData()) }}
    </div>
@endsection

