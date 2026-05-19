@extends('layouts.app')

@section('title', 'Services — Kamali Architects')
@section('meta_description', 'Explore Kamali Architects services: residential, commercial, interior design, landscape, urban planning, and project management.')

@section('content')
    @php
        $faq = [
            ['q' => 'Do you work internationally?', 'a' => 'Yes. We collaborate with local consultants and builders, and adapt detailing to climate, codes, and craft traditions.'],
            ['q' => 'What is your typical timeline?', 'a' => 'It depends on scope and approvals. We provide a clear schedule after an initial briefing and feasibility review.'],
            ['q' => 'Can you handle turnkey interior + FF&E?', 'a' => 'Yes. We can deliver full interior design, procurement support, and installation coordination.'],
            ['q' => 'How do we start?', 'a' => 'Send a brief, location, and target timeline. We’ll respond with next steps and a proposed discovery call.'],
        ];
    @endphp

    <section class="relative overflow-hidden bg-dark text-cream">
        <div class="absolute inset-0 noise opacity-[0.14]" aria-hidden="true"></div>
        <div
            class="container-wide relative scroll-mt-28 pb-12 pt-[calc(4.25rem+2rem)] sm:pb-16 md:scroll-mt-[8.75rem] md:pt-[calc(7rem+2.5rem)] lg:pb-20 lg:pt-36"
        >
            <div class="max-w-4xl">
                <p class="label text-cream/70" data-animate="fade-up">· Services</p>
                <h1 class="mt-4 h-display" data-animate="fade-up">
                    What <span class="italic text-gold">We Do</span>
                </h1>
                <p class="mt-5 max-w-2xl text-cream/75 leading-relaxed text-[15px] sm:text-base sm:mt-6" data-animate="fade-up">
                    From concept to completion, we build calm, editorial architecture with warm material palettes and disciplined detail.
                </p>
            </div>
        </div>
    </section>

    @include('partials.services-detail-section')

    <section class="bg-dark text-cream">
        <div class="container-wide section-pad">
            <p class="label text-cream/60" data-animate="fade-up">· Process</p>
            <h2 class="mt-2 h-section" data-animate="fade-up">How we work</h2>

            <div class="mt-8 grid gap-4 sm:gap-5 sm:grid-cols-2 md:mt-10 md:grid-cols-3 lg:grid-cols-5" data-animate="fade-up">
                @foreach ([
                    ['01', 'Discover', 'Brief, constraints, and ambition.'],
                    ['02', 'Concept', 'Mass, light, and narrative.'],
                    ['03', 'Refine', 'Materials, plans, and details.'],
                    ['04', 'Deliver', 'Docs, coordination, and tender.'],
                    ['05', 'Build', 'Site oversight and quality control.'],
                ] as [$n, $t, $d])
                    <div class="rounded-2xl border border-cream/10 bg-dark/40 p-5 sm:p-6 md:p-7">
                        <div class="font-display text-3xl text-cream/30 sm:text-4xl">{{ $n }}</div>
                        <div class="mt-3 font-medium text-cream">{{ $t }}</div>
                        <div class="mt-2 text-sm leading-relaxed text-cream/70">{{ $d }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-cream">
        <div class="container-wide section-pad">
            <p class="label" data-animate="fade-up">· FAQ</p>
            <h2 class="mt-2 h-section text-dark" data-animate="fade-up">Questions</h2>

            <div class="mt-8 divide-y divide-dark/10 overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur md:mt-10" data-animate="fade-up">
                @foreach ($faq as $i => $item)
                    <div x-data="{ open: {{ $i === 0 ? 'true' : 'false' }} }" class="p-5 sm:p-6 md:p-7">
                        <button type="button" class="flex w-full items-start justify-between gap-4 text-left" @click="open = !open" :aria-expanded="open.toString()">
                            <span class="font-medium text-dark text-[15px] sm:text-base">{{ $item['q'] }}</span>
                            <span class="text-gold text-xl leading-none mt-1 motion-safe:transition-transform" :class="open ? 'rotate-45' : ''">+</span>
                        </button>
                        <div x-show="open" x-collapse class="pt-4 text-[15px] leading-relaxed text-dark/70 sm:text-base">
                            {{ $item['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-dark text-cream">
        <div class="container-wide section-pad">
            <div class="grid gap-6 sm:gap-8 lg:grid-cols-12 lg:items-center lg:gap-10">
                <div class="lg:col-span-8" data-animate="fade-up">
                    <h2 class="font-display text-[2rem] leading-[1.05] sm:text-4xl md:text-5xl">
                        Ready to <span class="italic text-gold">enquire</span>
                    </h2>
                    <p class="mt-4 max-w-2xl leading-relaxed text-cream/75 text-[15px] sm:mt-5 sm:text-base">
                        Share your location, scope, and timeline. We’ll respond with next steps and a clear proposal.
                    </p>
                </div>
                <div class="lg:col-span-4 lg:flex lg:justify-end" data-animate="fade-up">
                    <a class="btn btn-gold w-full justify-center sm:w-auto" href="{{ route('contact') }}">Contact Us →</a>
                </div>
            </div>
        </div>
    </section>
@endsection

