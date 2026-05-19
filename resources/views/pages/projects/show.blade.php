@extends('layouts.app')

@php
    $project = \App\Models\Project::query()->where('slug', request()->route('slug'))->firstOrFail();
@endphp

@section('title', $project->title . ' — Kamali Architects')

@section('meta_description', \Illuminate\Support\Str::limit($project->description ?? '', 150))

@section('content')
    @php
        $related = \App\Models\Project::query()
            ->where('id', '!=', $project->id)
            ->where('category', $project->category)
            ->limit(3)
            ->get();

        $images = collect([$project->cover_image])->filter()->values();
        if (is_array($project->gallery)) {
            $images = $images->merge($project->gallery);
        }
        if ($images->isEmpty()) {
            $sliderImages = collect(range(0, 5))->map(
                fn (int $i) => \App\Support\KamaliMedia::projectCover(null, (int) $project->id + $i)
            )->values();
        } else {
            $sliderImages = $images
                ->map(function ($img) {
                    if (is_string($img) && (str_starts_with($img, 'http') || str_starts_with($img, '/'))) {
                        return $img;
                    }

                    return asset('storage/' . ltrim((string) $img, '/'));
                })
                ->values();
        }

        $heroSrc = $sliderImages->first();
        $description = trim((string) ($project->description ?? ''));
        $leadExcerpt = $description !== '' ? \Illuminate\Support\Str::limit($description, 280, '…') : '';
        $hasMoreCopy = $description !== '' && mb_strlen($description) > 280;

        $categoryLabel = match ($project->category) {
            'residential' => 'Residential',
            'commercial' => 'Commercial',
            'civic' => 'Civic',
            default => ucfirst((string) $project->category),
        };

        $portfolioChain = \App\Models\Project::query()
            ->orderByDesc('sort_order')
            ->orderByDesc('year')
            ->orderBy('title')
            ->get();

        $navIx = $portfolioChain->search(fn ($p) => $p->id === $project->id);
        $navPrev = $navIx !== false && $navIx > 0 ? $portfolioChain->get($navIx - 1) : null;
        $navNext = $navIx !== false && $navIx < $portfolioChain->count() - 1 ? $portfolioChain->get($navIx + 1) : null;

        $ogDescription = \Illuminate\Support\Str::limit(strip_tags($description !== '' ? $description : ($project->description ?? '')), 200);

        $jsonLd = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'CreativeWork',
            'name' => $project->title,
            'description' => \Illuminate\Support\Str::limit(strip_tags($project->description ?? ''), 1200),
            'url' => url()->current(),
            'image' => $sliderImages->take(12)->values()->all(),
            'dateCreated' => $project->year ? (string) $project->year : null,
            'locationCreated' => $project->location
                ? ['@type' => 'Place', 'name' => $project->location]
                : null,
        ]);
    @endphp

    @push('head')
        <link rel="canonical" href="{{ url()->current() }}" />
        <meta property="og:title" content="{{ $project->title }} — Kamali Architects" />
        <meta property="og:description" content="{{ $ogDescription }}" />
        <meta property="og:image" content="{{ $sliderImages->first() }}" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="{{ $project->title }} — Kamali Architects" />
        <meta name="twitter:description" content="{{ $ogDescription }}" />
        <meta name="twitter:image" content="{{ $sliderImages->first() }}" />
        <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) !!}</script>
    @endpush

    {{-- Hero: full-bleed image, editorial type, blends into next section --}}
    <section class="relative min-h-[78svh] overflow-hidden bg-dark text-cream sm:min-h-[82svh] lg:min-h-[85svh]">
        <div class="absolute inset-0" aria-hidden="true">
            <img
                src="{{ $heroSrc }}"
                alt=""
                class="h-full w-full object-cover"
                fetchpriority="high"
            />
            <div class="absolute inset-0 bg-gradient-to-b from-dark/45 via-dark/55 to-dark/88"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-dark via-transparent to-transparent opacity-95"></div>
        </div>

        <div class="container-wide relative flex min-h-[78svh] flex-col pb-12 pt-[calc(4.25rem+2rem)] sm:min-h-[82svh] sm:pb-16 sm:pt-28 md:pt-36 lg:min-h-[85svh] lg:pb-20">
            <nav class="flex flex-wrap items-center gap-x-3 gap-y-2 text-sm text-cream/65" aria-label="Breadcrumb" data-animate="fade-up">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 hover:text-cream">
                    <span aria-hidden="true">←</span> Projects
                </a>
                <span class="text-cream/35" aria-hidden="true">/</span>
                <span class="text-cream/80">{{ $project->location }}</span>
            </nav>

            <div class="mt-auto grid gap-8 sm:gap-10 lg:grid-cols-12 lg:items-end lg:gap-10">
                <div class="lg:col-span-8" data-animate="fade-up">
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                        <span class="label text-cream/60">· Project</span>
                        <span
                            class="inline-flex items-center rounded-full border border-cream/15 bg-cream/10 px-3 py-1 text-[10px] font-medium uppercase tracking-[0.18em] text-cream/90 sm:text-[11px]"
                        >
                            {{ $categoryLabel }}
                        </span>
                        @if ($project->status === 'under_construction')
                            <span
                                class="inline-flex items-center rounded-full border border-gold/35 bg-gold/15 px-3 py-1 text-[10px] font-medium uppercase tracking-[0.18em] text-cream sm:text-[11px]"
                            >
                                In progress
                            </span>
                        @endif
                    </div>
                    <h1 class="mt-4 max-w-4xl font-display text-[2rem] leading-[0.98] tracking-tight text-cream sm:mt-5 sm:text-5xl md:text-6xl lg:text-[3.35rem]">
                        {{ $project->title }}
                    </h1>
                    <p class="mt-4 flex flex-wrap items-baseline gap-x-3 gap-y-1 text-[14px] text-cream/70 sm:text-base">
                        <span class="font-medium text-cream/90">{{ $project->location }}</span>
                        @if ($project->year)
                            <span class="text-cream/40">·</span>
                            <span class="tabular-nums">{{ $project->year }}</span>
                        @endif
                    </p>
                    @if ($leadExcerpt !== '')
                        <p class="mt-6 max-w-2xl border-l-2 border-gold/50 pl-4 text-[14.5px] leading-relaxed text-cream/80 sm:mt-8 sm:pl-5 sm:text-base">
                            {{ $leadExcerpt }}
                        </p>
                    @endif
                </div>

                <aside class="lg:col-span-4" data-animate="fade-up">
                    <div
                        class="rounded-2xl border border-cream/12 bg-dark/50 p-6 shadow-[0_24px_80px_rgba(0,0,0,0.35)] backdrop-blur-md sm:rounded-3xl sm:p-7 md:p-8"
                    >
                        <p class="label text-cream/50">At a glance</p>
                        <dl class="mt-6 space-y-4 text-sm">
                            <div class="flex justify-between gap-6 border-b border-cream/10 pb-4">
                                <dt class="text-cream/55">Client</dt>
                                <dd class="max-w-[60%] text-right font-medium text-cream">{{ $project->client_name ?: '—' }}</dd>
                            </div>
                            <div class="flex justify-between gap-6 border-b border-cream/10 pb-4">
                                <dt class="text-cream/55">Area</dt>
                                <dd class="tabular-nums text-cream">{{ $project->surface_area ? $project->surface_area . ' m²' : '—' }}</dd>
                            </div>
                            <div class="flex justify-between gap-6 border-b border-cream/10 pb-4">
                                <dt class="text-cream/55">Lead architect</dt>
                                <dd class="max-w-[60%] text-right text-cream">{{ $project->architect_name ?: '—' }}</dd>
                            </div>
                            <div class="flex justify-between gap-6">
                                <dt class="text-cream/55">Status</dt>
                                <dd class="font-medium text-cream">{{ $project->status === 'finished' ? 'Complete' : 'In progress' }}</dd>
                            </div>
                        </dl>
                        <a
                            href="{{ route('contact') }}#contact-form"
                            class="btn btn-gold mt-8 w-full justify-center"
                        >
                            Discuss a similar project →
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @if ($hasMoreCopy)
        <section class="relative border-t border-dark/[0.06] bg-cream">
            <div class="pointer-events-none absolute inset-0 grain-soft opacity-[0.09] mix-blend-multiply" aria-hidden="true"></div>
            <div class="container-wide relative z-[1] py-16 md:py-20">
                <div class="mx-auto max-w-3xl" data-animate="fade-up">
                    <p class="label text-dark/50">· Narrative</p>
                    <h2 class="mt-3 font-display text-3xl tracking-tight text-dark md:text-4xl">Overview</h2>
                    <div class="prose-project mt-8 text-[17px] leading-[1.75] text-dark/75 md:text-lg">
                        {!! nl2br(e($description)) !!}
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Gallery: spotlight + mosaic layouts, lightbox zoom & swipe --}}
    <section class="border-t border-dark/[0.06] bg-cream">
        <div
            class="container-wide py-16 md:py-20"
            data-gallery-root
            x-data="projectGallery({ images: {{ Illuminate\Support\Js::from($sliderImages) }} })"
            @keydown.window="onKeydown($event)"
        >
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between" data-animate="fade-up">
                <div class="min-w-0">
                    <p class="label text-dark/55">· Visual study</p>
                    <h2 class="mt-2 font-display text-3xl text-dark md:text-4xl">Gallery</h2>
                    <p class="mt-3 max-w-xl text-[15px] leading-relaxed text-dark/60 md:text-base">
                        <strong class="font-medium text-dark/80">Spotlight</strong> for sequence &amp; strip —
                        <strong class="font-medium text-dark/80">Mosaic</strong> for an editorial board. Tap any image to open the viewer; pinch-friendly zoom inside.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <div
                        class="inline-flex rounded-full border border-dark/10 bg-white/80 p-1 shadow-sm backdrop-blur-sm"
                        role="group"
                        aria-label="Gallery layout"
                    >
                        <button
                            type="button"
                            class="rounded-full px-4 py-2 text-xs font-medium uppercase tracking-[0.14em] transition"
                            :class="view === 'stage' ? 'bg-dark text-cream' : 'text-dark/60 hover:text-dark'"
                            @click="view = 'stage'"
                        >
                            Spotlight
                        </button>
                        <button
                            type="button"
                            class="rounded-full px-4 py-2 text-xs font-medium uppercase tracking-[0.14em] transition"
                            :class="view === 'mosaic' ? 'bg-dark text-cream' : 'text-dark/60 hover:text-dark'"
                            @click="view = 'mosaic'"
                        >
                            Mosaic
                        </button>
                    </div>
                    <span class="text-sm tabular-nums text-dark/50"><span x-text="i + 1"></span> / <span x-text="images.length"></span></span>
                </div>
            </div>

            <div class="mt-10 grid gap-8 lg:grid-cols-12 lg:gap-10" data-animate="fade-up">
                <div class="min-w-0 lg:col-span-8 xl:col-span-9">
                    {{-- Spotlight --}}
                    <div x-show="view === 'stage'" x-transition.opacity.duration.200ms>
                        <div
                            class="group relative overflow-hidden rounded-3xl border border-dark/10 bg-dark shadow-[0_32px_90px_rgba(26,26,24,0.12)]"
                            @touchstart.passive="onStageTouchStart"
                            @touchend.passive="onStageTouchEnd"
                        >
                            <template x-for="(src, idx) in images" :key="'stage-' + idx + src">
                                <button
                                    type="button"
                                    class="absolute inset-0 block w-full outline-none focus-visible:ring-2 focus-visible:ring-gold/50 focus-visible:ring-offset-2 focus-visible:ring-offset-cream"
                                    x-show="i === idx"
                                    x-transition:enter="transition ease-out duration-500"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-450"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    @click="openAt(i)"
                                    aria-label="Expand photograph"
                                >
                                    <img
                                        class="gallery-stage-img h-[min(56vh,520px)] w-full object-cover sm:h-[min(68vh,720px)] md:h-[min(72vh,780px)]"
                                        :src="src"
                                        alt=""
                                        decoding="async"
                                        fetchpriority="low"
                                    />
                                </button>
                            </template>

                            <div
                                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-dark/65 via-dark/0 to-dark/25 opacity-80"
                                aria-hidden="true"
                            ></div>

                            <div class="pointer-events-none absolute inset-x-0 bottom-0 flex items-end justify-between gap-3 p-4 sm:p-6">
                                <div
                                    class="pointer-events-auto inline-flex items-center gap-2 rounded-full border border-cream/15 bg-dark/60 px-3 py-1.5 text-[11px] font-medium text-cream/95 backdrop-blur-md sm:px-4 sm:py-2 sm:text-xs"
                                >
                                    <span class="text-gold" aria-hidden="true">●</span>
                                    <span class="tabular-nums" x-text="`Frame ${i + 1}`"></span>
                                </div>
                                <div class="pointer-events-auto flex gap-2">
                                    <button
                                        type="button"
                                        class="flex h-10 w-10 items-center justify-center rounded-full border border-cream/20 bg-dark/65 text-base text-cream backdrop-blur-md transition hover:bg-dark/80 sm:h-11 sm:w-11 sm:text-lg"
                                        @click.stop="prev()"
                                        aria-label="Previous image"
                                    >
                                        ←
                                    </button>
                                    <button
                                        type="button"
                                        class="flex h-10 w-10 items-center justify-center rounded-full border border-cream/20 bg-dark/65 text-base text-cream backdrop-blur-md transition hover:bg-dark/80 sm:h-11 sm:w-11 sm:text-lg"
                                        @click.stop="next()"
                                        aria-label="Next image"
                                    >
                                        →
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-5 flex gap-3 overflow-x-auto overscroll-x-contain pb-2 pt-1 [-webkit-overflow-scrolling:touch]"
                        >
                            <template x-for="(src, idx) in images" :key="'thumb-' + idx + src">
                                <button
                                    type="button"
                                    class="relative shrink-0 overflow-hidden rounded-2xl border-2 transition"
                                    :class="i === idx ? 'border-gold shadow-[0_0_0_1px_rgba(201,168,76,0.35)]' : 'border-transparent hover:border-dark/20'"
                                    @click="i = idx"
                                    :aria-current="i === idx ? 'true' : 'false'"
                                    :aria-label="`Show image ${idx + 1}`"
                                >
                                    <img
                                        class="h-[4.5rem] w-[6.25rem] object-cover sm:h-24 sm:w-32"
                                        :src="src"
                                        alt=""
                                        loading="lazy"
                                        decoding="async"
                                    />
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Mosaic board --}}
                    <div
                        x-show="view === 'mosaic'"
                        x-transition.opacity.duration.200ms
                        class="grid grid-flow-dense grid-cols-2 gap-3 sm:gap-4"
                    >
                        <template x-for="(src, idx) in images" :key="'mosaic-' + idx + src">
                            <button
                                type="button"
                                :class="mosaicClass(idx, images.length)"
                                @click="openAt(idx)"
                            >
                                <span class="block h-full min-h-0 w-full overflow-hidden">
                                    <img
                                        class="gallery-mosaic-img h-full min-h-[140px] w-full object-cover"
                                        :src="src"
                                        alt=""
                                        loading="lazy"
                                        decoding="async"
                                    />
                                </span>
                                <span
                                    class="pointer-events-none absolute inset-0 bg-gradient-to-t from-dark/55 via-transparent to-transparent opacity-0 transition duration-300 motion-safe:group-hover:opacity-100"
                                    aria-hidden="true"
                                ></span>
                                <span
                                    class="pointer-events-none absolute bottom-3 left-3 rounded-full border border-cream/20 bg-dark/55 px-2.5 py-1 text-[10px] font-medium uppercase tracking-wider text-cream opacity-0 backdrop-blur-sm transition duration-300 motion-safe:group-hover:opacity-100"
                                    x-text="`Frame ${String(idx + 1).padStart(2, '0')}`"
                                ></span>
                            </button>
                        </template>
                    </div>
                </div>

                <aside class="lg:col-span-4 xl:col-span-3">
                    <div
                        class="sticky top-28 rounded-3xl border border-dark/10 bg-white/80 p-7 shadow-[0_2px_48px_rgba(26,26,24,0.06)] backdrop-blur-md md:p-8"
                    >
                        <p class="label text-dark/45">Viewer</p>
                        <p class="mt-4 text-[15px] leading-relaxed text-dark/70">
                            Open any photo for a dimmed full-screen view. Use
                            <kbd class="rounded border border-dark/15 bg-cream px-1.5 py-0.5 font-sans text-xs">+</kbd>
                            /
                            <kbd class="rounded border border-dark/15 bg-cream px-1.5 py-0.5 font-sans text-xs">−</kbd>
                            to zoom,
                            <kbd class="rounded border border-dark/15 bg-cream px-1.5 py-0.5 font-sans text-xs">0</kbd>
                            to reset. Swipe left or right on mobile to change frames.
                        </p>
                        <div class="mt-8 grid grid-cols-2 gap-3">
                            <div class="rounded-2xl border border-dark/10 bg-cream/80 px-4 py-4">
                                <p class="label text-dark/45">Frames</p>
                                <p class="mt-1 font-display text-2xl tabular-nums text-dark" x-text="images.length"></p>
                            </div>
                            <div class="rounded-2xl border border-dark/10 bg-cream/80 px-4 py-4">
                                <p class="label text-dark/45">Status</p>
                                <p class="mt-1 font-medium text-dark">{{ $project->status === 'finished' ? 'Built' : 'On site' }}</p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            {{-- Lightbox --}}
            <div
                x-cloak
                x-show="open"
                x-transition.opacity
                class="fixed inset-0 z-[90] flex items-center justify-center p-3 sm:p-8"
                role="dialog"
                aria-modal="true"
                aria-label="Expanded photographs"
            >
                <div class="absolute inset-0 bg-dark/92 backdrop-blur-md" @click="closeLightbox()"></div>
                <div class="relative z-[1] flex w-full max-w-6xl flex-col" @click.stop>
                    <div class="mb-3 flex flex-wrap items-center justify-between gap-3 sm:mb-4">
                        <p class="text-sm tabular-nums text-cream/75">
                            <span x-text="i + 1"></span> / <span x-text="images.length"></span>
                            <span class="ml-3 text-cream/45" x-show="zoom > 1" x-text="Math.round(zoom * 100) + '%'"></span>
                        </p>
                        <div class="flex flex-wrap items-center gap-2">
                            <button
                                type="button"
                                class="rounded-full border border-cream/20 bg-dark/45 px-3 py-2 text-xs font-medium text-cream backdrop-blur-md transition hover:bg-cream/10"
                                @click="zoomOut()"
                                aria-label="Zoom out"
                            >
                                −
                            </button>
                            <button
                                type="button"
                                class="rounded-full border border-cream/20 bg-dark/45 px-3 py-2 text-xs font-medium text-cream backdrop-blur-md transition hover:bg-cream/10"
                                @click="resetZoom()"
                                aria-label="Reset zoom"
                            >
                                100%
                            </button>
                            <button
                                type="button"
                                class="rounded-full border border-cream/20 bg-dark/45 px-3 py-2 text-xs font-medium text-cream backdrop-blur-md transition hover:bg-cream/10"
                                @click="zoomIn()"
                                aria-label="Zoom in"
                            >
                                +
                            </button>
                            <button
                                type="button"
                                class="rounded-full border border-cream/25 bg-dark/50 px-5 py-2.5 text-sm font-medium text-cream backdrop-blur-md transition hover:bg-cream/10"
                                @click="closeLightbox()"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                    <div class="relative overflow-hidden rounded-3xl border border-cream/10 bg-dark/60 shadow-2xl">
                        <div
                            class="relative flex max-h-[min(82vh,900px)] min-h-[180px] w-full touch-pan-x touch-pan-y overflow-auto overscroll-contain sm:max-h-[min(84vh,920px)]"
                            @touchstart.passive="onLbTouchStart"
                            @touchend.passive="onLbTouchEnd"
                        >
                            <img
                                class="mx-auto max-h-none min-h-[min(70vh,760px)] w-auto max-w-[min(100%,1400px)] select-none object-contain transition-transform duration-200 ease-out"
                                :src="images[i]"
                                alt="Project photograph enlarged"
                                decoding="async"
                                draggable="false"
                                :style="{ transform: `scale(${zoom})`, transformOrigin: 'center center' }"
                            />
                        </div>
                        <button
                            type="button"
                            class="absolute left-2 top-1/2 z-[2] flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-cream/25 bg-dark/75 text-cream backdrop-blur-md transition hover:bg-dark sm:left-4 sm:h-12 sm:w-12"
                            @click="prev()"
                            aria-label="Previous frame"
                        >
                            ←
                        </button>
                        <button
                            type="button"
                            class="absolute right-2 top-1/2 z-[2] flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-cream/25 bg-dark/75 text-cream backdrop-blur-md transition hover:bg-dark sm:right-4 sm:h-12 sm:w-12"
                            @click="next()"
                            aria-label="Next frame"
                        >
                            →
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($navPrev || $navNext)
        <section class="border-t border-gold/20 bg-dark text-cream" aria-label="Adjacent projects">
            <div class="container-wide py-14 md:py-16">
                <p class="label text-cream/45" data-animate="fade-up">· Through the portfolio</p>
                <div class="mt-8 grid gap-10 md:grid-cols-2 md:gap-12" data-animate="fade-up">
                    <div class="min-w-0">
                        @if ($navPrev)
                            <a
                                href="{{ route('projects.show', ['slug' => $navPrev->slug]) }}"
                                class="group block rounded-3xl border border-cream/10 bg-cream/[0.04] p-6 transition hover:border-gold/35 hover:bg-cream/[0.07] md:p-8"
                            >
                                <span class="label text-cream/50">Previous project</span>
                                <span class="mt-3 block font-display text-2xl leading-snug text-cream transition group-hover:text-gold md:text-3xl">
                                    {{ $navPrev->title }}
                                </span>
                                <span class="mt-4 inline-flex items-center gap-2 text-sm text-gold/90">
                                    <span aria-hidden="true">←</span> Back
                                </span>
                            </a>
                        @endif
                    </div>
                    <div class="min-w-0 md:text-right">
                        @if ($navNext)
                            <a
                                href="{{ route('projects.show', ['slug' => $navNext->slug]) }}"
                                class="group block rounded-3xl border border-cream/10 bg-cream/[0.04] p-6 transition hover:border-gold/35 hover:bg-cream/[0.07] md:ml-auto md:max-w-xl md:p-8"
                            >
                                <span class="label text-cream/50">Next project</span>
                                <span class="mt-3 block font-display text-2xl leading-snug text-cream transition group-hover:text-gold md:text-3xl">
                                    {{ $navNext->title }}
                                </span>
                                <span class="mt-4 inline-flex items-center gap-2 text-sm text-gold/90 md:justify-end">
                                    Forward <span aria-hidden="true">→</span>
                                </span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Related --}}
    <section class="border-t border-dark/[0.06] bg-cream">
        <div class="container-wide pb-24 pt-16 md:pb-28 md:pt-20">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between" data-animate="fade-up">
                <div>
                    <p class="label text-dark/55">· Continue exploring</p>
                    <h2 class="mt-2 font-display text-3xl text-dark md:text-4xl">Related work</h2>
                    <p class="mt-3 max-w-lg text-[15px] text-dark/60">Same category — different sites and scales.</p>
                </div>
                <a class="inline-flex items-center gap-2 text-dark hover:text-dark/70" href="{{ route('projects.index') }}">
                    <span class="label text-dark/55">All projects</span>
                    <span class="text-gold">→</span>
                </a>
            </div>

            <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($related as $idx => $p)
                    <a
                        href="{{ route('projects.show', ['slug' => $p->slug]) }}"
                        class="group overflow-hidden rounded-3xl border border-dark/10 bg-white/75 shadow-[0_2px_40px_rgba(26,26,24,0.05)] backdrop-blur-sm transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_60px_rgba(26,26,24,0.1)]"
                        data-animate="fade-up"
                    >
                        <div class="relative aspect-[16/10] overflow-hidden">
                            <img
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]"
                                src="{{ \App\Support\KamaliMedia::projectCover($p->cover_image, (int) $idx) }}"
                                alt="{{ $p->title }}"
                                loading="lazy"
                                decoding="async"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-dark/50 via-transparent to-transparent opacity-80"></div>
                            <div class="absolute inset-x-0 bottom-0 h-0.5 origin-left scale-x-0 bg-gold transition duration-300 group-hover:scale-x-100"></div>
                        </div>
                        <div class="p-7">
                            <p class="label text-dark/45">{{ $p->location }}</p>
                            <p class="mt-3 font-display text-2xl leading-snug text-dark">{{ $p->title }}</p>
                            @if ($p->year)
                                <p class="mt-2 text-sm tabular-nums text-dark/50">{{ $p->year }}</p>
                            @endif
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-dark/60">No other projects in this category yet.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
