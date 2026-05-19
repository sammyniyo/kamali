@extends('layouts.app')

@section('title', 'Kamali Architects — Luxury Architecture Studio')
@section('meta_description', 'Kamali Architects — luxury editorial architecture and design. Explore featured projects, expertise, and the team.')

@section('content')
    @php
        $slides = [
            [
                'src' => asset('images/renders/mansion-symmetry.png'),
                'title' => 'Twin Atelier Residence',
                'meta' => 'Residential · evening study',
            ],
            [
                'src' => asset('images/renders/apartments-rooftop.png'),
                'title' => 'Skyline Court Apartments',
                'meta' => 'Mixed-use · rooftop terrace',
            ],
            [
                'src' => asset('images/renders/villa-greenwall.png'),
                'title' => 'Verdant Wall Villa',
                'meta' => 'Residential · green facade',
            ],
        ];
    @endphp

    <section
        class="relative min-h-[100svh] overflow-hidden bg-dark text-cream"
        x-data="{
            i: 0,
            t: null,
            slides: {{ Illuminate\Support\Js::from($slides) }},
            init() {
                this.play();
                this.$watch('i', () => {
                    if (this.t) {
                        clearInterval(this.t);
                        this.play();
                    }
                });
            },
            play() {
                if (window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches) return;
                this.t = setInterval(() => this.next(), 7000);
            },
            stop() {
                if (this.t) clearInterval(this.t);
                this.t = null;
            },
            next() {
                this.i = (this.i + 1) % this.slides.length;
            },
            prev() {
                this.i = (this.i - 1 + this.slides.length) % this.slides.length;
            },
        }"
        @mouseenter="stop()"
        @mouseleave="play()"
    >
        <div class="absolute inset-0" aria-hidden="true">
            <template x-for="(s, idx) in slides" :key="s.src">
                <div
                    data-parallax="hero"
                    class="absolute inset-0 will-change-transform"
                    :style="`background-image:url('${s.src}'); background-size:cover; background-position:center; transform: translate3d(0, var(--parallax-y, 0px), 0);`"
                    x-show="i === idx"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 scale-[1.02]"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-700"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-[1.01]"
                ></div>
            </template>
            <div class="absolute inset-0 overlay-gradient"></div>
        </div>

        {{-- Clear fixed header: mobile main row 4.25rem; md+ adds utility bar (h-9) + main row (4.75rem) --}}
        <div class="container-wide relative pb-16 pt-[calc(4.25rem+2.5rem)] sm:pb-20 md:pt-[calc(7rem+2.5rem)] lg:pt-40">
            <div class="grid gap-10 lg:grid-cols-12 lg:items-start">
                <div class="lg:col-span-7">
                    <div class="label text-cream/70" data-animate="fade-up">· Architecture & Design</div>
                    <h1
                        class="mt-4 font-display text-[clamp(34px,9.5vw,86px)] leading-[0.98] text-cream"
                        data-animate="fade-up"
                    >
                        Building<br />
                        <span class="italic text-gold">Beyond</span>
                    </h1>
                    <p class="mt-5 max-w-xl text-cream/80 text-sm sm:text-base leading-relaxed" data-animate="fade-up">
                        A studio grounded in detail, proportion, and atmosphere — crafting spaces that feel inevitable, timeless, and quietly bold.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3 sm:gap-4 sm:items-center" data-animate="fade-up">
                        <a href="{{ route('projects.index') }}" class="btn btn-gold w-full sm:w-auto justify-center">View Projects →</a>
                        <a href="{{ route('about') }}" class="btn btn-outline w-full sm:w-auto justify-center">Our Story</a>
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row sm:items-center gap-5 sm:gap-6" data-animate="fade-up">
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                class="inline-flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-full border border-cream/20 bg-dark/30 text-cream hover:bg-dark/50 transition"
                                @click="prev()"
                                aria-label="Previous slide"
                            >
                                ←
                            </button>
                            <button
                                type="button"
                                class="inline-flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-full border border-cream/20 bg-dark/30 text-cream hover:bg-dark/50 transition"
                                @click="next()"
                                aria-label="Next slide"
                            >
                                →
                            </button>
                        </div>

                        <div class="flex items-center gap-2">
                            <template x-for="(s, idx) in slides" :key="s.src + '_dot'">
                                <button
                                    type="button"
                                    class="h-2 rounded-full transition-all duration-300"
                                    :class="i === idx ? 'w-9 bg-gold' : 'w-4 bg-cream/30 hover:bg-cream/45'"
                                    @click="i = idx"
                                    :aria-label="`Go to slide ${idx + 1}`"
                                ></button>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 lg:pt-10 hidden lg:block">
                    <div class="card bg-dark/55 border-cream/10 p-8 anim-floaty" data-animate="fade-up">
                        <div class="label text-cream/60">Featured</div>
                        <div class="mt-3 font-display text-2xl text-cream leading-snug">
                            <span x-text="slides[i]?.title"></span>
                        </div>
                        <p class="mt-3 text-sm text-cream/70 leading-relaxed">
                            <span class="text-gold">•</span>
                            <span x-text="slides[i]?.meta"></span>
                        </p>
                        <p class="mt-4 text-sm text-cream/70 leading-relaxed">
                            Architecture can mean the art of shaping light, silence, and structure into a place you want to return to.
                        </p>
                        <a class="mt-6 inline-flex items-center gap-2 text-cream hover:text-cream/80" href="{{ route('projects.index') }}">
                            <span class="label text-cream/60">Explore Projects</span>
                            <span class="text-gold">→</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-cream/70 hidden sm:block">
                <div class="flex flex-col items-center gap-2">
                    <div class="label text-cream/60">Scroll</div>
                    <div class="animate-bounce text-gold text-xl">⌄</div>
                </div>
            </div>
        </div>

    </section>

    <section class="bg-dark text-cream" data-stats-strip>
        <div class="container-wide py-8 sm:py-10">
            <div class="grid grid-cols-2 gap-x-4 gap-y-6 sm:gap-8 md:grid-cols-4">
                @foreach (\App\Support\StudioStats::forHomepage() as $stat)
                    <div class="border-l border-cream/10 pl-4 sm:pl-5" data-animate="fade-up">
                        <div
                            class="font-display text-[1.75rem] sm:text-3xl md:text-[2rem] text-cream tabular-nums"
                            data-stat-value="{{ $stat['value'] }}"
                            data-stat-suffix="{{ $stat['suffix'] }}"
                        >
                            <span data-stat-display>{{ $stat['value'] }}{{ $stat['suffix'] }}</span>
                        </div>
                        <div class="label mt-2 text-cream/50">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-cream">
        <div class="container-wide section-pad">
            <div class="grid gap-8 sm:gap-10 lg:grid-cols-12 lg:items-center lg:gap-12">
                <div class="lg:col-span-6" data-animate="fade-up">
                    <div class="relative overflow-hidden rounded-2xl border border-gold/40">
                        <img
                            class="aspect-[4/3] w-full object-cover"
                            src="{{ asset('images/renders/villa-evening.png') }}"
                            alt="Modern villa, evening study"
                            loading="lazy"
                        />
                        <div class="absolute inset-0 ring-1 ring-gold/40 rounded-2xl" aria-hidden="true"></div>
                    </div>
                </div>
                <div class="lg:col-span-6">
                    <p class="label" data-animate="fade-up">· About Us</p>
                    <h2 class="mt-3 h-section text-dark" data-animate="fade-up">
                        A calm practice — shaping places with restraint, craft, and atmosphere.
                    </h2>
                    <p class="mt-5 text-[15px] leading-relaxed text-dark/70 sm:text-base" data-animate="fade-up">
                        Kamali Architects is a luxury editorial studio for high-end residential, commercial, and civic work — clear concepts, disciplined detail,
                        from feasibility through construction administration.
                    </p>
                    <a class="mt-6 inline-flex items-center gap-2 text-dark hover:text-dark/70" href="{{ route('about') }}" data-animate="fade-up">
                        <span class="label text-dark/60">Learn More</span>
                        <span class="text-gold">→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-cream">
        <div class="container-wide pb-14 sm:pb-16 md:pb-20">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between sm:gap-6" data-animate="fade-up">
                <div class="min-w-0">
                    <p class="label">Recent</p>
                    <h2 class="mt-2 h-section text-dark">
                        Projects <span class="italic text-dark/60">Selected</span>
                    </h2>
                </div>
                <a class="inline-flex items-center gap-2 text-dark hover:text-dark/70" href="{{ route('projects.index') }}">
                    <span class="label text-dark/60">View All</span>
                    <span class="text-gold">→</span>
                </a>
            </div>

            @php
                $recent = \App\Models\Project::query()->orderByDesc('year')->orderBy('sort_order')->limit(3)->get();
            @endphp
            <div class="mt-8 grid gap-6 sm:gap-7 md:mt-10 md:grid-cols-2 lg:grid-cols-3">
                @if ($recent->isEmpty())
                    <x-empty-state
                        class="md:col-span-2 lg:col-span-3"
                        heading="No projects available yet"
                        body="We’re preparing our portfolio. Reach out if you’d like to discuss a new commission."
                        action-text="Contact us"
                        :action-href="route('contact')"
                    />
                @else
                    @foreach ($recent as $idx => $p)
                        @php
                            $coverSrc = \App\Support\KamaliMedia::projectCover($p->cover_image, $idx);
                        @endphp
                        <a
                            href="{{ route('projects.show', ['slug' => $p->slug]) }}"
                            class="group overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur transition duration-300 hover:-translate-y-1"
                            data-animate="fade-up"
                        >
                            <div class="relative overflow-hidden">
                                <img
                                    class="aspect-video w-full object-cover transition duration-500 group-hover:scale-[1.05]"
                                    src="{{ $coverSrc }}"
                                    alt="{{ $p->title }}"
                                    loading="lazy"
                                    decoding="async"
                                />
                                <div class="absolute inset-x-0 bottom-0 h-1 bg-gold/0 transition duration-300 group-hover:bg-gold"></div>
                            </div>
                            <div class="p-6">
                                <div class="label text-dark/50">
                                    <span class="text-gold">•</span>
                                    {{ $p->location }}
                                </div>
                                <div class="mt-3 font-display text-2xl text-dark">{{ $p->title }}</div>
                                <div class="mt-4 inline-flex items-center gap-2 rounded-full border border-dark/10 px-3 py-1 text-xs text-dark/70">
                                    {{ ucfirst($p->category) }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    @include('partials.services-detail-section', [
        'servicesSectionExtraClass' => 'border-t border-dark/[0.06]',
        'servicesHomeHeader' => true,
        'servicesLayout' => 'cards',
    ])

    <section class="border-t border-dark/[0.06] bg-cream">
        <div class="container-wide section-pad">
            <p class="label" data-animate="fade-up">· Our Architects</p>
            <h2 class="mt-2 h-section text-dark" data-animate="fade-up">Team</h2>

            @php
                $team = \App\Models\TeamMember::query()->orderBy('sort_order')->limit(5)->get();
            @endphp

            @if ($team->isEmpty())
                <x-empty-state
                    class="mt-8 md:mt-10"
                    heading="No team profiles yet"
                    body="Our architects will appear here soon. Contact the studio if you’d like to connect with the practice."
                    action-text="Contact us"
                    :action-href="route('contact')"
                    data-animate="fade-up"
                />
            @else
            <div class="mt-8 overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur md:mt-10" data-animate="fade-up">
                <div class="hidden border-b border-dark/10 px-6 py-4 text-xs uppercase tracking-[0.34em] text-dark/50 sm:grid sm:grid-cols-12 sm:gap-4">
                    <div class="sm:col-span-5">Architect</div>
                    <div class="sm:col-span-5">Role</div>
                    <div class="sm:col-span-2 sm:text-right">Profile</div>
                </div>
                @foreach ($team as $m)
                    <div x-data="{ open: false }" class="flex flex-col gap-3 border-b border-dark/10 px-5 py-5 last:border-b-0 sm:grid sm:grid-cols-12 sm:gap-4 sm:px-6">
                        <div class="flex items-center gap-4 sm:col-span-5">
                            <div class="h-11 w-11 shrink-0 overflow-hidden rounded-full bg-dark/10">
                                <img class="h-full w-full object-cover" src="{{ \App\Support\KamaliMedia::teamPhoto($m->photo) }}" alt="{{ $m->name }}" loading="lazy" />
                            </div>
                            <div class="min-w-0">
                                <div class="font-medium text-dark">{{ $m->name }}</div>
                                <div class="text-sm text-dark/60 sm:hidden">{{ $m->role }}</div>
                            </div>
                        </div>
                        <div class="hidden text-dark/70 sm:col-span-5 sm:flex sm:items-center">{{ $m->role }}</div>
                        <div class="flex sm:col-span-2 sm:items-center sm:justify-end">
                            <button
                                type="button"
                                class="inline-flex items-center gap-2 rounded-full -mr-2 px-2 py-2 text-dark hover:text-dark/70 focus:outline-none focus:ring-2 focus:ring-gold/25"
                                @click="open = true"
                                :aria-expanded="open.toString()"
                                aria-haspopup="dialog"
                            >
                                <span class="label text-dark/60">View details</span>
                                <span class="text-gold">→</span>
                            </button>
                        </div>

                        <template x-teleport="body">
                            <div
                                x-show="open"
                                x-transition.opacity
                                class="fixed inset-0 z-[90] flex items-center justify-center p-6"
                                role="dialog"
                                aria-modal="true"
                                aria-label="Team member details"
                                @keydown.escape.window="open = false"
                            >
                                <div class="absolute inset-0 bg-dark/70 backdrop-blur-[2px]" @click="open = false" aria-hidden="true"></div>

                                <div
                                    x-show="open"
                                    x-transition:enter="transition ease-out duration-220"
                                    x-transition:enter-start="opacity-0 translate-y-2 scale-[0.99]"
                                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave="transition ease-in duration-180"
                                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-2 scale-[0.99]"
                                    class="relative w-full max-w-2xl overflow-hidden rounded-3xl border border-cream/10 bg-dark text-cream shadow-2xl"
                                    @click.stop
                                >
                                <div class="flex items-center justify-between border-b border-cream/10 px-7 py-5">
                                    <div>
                                        <div class="font-display text-2xl">{{ $m->name }}</div>
                                        <div class="mt-1 text-sm text-cream/70">{{ $m->role }}</div>
                                    </div>
                                    <button
                                        type="button"
                                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-cream/15 bg-dark/40 text-cream hover:bg-cream/5 transition focus:outline-none focus:ring-2 focus:ring-gold/25"
                                        @click="open = false"
                                        aria-label="Close"
                                    >
                                        ✕
                                    </button>
                                </div>

                                <div class="grid gap-0 md:grid-cols-12">
                                    <div class="md:col-span-5 border-b border-cream/10 md:border-b-0 md:border-r">
                                        <div class="aspect-[4/3] bg-cream/5">
                                            <img class="h-full w-full object-cover" src="{{ \App\Support\KamaliMedia::teamPhoto($m->photo) }}" alt="{{ $m->name }}" loading="lazy" />
                                        </div>
                                    </div>
                                    <div class="md:col-span-7 p-7">
                                        <div class="label text-cream/55">Bio</div>
                                        <p class="mt-4 text-cream/80 leading-relaxed">
                                            {{ $m->bio ?: '—' }}
                                        </p>

                                        <div class="mt-6 flex flex-wrap items-center gap-4">
                                            @if ($m->linkedin_url)
                                                <a class="btn btn-outline" href="{{ $m->linkedin_url }}" target="_blank" rel="noreferrer">
                                                    LinkedIn <span class="text-cream/70">↗</span>
                                                </a>
                                            @endif
                                            <a class="btn btn-gold" href="{{ route('contact') }}">Work with us →</a>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </template>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    <section class="relative overflow-hidden bg-dark text-cream">
        <div
            class="absolute inset-0"
            style="
                background-image: url('{{ asset('images/renders/apartments-rooftop.png') }}');
                background-size: cover;
                background-position: center;
            "
            aria-hidden="true"
        ></div>
        <div class="absolute inset-0 bg-dark/70" aria-hidden="true"></div>
        <div class="container-wide relative py-16 sm:py-20 md:py-24">
            <div class="grid gap-8 lg:grid-cols-12 lg:items-center lg:gap-10">
                <div class="lg:col-span-7" data-animate="fade-up">
                    <h2 class="font-display text-[2rem] leading-[1.05] sm:text-4xl md:text-5xl">
                        Project <span class="italic text-gold">Categories</span>
                    </h2>
                    <ul class="mt-6 grid grid-cols-2 gap-x-4 gap-y-2 text-cream/80 sm:gap-y-3 sm:text-[15px] lg:block lg:space-y-3">
                        <li>Interior design</li>
                        <li>Commercial architect</li>
                        <li>Landscape architect</li>
                        <li>Civic project</li>
                    </ul>
                </div>
                <div class="lg:col-span-5 lg:flex lg:justify-end" data-animate="fade-up">
                    <a href="{{ route('contact') }}" class="btn btn-gold w-full justify-center sm:w-auto">Contact Us →</a>
                </div>
            </div>
        </div>
    </section>

    @include('partials.section-ideas-build')

    @include('partials.press-strip')

    <section class="bg-cream">
        <div class="container-wide section-pad">
            <p class="label" data-animate="fade-up">· Recent case studies</p>
            <h2 class="mt-2 h-section text-dark" data-animate="fade-up">Insights</h2>

            @php
                $cases = \App\Models\Project::query()->orderByDesc('featured')->orderByDesc('year')->limit(3)->get();
            @endphp
            @if ($cases->isEmpty())
                <x-empty-state
                    class="mt-8 md:mt-10"
                    heading="No insights yet"
                    body="Case studies will appear here once projects are published. Browse the full portfolio when it’s live, or get in touch."
                    action-text="Contact us"
                    :action-href="route('contact')"
                    data-animate="fade-up"
                />
            @else
            <div class="mt-8 divide-y divide-dark/10 overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur md:mt-10" data-animate="fade-up">
                @foreach ($cases as $idx => $c)
                    @php
                        $caseCover = \App\Support\KamaliMedia::projectCover($c->cover_image, $idx);
                    @endphp
                    <a href="{{ route('projects.show', ['slug' => $c->slug]) }}" class="grid gap-5 p-5 transition hover:bg-cream/60 sm:gap-6 sm:p-7 md:grid-cols-12">
                        <div class="md:col-span-8 md:order-1 order-2">
                            <div class="font-display text-xl text-dark sm:text-2xl">{{ $c->title }}</div>
                            <p class="mt-3 leading-relaxed text-dark/70 text-[15px] sm:text-base">
                                {{ \Illuminate\Support\Str::limit($c->description, 160) }}
                            </p>
                            <div class="mt-4 inline-flex items-center gap-2 text-dark sm:mt-5">
                                <span class="label text-dark/60">View more</span>
                                <span class="text-gold">→</span>
                            </div>
                        </div>
                        <div class="md:col-span-4 md:order-2 order-1">
                            <div class="overflow-hidden rounded-xl border border-dark/10">
                                <img
                                    class="aspect-video w-full object-cover"
                                    src="{{ $caseCover }}"
                                    alt="{{ $c->title }}"
                                    loading="lazy"
                                    decoding="async"
                                />
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            @endif
        </div>
    </section>
@endsection

