@php
    use App\Models\Partner;
    use App\Support\StudioStats;

    $partners = \App\Support\SafeQuery::collection(
        'partners',
        fn () => Partner::query()->visible()->orderBy('sort_order')->get()
    );

    $partnerCount = $partners->count();
    $countries = StudioStats::countriesReached();
@endphp

<section class="border-y border-dark/[0.06] bg-white" aria-labelledby="partners-trust-heading">
    <div class="container-wide py-14 sm:py-16 md:py-20">
        <header class="mx-auto max-w-3xl text-center" data-animate="fade-up">
            <h2 id="partners-trust-heading" class="text-lg font-medium leading-snug text-dark/85 sm:text-xl md:text-[1.35rem]">
                Trusted by
                <span class="font-semibold text-gold tabular-nums">{{ max(1, $partnerCount) }}+</span>
                partners across
                <span class="font-semibold text-gold tabular-nums">{{ max(1, $countries) }}+</span>
                countries
            </h2>
        </header>

        @if ($partners->isEmpty())
            <p class="mt-10 text-center text-sm text-dark/50" data-animate="fade-up">
                Partner logos will appear here once they are added in the admin.
            </p>
        @else
            <ul
                class="partners-trust__grid mx-auto mt-12 max-w-5xl sm:mt-14"
                role="list"
                data-animate="fade-up"
            >
                @foreach ($partners as $partner)
                    <x-partner-logo-cell :partner="$partner" />
                @endforeach
            </ul>
        @endif
    </div>
</section>
