@extends('layouts.app')

@section('title', 'About — Kamali Architects')
@section('meta_description', 'Kamali Architects — an editorial architecture studio in Kigali, Rwanda (KN 7 St). Mission, studio history, principles, and team.')

@section('content')
    @php
        $timeline = [
            ['year' => '2010', 'title' => 'Studio founded', 'text' => 'A small team formed around proportion, craft, and calm architectural storytelling.'],
            ['year' => '2014', 'title' => 'First international commission', 'text' => 'Residential work expands into multi-climate detailing and material research.'],
            ['year' => '2018', 'title' => 'Civic portfolio begins', 'text' => 'Public projects focused on clarity, accessibility, and durable finishes.'],
            ['year' => '2022', 'title' => 'Award recognition', 'text' => 'Honored for quiet luxury — editorial compositions with warm material palettes.'],
            ['year' => '2026', 'title' => 'Active global practice', 'text' => 'Work across residential, commercial, and civic categories in multiple countries.'],
        ];

        $values = [
            ['01', 'Restraint', 'Fewer gestures, stronger outcomes. We design for longevity, not noise.'],
            ['02', 'Craft', 'Detail is the architecture. Materials, edges, and joints are treated as narrative.'],
            ['03', 'Atmosphere', 'Light, texture, and silence shape the experience as much as structure does.'],
        ];

        $awards = \App\Models\Partner::query()->visible()->orderBy('sort_order')->get();
        if ($awards->isEmpty()) {
            $awards = collect(config('kamali.recognition', []))->map(fn ($name) => (object) ['name' => $name]);
        }

        $team = \App\Models\TeamMember::query()->orderBy('sort_order')->get();
    @endphp

    <section class="relative h-[50svh] overflow-hidden bg-dark text-cream">
        <div
            class="absolute inset-0"
            style="
                background-image: url('{{ asset('images/renders/mansion-symmetry.png') }}');
                background-size: cover;
                background-position: center;
            "
            aria-hidden="true"
        ></div>
        <div class="absolute inset-0 overlay-gradient" aria-hidden="true"></div>

        <div class="container-wide relative pt-28 pb-10 sm:pb-0 md:pt-40">
            <div class="max-w-4xl">
                <div class="label text-cream/70" data-animate="fade-up">· About Us</div>
                <div class="mt-4 flex flex-col gap-6 sm:flex-row sm:flex-wrap sm:items-end sm:gap-x-8 sm:gap-y-4" data-animate="fade-up">
                    <h1 class="font-display text-[2.35rem] leading-[0.98] tracking-tight text-cream sm:text-5xl md:text-[3.25rem]">
                        Kamali Architects
                    </h1>
                    <div class="hidden h-px w-24 shrink-0 bg-gold/70 sm:block"></div>
                    <p class="max-w-xl text-[15px] leading-relaxed text-cream/75 sm:text-base">
                        We translate ambition into calm, durable architecture — residential, commercial, and civic work guided by proportion and material honesty.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-cream">
        <div class="container-wide section-pad">
            <div class="grid gap-8 lg:grid-cols-12 lg:gap-14">
                <div class="lg:col-span-5" data-animate="fade-up">
                    <p class="font-display italic text-[1.6rem] leading-snug text-dark sm:text-3xl">
                        “We design with restraint — letting light, proportion, and material do the loud work.”
                    </p>
                    <p class="mt-4 label text-dark/50">Founder</p>
                </div>
                <div class="space-y-4 leading-relaxed text-dark/70 text-[15px] sm:space-y-5 sm:text-base lg:col-span-7" data-animate="fade-up">
                    <p>
                        Kamali Architects is a design-led practice with a single through-line: one strong idea, developed with discipline and built to last. We
                        work across luxury homes, workplace, hospitality, and public space — from first sketch to site resolution.
                    </p>
                    <p>
                        Clients come to us for clarity under complexity. We keep teams small, communication direct, and documentation precise so decisions stay
                        legible as a project moves from concept to construction.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="history" class="relative overflow-hidden border-t border-dark/[0.06] bg-cream">
        <div
            class="pointer-events-none absolute inset-0 grain-soft opacity-[0.11] mix-blend-multiply"
            aria-hidden="true"
        ></div>
        <div class="relative z-[1] container-wide scroll-mt-28 pt-20 sm:pt-24 md:scroll-mt-[8.75rem] md:pt-32 pb-20 sm:pb-24 md:pb-28">
            <header class="max-w-3xl" data-animate="fade-up">
                <p class="label">· History</p>
                <h2 class="mt-3 font-display text-4xl leading-[1.02] tracking-tight text-dark md:text-[2.75rem]">Timeline</h2>
                <p class="mt-4 max-w-xl text-[15px] leading-relaxed text-dark/60 sm:text-base">
                    Milestones from the studio’s evolution — each phase built on the same principle: clarity first, then craft.
                </p>
            </header>

            <div class="mt-14 grid items-start gap-14 lg:mt-16 lg:grid-cols-12 lg:gap-12 xl:gap-16">
                <aside class="lg:col-span-4 xl:col-span-3" data-animate="fade-up">
                    <div class="lg:sticky lg:top-32">
                        <div
                            class="relative overflow-hidden rounded-3xl border border-dark/10 bg-white/85 p-8 shadow-[0_2px_48px_rgba(26,26,24,0.055)] backdrop-blur-md md:p-9"
                        >
                            <div
                                class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-gold/45 to-transparent"
                                aria-hidden="true"
                            ></div>
                            <p class="label text-dark/45">Studio note</p>
                            <p class="mt-5 text-[17px] leading-relaxed text-dark/75">
                                We refine a single strong idea until it becomes inevitable — and then we build it with discipline.
                            </p>
                        </div>
                    </div>
                </aside>

                <div class="min-w-0 lg:col-span-8 xl:col-span-9" data-animate="fade-up">
                    <div class="relative">
                        {{-- Continuous rail; dots centered on the rail --}}
                        <div
                            class="pointer-events-none absolute left-[13px] top-1 bottom-2 w-px bg-gradient-to-b from-dark/20 via-dark/10 to-dark/[0.08] sm:left-[15px]"
                            aria-hidden="true"
                        ></div>

                        <ol class="relative m-0 list-none space-y-0 p-0">
                            @foreach ($timeline as $i => $t)
                                <li class="group relative pb-14 last:pb-3 sm:pb-16 sm:last:pb-5">
                                    <div
                                        class="absolute left-[13px] top-[0.6rem] z-[1] flex h-3 w-3 -translate-x-1/2 sm:left-[15px]"
                                        aria-hidden="true"
                                    >
                                        <span
                                            class="m-auto h-2.5 w-2.5 rounded-full bg-gold shadow-[0_0_0_5px_var(--cream)] ring-1 ring-gold/30 transition duration-300 motion-safe:group-hover:scale-110 motion-safe:group-hover:ring-gold/45 sm:h-3 sm:w-3"
                                        ></span>
                                    </div>

                                    <div
                                        class="grid gap-4 pl-11 sm:grid-cols-[minmax(0,5.75rem)_1fr] sm:gap-8 sm:pl-[2.125rem] md:gap-10 lg:grid-cols-[minmax(0,6.5rem)_1fr] lg:gap-12 xl:gap-14"
                                    >
                                        <div>
                                            <span
                                                class="block font-display text-[1.85rem] leading-none tracking-tight text-dark tabular-nums sm:text-[2.15rem] lg:text-[2.45rem]"
                                            >
                                                {{ $t['year'] }}
                                            </span>
                                        </div>
                                        <div class="min-w-0 pt-0.5">
                                            <h3 class="font-medium text-lg leading-snug text-dark sm:text-xl">{{ $t['title'] }}</h3>
                                            <p class="mt-2.5 max-w-2xl text-[15px] leading-relaxed text-dark/70 sm:text-base">
                                                {{ $t['text'] }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-cream">
        <div class="container-wide pb-14 pt-12 sm:pb-16 sm:pt-16 md:pb-20 md:pt-24">
            <div class="max-w-prose scroll-mt-28 md:scroll-mt-[8.75rem]" data-animate="fade-up">
                <p class="label">· Our Team</p>
                <h2 class="mt-2 h-section text-dark">Architects</h2>
            </div>

            <div class="mt-8 grid gap-5 sm:gap-6 md:mt-10 md:grid-cols-2 md:gap-7 lg:grid-cols-3">
                @if ($team->isEmpty())
                    <x-empty-state
                        class="md:col-span-2 lg:col-span-3"
                        heading="No team profiles yet"
                        body="Our architects will appear here soon. Contact the studio if you’d like to connect with the practice."
                        action-text="Contact us"
                        :action-href="route('contact')"
                        data-animate="fade-up"
                    />
                @else
                    @foreach ($team as $m)
                    <div x-data="{ open: false }" class="relative" data-animate="fade-up">
                        <div class="overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur">
                            <div class="aspect-[4/3] bg-dark/10">
                                <img class="h-full w-full object-cover" src="{{ \App\Support\KamaliMedia::teamPhoto($m->photo) }}" alt="{{ $m->name }}" loading="lazy" />
                            </div>
                            <div class="p-6 sm:p-7">
                                <div class="font-display text-xl text-dark sm:text-2xl">{{ $m->name }}</div>
                                <div class="mt-2 label text-dark/50">{{ $m->role }}</div>
                                <p class="mt-4 text-[15px] leading-relaxed text-dark/70 sm:text-base">
                                    {{ \Illuminate\Support\Str::limit($m->bio, 150) }}
                                </p>

                                <div class="mt-6 flex flex-wrap items-center gap-4">
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-2 rounded-full border border-dark/10 bg-white/60 px-4 py-2 text-sm text-dark hover:bg-white transition focus:outline-none focus:ring-2 focus:ring-gold/25"
                                        @click="open = true"
                                        :aria-expanded="open.toString()"
                                        aria-haspopup="dialog"
                                    >
                                        View details <span class="text-gold">→</span>
                                    </button>

                                    @if ($m->linkedin_url)
                                        <a
                                            class="inline-flex items-center gap-2 text-dark hover:text-dark/70"
                                            href="{{ $m->linkedin_url }}"
                                            target="_blank"
                                            rel="noreferrer"
                                        >
                                            <span class="label text-dark/60">LinkedIn</span>
                                            <span class="text-gold">↗</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
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
                @endif
            </div>
        </div>
    </section>

    <section class="bg-cream">
        <div class="container-wide pb-14 pt-12 sm:pb-16 sm:pt-16 md:pb-20 md:pt-24">
            <div class="max-w-prose scroll-mt-28 md:scroll-mt-[8.75rem]" data-animate="fade-up">
                <p class="label">· Values</p>
                <h2 class="mt-2 h-section text-dark">Principles</h2>
            </div>

            <div class="mt-8 grid gap-5 sm:grid-cols-2 sm:gap-6 md:mt-10 md:gap-7 lg:grid-cols-3">
                @foreach ($values as [$n, $t, $d])
                    <div class="rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-6 sm:p-7 md:p-8" data-animate="fade-up">
                        <div class="font-display text-4xl text-dark/30 sm:text-5xl">{{ $n }}</div>
                        <div class="mt-3 font-display text-xl text-dark sm:mt-4 sm:text-2xl">{{ $t }}</div>
                        <p class="mt-3 text-[15px] leading-relaxed text-dark/70 sm:text-base">{{ $d }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-cream">
        <div class="container-wide pb-14 pt-12 sm:pb-16 sm:pt-16 md:pb-20 md:pt-24">
            <div class="max-w-prose scroll-mt-28 md:scroll-mt-[8.75rem]" data-animate="fade-up">
                <p class="label">· Awards & Recognition</p>
                <h2 class="mt-2 h-section text-dark">Recognition</h2>
            </div>

            @if ($awards->isEmpty())
                <x-empty-state
                    class="mt-8 md:mt-10"
                    heading="Recognition coming soon"
                    body="Awards and press partners will be listed here once they are added in the admin."
                    data-animate="fade-up"
                />
            @else
                <ul
                    class="partners-trust__grid mx-auto mt-8 max-w-5xl md:mt-10"
                    role="list"
                    data-animate="fade-up"
                >
                    @foreach ($awards as $partner)
                        @if (is_object($partner))
                            <x-partner-logo-cell :partner="$partner" />
                        @else
                            <li class="flex flex-col items-center text-center">
                                <div class="partners-trust__logo flex h-12 items-center justify-center">
                                    <span class="font-display text-base text-dark/55">{{ $partner }}</span>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
    </section>

    @include('partials.section-ideas-build')

    <section class="bg-dark text-cream">
        <div class="container-wide section-pad">
            <div class="grid gap-6 sm:gap-8 lg:grid-cols-12 lg:items-center lg:gap-10">
                <div class="lg:col-span-8" data-animate="fade-up">
                    <h2 class="font-display text-[2rem] leading-[1.05] sm:text-4xl md:text-5xl">
                        Start your <span class="italic text-gold">project</span>
                    </h2>
                    <p class="mt-4 max-w-2xl leading-relaxed text-cream/75 text-[15px] sm:mt-5 sm:text-base">
                        Tell us what you’re building — we’ll respond with next steps, scope options, and a clear timeline.
                    </p>
                </div>
                <div class="lg:col-span-4 lg:flex lg:justify-end" data-animate="fade-up">
                    <a class="btn btn-gold w-full justify-center sm:w-auto" href="{{ route('contact') }}">Get in Touch →</a>
                </div>
            </div>
        </div>
    </section>
@endsection

