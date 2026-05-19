@extends('layouts.app')

@section('title', 'Completed Projects — Kamali Architects')
@section('meta_description', 'Browse completed projects by Kamali Architects.')

@section('content')
    @php
        $search = trim((string) request('q', ''));
        $sort = request('sort', 'newest');
        $q = \App\Models\Project::query()->where('status', 'finished');
        $q->when($search !== '', function ($qq) use ($search) {
            $qq->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%");
            });
        });
        if ($sort === 'oldest') {
            $q->orderBy('year');
        } elseif ($sort === 'alpha') {
            $q->orderBy('title');
        } else {
            $q->orderByDesc('year');
        }
        $projects = $q->paginate(\App\Support\ProjectPagination::publicPerPage())->withQueryString();
        $filtersActive = $search !== '';
    @endphp

    <section class="bg-dark text-cream">
        <div class="container-wide pb-10 pt-[calc(4.25rem+2rem)] sm:pb-12 md:pb-14 md:pt-[calc(7rem+2.5rem)] lg:pt-40">
            <p class="label text-cream/70" data-animate="fade-up">· Completed Projects</p>
            <div class="mt-3 flex flex-col gap-5 sm:mt-4 lg:flex-row lg:items-end lg:justify-between lg:gap-6" data-animate="fade-up">
                <div>
                    <h1 class="h-display"><span class="italic text-gold">Finished</span></h1>
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
                    <div class="flex items-center gap-2">
                        <label class="label text-cream/60 shrink-0" for="sort">Sort</label>
                        <select
                            id="sort"
                            name="sort"
                            class="w-full rounded-full border border-cream/15 bg-dark/40 px-4 py-2.5 text-sm text-cream/90 sm:w-auto"
                            onchange="this.form.submit()"
                        >
                            <option value="newest" @selected($sort === 'newest')>Newest</option>
                            <option value="oldest" @selected($sort === 'oldest')>Oldest</option>
                            <option value="alpha" @selected($sort === 'alpha')>Alphabetical</option>
                        </select>
                    </div>
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
                            heading="No completed projects match your search"
                            body="Try different keywords or clear the search to see the full list when projects are published."
                            action-text="Clear search"
                            :action-href="route('projects.finished')"
                        />
                    @else
                        <x-empty-state
                            class="md:col-span-2 lg:col-span-3"
                            heading="No completed projects yet"
                            body="Finished work will appear here as it’s published. Reach out if you’d like to discuss a commission."
                            action-text="Contact us"
                            :action-href="route('contact')"
                        />
                    @endif
                @else
                    @foreach ($projects as $idx => $p)
                    @php
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
                        </div>
                        <div class="p-5 sm:p-6">
                            <p class="label text-dark/50">
                                <span class="text-gold">•</span> {{ $p->location }}
                            </p>
                            <p class="mt-3 font-display text-xl text-dark sm:text-2xl">{{ $p->title }}</p>
                        </div>
                    </a>
                    @endforeach
                @endif
            </div>
            @include('pages.projects._pagination', ['projects' => $projects])
        </div>
    </section>
@endsection

