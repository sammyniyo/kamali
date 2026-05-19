@extends('layouts.app')

@section('title', 'Active Projects — Kamali Architects')
@section('meta_description', 'Browse projects currently under construction by Kamali Architects.')

@section('content')
    @php
        $search = trim((string) request('q', ''));
        $projects = \App\Models\Project::query()
            ->where('status', 'under_construction')
            ->when($search !== '', function ($qq) use ($search) {
                $qq->where(function ($w) use ($search) {
                    $w->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('client_name', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('year')
            ->paginate(\App\Support\ProjectPagination::publicPerPage())
            ->withQueryString();
        $filtersActive = $search !== '';
    @endphp

    <section class="bg-dark text-cream">
        <div class="container-wide pb-10 pt-[calc(4.25rem+2rem)] sm:pb-12 md:pb-14 md:pt-[calc(7rem+2.5rem)] lg:pt-40">
            <p class="label text-cream/70" data-animate="fade-up">· Active Projects</p>
            <div class="mt-3 flex flex-col gap-5 sm:mt-4 lg:flex-row lg:items-end lg:justify-between lg:gap-6" data-animate="fade-up">
                <div>
                    <h1 class="h-display">Under <span class="italic text-gold">Construction</span></h1>
                    <p class="mt-3 text-sm text-cream/70 sm:text-base"><span class="tabular-nums">{{ $projects->total() }}</span> projects</p>
                </div>
                <form method="get" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-3">
                    <div class="flex items-center gap-2">
                        <label class="sr-only" for="q">Search</label>
                        <input
                            id="q"
                            name="q"
                            value="{{ $search }}"
                            placeholder="Name, location, client…"
                            class="w-full min-w-0 rounded-full border border-cream/15 bg-dark/40 px-4 py-2.5 text-sm text-cream/90 outline-none focus:border-gold/60 focus:ring-2 focus:ring-gold/25 sm:w-[240px]"
                        />
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full border border-cream/15 bg-dark/40 px-4 py-2.5 text-sm text-cream/90 transition hover:bg-dark/55">
                        <span class="pulse-soft" aria-hidden="true">🔧</span>
                        <span>Filter</span>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <section class="bg-cream">
        <div class="container-wide py-8 sm:py-10">
            <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
                @if ($projects->isEmpty())
                    @if ($filtersActive)
                        <x-empty-state
                            class="md:col-span-2 lg:col-span-3"
                            heading="No active projects match your search"
                            body="Try different keywords or clear the search to see projects currently on site."
                            action-text="Clear search"
                            :action-href="route('projects.under_construction')"
                        />
                    @else
                        <x-empty-state
                            class="md:col-span-2 lg:col-span-3"
                            heading="No projects under construction"
                            body="Active sites will be listed here when available. Contact the studio for current workload and timelines."
                            action-text="Contact us"
                            :action-href="route('contact')"
                        />
                    @endif
                @else
                    @foreach ($projects as $idx => $p)
                    @php
                        $progress = 55;
                        $coverSrc = \App\Support\KamaliMedia::projectCover($p->cover_image, $idx);
                    @endphp
                    <a
                        href="{{ route('projects.show', ['slug' => $p->slug]) }}"
                        class="group overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur transition duration-300 motion-safe:hover:-translate-y-1"
                        data-animate="fade-up"
                    >
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img
                                class="h-full w-full object-cover transition duration-500 motion-safe:group-hover:scale-[1.04]"
                                src="{{ $coverSrc }}"
                                alt="{{ $p->title }}"
                                loading="lazy"
                                decoding="async"
                                referrerpolicy="no-referrer"
                            />
                            <div class="absolute left-3 top-3 rounded-full border border-cream/20 bg-dark/55 px-3 py-1 text-xs text-cream/90 pulse-soft sm:left-4 sm:top-4">
                                <span aria-hidden="true">🔧</span> In Progress
                            </div>
                            <div class="absolute inset-x-0 bottom-0 p-4 sm:p-5">
                                <div class="h-1.5 w-full overflow-hidden rounded-full bg-cream/20">
                                    <div class="h-full bg-gold" style="width: {{ $progress }}%"></div>
                                </div>
                                <p class="mt-2 text-xs text-cream/70 tabular-nums">{{ $progress }}% progress</p>
                            </div>
                        </div>
                        <div class="p-5 sm:p-6">
                            <p class="font-display text-xl text-dark sm:text-2xl">{{ $p->title }}</p>
                            <p class="mt-2 text-sm text-dark/60">{{ $p->location }}</p>
                        </div>
                    </a>
                    @endforeach
                @endif
            </div>
            @include('pages.projects._pagination', ['projects' => $projects])
        </div>
    </section>
@endsection

