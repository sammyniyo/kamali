@extends('layouts.app')

@section('title', 'Projects — Kamali Architects')
@section('meta_description', 'Browse all Kamali Architects projects. Filter by status and category.')

@section('content')
    @php
        $search = trim((string) request('q', ''));
        $status = request('status', 'all');
        $category = request('category', 'all');

        $projects = \App\Models\Project::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('client_name', 'like', "%{$search}%");
                });
            })
            ->when(in_array($status, ['finished', 'under_construction'], true), fn ($q) => $q->where('status', $status))
            ->when($category !== 'all', fn ($q) => $q->where('category', $category))
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->paginate(\App\Support\ProjectPagination::publicPerPage())
            ->withQueryString();
        $categories = ['residential' => 'Residential', 'commercial' => 'Commercial', 'civic' => 'Civic'];
    @endphp

    <section class="relative overflow-hidden bg-dark text-cream">
        <div class="container-wide pb-10 pt-[calc(4.25rem+2rem)] sm:pb-12 md:pb-14 md:pt-[calc(7rem+2.5rem)] lg:pt-40">
            <p class="label text-cream/70" data-animate="fade-up">· Projects</p>
            <div class="mt-3 flex flex-col gap-3 sm:mt-4 sm:flex-row sm:flex-wrap sm:items-end sm:justify-between sm:gap-6" data-animate="fade-up">
                <h1 class="h-display">All <span class="italic text-gold">Projects</span></h1>
                <p class="text-sm text-cream/70 sm:text-base"><span data-projects-count class="tabular-nums">{{ $projects->total() }}</span> projects</p>
            </div>
        </div>
    </section>

    <section class="bg-cream">
        <div class="container-wide py-8 sm:py-10">
            <form
                method="get"
                class="flex flex-col gap-5 sm:gap-6"
                data-animate="fade-up"
                data-projects-search
                data-endpoint="{{ route('projects.search') }}"
            >
                <div class="grid gap-4 lg:grid-cols-12 lg:items-center">
                    <div class="lg:col-span-5">
                        <label class="label text-dark/50" for="q">Search</label>
                        <input
                            id="q"
                            name="q"
                            value="{{ $search }}"
                            placeholder="Search by name, location, or client…"
                            class="mt-2 w-full rounded-2xl border border-dark/10 bg-white/70 px-4 py-3 text-dark outline-none focus:border-gold/60 focus:ring-2 focus:ring-gold/25"
                        />
                    </div>
                    <div class="lg:col-span-7">
                        <p class="label text-dark/40 sm:hidden">Status</p>
                        <div class="mt-2 -mx-4 flex items-center gap-2 overflow-x-auto px-4 pb-1 lg:mx-0 lg:mt-0 lg:flex-wrap lg:justify-end lg:overflow-visible lg:px-0">
                            <span class="hidden lg:inline mr-2 label text-dark/40">Status</span>
                            @foreach ([['all', 'All'], ['finished', 'Finished'], ['under_construction', 'In Progress']] as [$k, $label])
                                <button
                                    type="submit"
                                    name="status"
                                    value="{{ $k }}"
                                    class="shrink-0 rounded-full px-4 py-2 text-sm border transition focus:outline-none focus:ring-2 focus:ring-gold/25 {{ $status === $k ? 'bg-dark text-cream border-dark' : 'bg-white/70 text-dark border-dark/10 hover:bg-white' }}"
                                >
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>

                        <input type="hidden" name="category" value="{{ $category }}" />
                    </div>
                </div>

                <div>
                    <p class="label text-dark/40 sm:hidden">Category</p>
                    <div class="mt-2 -mx-4 flex items-center gap-2 overflow-x-auto px-4 pb-1 sm:mx-0 sm:mt-0 sm:flex-wrap sm:overflow-visible sm:px-0">
                        <span class="hidden sm:inline mr-2 label text-dark/40">Category</span>
                        <button
                            type="submit"
                            name="category"
                            value="all"
                            class="shrink-0 rounded-full px-4 py-2 text-sm border transition focus:outline-none focus:ring-2 focus:ring-gold/25 {{ $category === 'all' ? 'bg-dark text-cream border-dark' : 'bg-white/70 text-dark border-dark/10 hover:bg-white' }}"
                        >
                            All
                        </button>
                        @foreach ($categories as $key => $label)
                            <button
                                type="submit"
                                name="category"
                                value="{{ $key }}"
                                class="shrink-0 rounded-full px-4 py-2 text-sm border transition focus:outline-none focus:ring-2 focus:ring-gold/25 {{ $category === $key ? 'bg-dark text-cream border-dark' : 'bg-white/70 text-dark border-dark/10 hover:bg-white' }}"
                            >
                                {{ $label }}
                            </button>
                        @endforeach

                        <input type="hidden" name="status" value="{{ $status }}" />

                        @if ($search !== '' || $status !== 'all' || $category !== 'all')
                            <a
                                href="{{ route('projects.index') }}"
                                class="shrink-0 inline-flex items-center gap-2 rounded-full border border-dark/10 bg-white/60 px-4 py-2 text-sm text-dark hover:bg-white transition sm:ml-auto"
                            >
                                Clear <span class="text-gold">×</span>
                            </a>
                        @endif
                    </div>
                </div>

                <div data-projects-grid>
                    @include('pages.projects._grid', [
                        'projects' => $projects,
                        'filtersActive' => $search !== '' || $status !== 'all' || $category !== 'all',
                    ])
                </div>

                <div data-projects-pagination>
                    @include('pages.projects._pagination', ['projects' => $projects])
                </div>
            </form>
        </div>
    </section>
@endsection

