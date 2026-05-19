{{-- Invites visitors to share a concept before the typical “contact us” ask --}}
<section
    id="ideas"
    class="relative scroll-mt-28 overflow-hidden border-t border-dark/[0.06] bg-cream md:scroll-mt-[8.75rem]"
    aria-labelledby="ideas-heading"
>
    <div class="pointer-events-none absolute inset-0 grain-soft opacity-[0.08] mix-blend-multiply" aria-hidden="true"></div>
    <div class="container-wide relative z-[1] py-14 sm:py-16 md:py-20 lg:py-24">
        <div class="grid gap-8 sm:gap-10 lg:grid-cols-12 lg:items-center lg:gap-12">
            <div class="min-w-0 lg:col-span-7" data-animate="fade-up">
                <p class="label">· Build with us</p>
                <h2 id="ideas-heading" class="mt-3 font-display text-[1.85rem] leading-[1.05] tracking-tight text-dark sm:text-4xl md:text-[2.5rem]">
                    Have an idea you’d like to
                    <span class="italic text-gold">see built?</span>
                </h2>
                <p class="mt-4 max-w-2xl text-[15px] leading-relaxed text-dark/70 sm:mt-5 md:text-base">
                    Early sketches, a short written brief, or a few lines of intent — tell us what you’re imagining. We’ll help you understand feasibility, timeline, and how the idea could become architecture you can move through.
                </p>
            </div>
            <div
                class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-4 lg:col-span-5 lg:flex-col lg:items-stretch xl:flex-row xl:items-center xl:justify-end"
                data-animate="fade-up"
            >
                <a
                    href="{{ route('contact') }}#contact-form"
                    class="btn btn-gold w-full justify-center sm:min-w-[14rem] lg:min-w-0 xl:min-w-[14rem]"
                >
                    Share your idea →
                </a>
                <a
                    href="{{ route('projects.index') }}"
                    class="btn btn-dark-outline w-full justify-center border-dark/15 bg-white/60 backdrop-blur-sm sm:min-w-[12rem] lg:min-w-0 xl:min-w-[12rem]"
                >
                    Explore projects
                </a>
            </div>
        </div>
    </div>
</section>
