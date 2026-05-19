@php
    use App\Support\KamaliMedia;
@endphp
<div class="mt-8 grid grid-cols-1 gap-5 sm:mt-10 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
    @forelse ($projects as $idx => $p)
        @php
            $coverSrc = KamaliMedia::projectCover($p->cover_image, $idx);
        @endphp
        <a
            href="{{ route('projects.show', ['slug' => $p->slug]) }}"
            class="group block overflow-hidden rounded-2xl border border-dark/10 bg-white/70 backdrop-blur transition duration-300 motion-safe:hover:-translate-y-1"
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
                <div class="pointer-events-none absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-dark/70 via-dark/30 to-transparent md:opacity-0 md:transition-opacity md:duration-300 md:group-hover:opacity-100"></div>
                <div class="absolute left-3 top-3 sm:left-4 sm:top-4">
                    <span
                        class="inline-flex items-center rounded-full border bg-dark/55 px-3 py-1 text-xs"
                        @class([
                            'border-gold/50 text-gold' => $p->status === 'finished',
                            'border-cream/20 text-cream pulse-soft' => $p->status === 'under_construction',
                        ])
                    >
                        {{ $p->status === 'finished' ? 'Finished' : 'In Progress' }}
                    </span>
                </div>
                {{-- Title overlay: always visible on touch, hover-reveal on desktop --}}
                <div class="absolute inset-x-0 bottom-0 p-4 sm:p-5 md:translate-y-2 md:opacity-0 md:transition-all md:duration-300 md:group-hover:translate-y-0 md:group-hover:opacity-100">
                    <div class="font-display text-xl leading-tight text-cream sm:text-2xl">{{ $p->title }}</div>
                    <div class="mt-1 text-sm text-cream/75">{{ $p->location }}</div>
                </div>
            </div>
            {{-- Title strip below image on mobile/tablet (md+ uses the overlay instead) --}}
            <div class="flex items-center justify-between gap-3 px-5 py-4 md:hidden">
                <div class="min-w-0">
                    <div class="truncate font-display text-lg text-dark">{{ $p->title }}</div>
                    <div class="mt-0.5 truncate text-xs text-dark/55">{{ $p->location }}</div>
                </div>
                <span aria-hidden="true" class="text-gold">→</span>
            </div>
        </a>
    @empty
        @if ($filtersActive ?? false)
            <x-empty-state
                class="md:col-span-2 lg:col-span-3"
                heading="No projects match your filters"
                body="Try clearing the search or widening status and category — or browse all projects again."
                action-text="Clear filters"
                :action-href="route('projects.index')"
            />
        @else
            <x-empty-state
                class="md:col-span-2 lg:col-span-3"
                heading="No projects available yet"
                body="We’re preparing our portfolio. In the meantime, reach out if you’d like to discuss a commission."
                action-text="Contact us"
                :action-href="route('contact')"
            />
        @endif
    @endforelse
</div>

