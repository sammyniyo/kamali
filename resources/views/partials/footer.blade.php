@php
    // Default spacing before footer (kept modest to avoid a big empty band)
    $footerMt = \Illuminate\Support\Facades\View::hasSection('footer_no_margin') ? 'mt-0' : 'mt-14 md:mt-16';
@endphp

<footer class="{{ $footerMt }} bg-dark text-cream/80 border-t border-gold/40">
    <div class="container-wide py-12 sm:py-14 md:py-16">
        <div class="grid gap-8 sm:grid-cols-2 sm:gap-10 lg:grid-cols-4">
            <div class="sm:col-span-2 lg:col-span-1">
                <x-brand-mark variant="footer" />
                <p class="mt-4 max-w-sm text-sm leading-relaxed text-cream/70 sm:mt-5">
                    Luxury editorial architecture studio shaping places with restraint, clarity, and warmth.
                </p>
            </div>

            <div>
                <p class="label text-cream/60">Navigation</p>
                <ul class="mt-4 space-y-2.5 text-sm sm:space-y-3">
                    <li><a class="hover:text-cream" href="{{ route('home') }}">Home</a></li>
                    <li><a class="hover:text-cream" href="{{ route('about') }}">About</a></li>
                    <li><a class="hover:text-cream" href="{{ route('services') }}">Services</a></li>
                    <li><a class="hover:text-cream" href="{{ route('projects.index') }}">Projects</a></li>
                    <li><a class="hover:text-cream" href="{{ route('blog.index') }}">Journal</a></li>
                    <li><a class="hover:text-cream" href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            <div>
                <p class="label text-cream/60">Services</p>
                <ul class="mt-4 space-y-2.5 text-sm sm:space-y-3">
                    <li><a class="hover:text-cream" href="{{ route('services') }}#residential-architecture">Residential Architecture</a></li>
                    <li><a class="hover:text-cream" href="{{ route('services') }}#commercial-architecture">Commercial Architecture</a></li>
                    <li><a class="hover:text-cream" href="{{ route('services') }}#interior-design">Interior Design</a></li>
                    <li><a class="hover:text-cream" href="{{ route('services') }}#landscape-architecture">Landscape Architecture</a></li>
                    <li><a class="hover:text-cream" href="{{ route('services') }}#urban-planning">Urban Planning</a></li>
                    <li><a class="hover:text-cream" href="{{ route('services') }}#project-management">Project Management</a></li>
                </ul>
            </div>

            <div>
                <p class="label text-cream/60">Contact</p>
                <div class="mt-4 space-y-2.5 text-sm sm:space-y-3">
                    <div class="leading-relaxed">
                        <span class="block">{{ config('kamali.address.street') }}</span>
                        <span class="block">{{ config('kamali.address.city') }}, {{ config('kamali.address.country') }}</span>
                    </div>
                    <a class="block hover:text-cream" href="tel:{{ config('kamali.phone_tel') }}">{{ config('kamali.phone_display') }}</a>
                    <a class="block break-words hover:text-cream" href="mailto:{{ config('kamali.email') }}">{{ config('kamali.email') }}</a>
                    <a class="block break-all hover:text-cream" href="{{ config('kamali.website_url') }}" target="_blank" rel="noreferrer">{{ config('kamali.website_host') }}</a>
                    <div class="pt-2">
                        <p class="label text-cream/55">Follow</p>
                        <div class="mt-3">
                            <x-social-links variant="light" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-3 border-t border-cream/10 pt-6 text-xs text-cream/55 sm:mt-12 sm:gap-4 sm:pt-8 md:flex-row md:items-center md:justify-between">
            <div>© {{ date('Y') }} Kamali Architects · All rights reserved</div>
            <div class="label text-cream/40">Luxury editorial architecture</div>
        </div>
    </div>
</footer>

