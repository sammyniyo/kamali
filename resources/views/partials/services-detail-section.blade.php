@php
    $sections = [
        [
            'title' => 'Residential Architecture',
            'desc' => 'Bespoke homes shaped by light, sequence, and restraint — designed for longevity and everyday ritual.',
            'bullets' => ['Concept & feasibility', 'Planning & permitting', 'Detailed design + documentation', 'Site oversight'],
            'img' => asset('images/renders/villa-greenwall.png'),
        ],
        [
            'title' => 'Commercial Architecture',
            'desc' => 'Workplaces, galleries, and retail environments with editorial clarity, calm circulation, and refined material palettes.',
            'bullets' => ['Space planning', 'Brand + spatial narrative', 'Envelope strategy', 'Fit-out delivery'],
            'img' => asset('images/renders/fashion-house.png'),
        ],
        [
            'title' => 'Interior Design',
            'desc' => 'Atmosphere in the details — joinery, lighting, textures, and objects that feel inevitable.',
            'bullets' => ['Material + color palettes', 'Custom joinery', 'Lighting design', 'FF&E selection'],
            'img' => asset('images/renders/villa-evening.png'),
        ],
        [
            'title' => 'Landscape Architecture',
            'desc' => 'Courtyards, terraces, and site strategy that completes the architectural story through season, shade, and texture.',
            'bullets' => ['Planting strategy', 'Hardscape detailing', 'Water + lighting', 'Maintenance planning'],
            'img' => asset('images/renders/apartments-court.png'),
        ],
        [
            'title' => 'Urban Planning',
            'desc' => 'Context-led frameworks that balance density, calm, and movement — designed for people first.',
            'bullets' => ['Site + context analysis', 'Massing + zoning studies', 'Public realm strategy', 'Stakeholder packages'],
            'img' => asset('images/renders/apartments-rooftop.png'),
        ],
        [
            'title' => 'Project Management',
            'desc' => 'Precision delivery from concept to completion — steady communication, clear schedules, and disciplined quality control.',
            'bullets' => ['Budget + program control', 'Consultant coordination', 'Tender support', 'Construction administration'],
            'img' => asset('images/renders/mansion-symmetry.png'),
        ],
    ];

    $servicesEnquireHref = $servicesEnquireHref ?? route('contact');
    $servicesSectionExtraClass = $servicesSectionExtraClass ?? '';
    $servicesLayout = $servicesLayout ?? 'detail';
@endphp

<section class="bg-cream {{ $servicesSectionExtraClass }}">
    <div
        @class([
            'container-wide section-pad',
            'space-y-8 sm:space-y-10' => $servicesLayout === 'cards',
            'space-y-12 sm:space-y-14 md:space-y-16' => $servicesLayout !== 'cards',
        ])
    >
        @if ($servicesHomeHeader ?? false)
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between sm:gap-6" data-animate="fade-up">
                <div class="min-w-0">
                    <p class="label text-dark/60">Our expertise</p>
                    <h2 class="mt-2 h-section text-dark">Services</h2>
                </div>
                <a class="inline-flex items-center gap-2 text-dark hover:text-dark/70" href="{{ route('services') }}">
                    <span class="label text-dark/60">All services</span>
                    <span class="text-gold">→</span>
                </a>
            </div>
        @endif

        @if ($servicesLayout === 'cards')
            <div class="grid gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3" data-animate="fade-up">
                @foreach ($sections as $s)
                    @php
                        $anchor = \Illuminate\Support\Str::slug($s['title']);
                        $detailHref = route('services') . '#' . $anchor;
                    @endphp
                    <article
                        id="{{ $anchor }}"
                        class="group flex scroll-mt-28 flex-col overflow-hidden rounded-2xl border border-dark/10 bg-white/80 shadow-[0_2px_32px_rgba(26,26,24,0.04)] backdrop-blur transition duration-300 motion-safe:hover:-translate-y-1"
                    >
                        <a href="{{ $detailHref }}" class="relative block shrink-0 overflow-hidden">
                            <img
                                class="aspect-[5/3] w-full object-cover transition duration-500 motion-safe:group-hover:scale-[1.04]"
                                src="{{ $s['img'] }}"
                                alt="{{ $s['title'] }}"
                                loading="lazy"
                                decoding="async"
                                referrerpolicy="no-referrer"
                            />
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-dark/25 to-transparent opacity-0 transition duration-300 group-hover:opacity-100" aria-hidden="true"></div>
                            <div class="absolute inset-x-0 bottom-0 h-px bg-gold/0 transition duration-300 group-hover:bg-gold" aria-hidden="true"></div>
                        </a>
                        <div class="flex min-h-0 flex-1 flex-col p-5 sm:p-6">
                            <h3 class="font-display text-lg leading-snug text-dark sm:text-xl">
                                <a class="text-dark transition hover:text-dark/75" href="{{ $detailHref }}">{{ $s['title'] }}</a>
                            </h3>
                            <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-dark/65">
                                {{ $s['desc'] }}
                            </p>
                            <div class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-dark/10 pt-4">
                                <a class="label text-dark/55 transition hover:text-dark" href="{{ $detailHref }}">Details</a>
                                <a class="inline-flex items-center gap-2 text-sm font-medium text-dark hover:text-dark/70" href="{{ $servicesEnquireHref }}">
                                    <span class="label text-dark/60">Enquire</span>
                                    <span class="text-gold" aria-hidden="true">→</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            @foreach ($sections as $idx => $s)
                @php $anchor = \Illuminate\Support\Str::slug($s['title']); @endphp
                <div id="{{ $anchor }}" class="scroll-mt-28 grid gap-6 sm:gap-8 lg:grid-cols-12 lg:items-center lg:gap-10">
                    <div class="{{ $idx % 2 === 0 ? 'lg:col-span-7 lg:order-1' : 'lg:col-span-7 lg:order-2' }}" data-animate="fade-up">
                        <div class="relative overflow-hidden rounded-2xl border border-dark/10">
                            <img
                                class="aspect-[16/10] w-full object-cover"
                                src="{{ $s['img'] }}"
                                alt="{{ $s['title'] }}"
                                loading="lazy"
                                decoding="async"
                                referrerpolicy="no-referrer"
                            />
                            <div class="absolute inset-0 ring-1 ring-gold/25 rounded-2xl" aria-hidden="true"></div>
                        </div>
                    </div>
                    <div class="{{ $idx % 2 === 0 ? 'lg:col-span-5 lg:order-2' : 'lg:col-span-5 lg:order-1' }}" data-animate="fade-up">
                        <h2 class="font-display text-[1.75rem] leading-tight text-dark sm:text-3xl md:text-4xl">{{ $s['title'] }}</h2>
                        <p class="mt-4 leading-relaxed text-dark/70 text-[15px] sm:text-base">{{ $s['desc'] }}</p>
                        <ul class="mt-5 space-y-2 text-dark/75 text-[15px] sm:mt-6 sm:text-base">
                            @foreach ($s['bullets'] as $b)
                                <li class="flex items-start gap-3">
                                    <span class="mt-2 h-1.5 w-1.5 rounded-full bg-gold shrink-0"></span>
                                    <span>{{ $b }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <a class="mt-6 inline-flex items-center gap-2 text-dark hover:text-dark/70 sm:mt-7" href="{{ $servicesEnquireHref }}">
                            <span class="label text-dark/60">Enquire</span>
                            <span class="text-gold">→</span>
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</section>
