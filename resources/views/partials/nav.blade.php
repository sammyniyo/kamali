<header
    x-data="{
        open: false,
        mobileProjects: false,
        scrolled: false,
        init() {
            const onScroll = () => (this.scrolled = window.scrollY > 24);
            onScroll();
            window.addEventListener('scroll', onScroll, { passive: true });
            this.$watch('open', (v) => {
                document.documentElement.classList.toggle('overflow-hidden', v);
            });
        },
    }"
    class="fixed inset-x-0 top-0 z-[70]"
>
    <div class="hidden md:block bg-dark border-b border-cream/10 shadow-[0_1px_0_rgba(255,255,255,0.06)]">
        <div class="container-wide">
            <div class="flex h-9 items-center justify-between text-xs text-cream/70">
                <div class="flex items-center gap-6">
                    <a class="hover:text-cream" href="tel:{{ config('kamali.phone_tel') }}">{{ config('kamali.phone_display') }}</a>
                    <a class="hover:text-cream" href="mailto:{{ config('kamali.email') }}">{{ config('kamali.email') }}</a>
                </div>
                <div class="label text-cream/50">Mon–Fri · 09:00–18:00</div>
            </div>
        </div>
    </div>

    <div
        data-nav="main"
        :class="scrolled ? 'shadow-[0_12px_40px_rgba(0,0,0,0.22)]' : 'shadow-[0_10px_30px_rgba(0,0,0,0.14)]'"
        class="bg-dark border-b border-cream/10 transition-[box-shadow] duration-300 md:pt-1 supports-[backdrop-filter]:backdrop-blur-sm"
    >
        <div class="container-wide">
            <div class="flex h-[4.25rem] shrink-0 items-center justify-between gap-4 md:h-[4.75rem]">
                <x-brand-mark />

                <div class="hidden lg:flex flex-1 items-center justify-center">
                    <nav
                        class="flex items-center gap-10 text-sm"
                        :class="scrolled ? 'text-cream/90' : 'text-cream/90'"
                        aria-label="Primary"
                    >
                        <a
                            class="nav-link nav-kbd-focus"
                            :class="['text-cream/90 hover:text-cream', '{{ request()->routeIs('home') ? 'is-active' : '' }}']"
                            href="{{ route('home') }}"
                        >
                            Home
                        </a>
                        <a
                            class="nav-link nav-kbd-focus"
                            :class="['text-cream/90 hover:text-cream', '{{ request()->routeIs('about') ? 'is-active' : '' }}']"
                            href="{{ route('about') }}"
                        >
                            About
                        </a>
                        <a
                            class="nav-link nav-kbd-focus"
                            :class="['text-cream/90 hover:text-cream', '{{ request()->routeIs('services') ? 'is-active' : '' }}']"
                            href="{{ route('services') }}"
                        >
                            Services
                        </a>

                        <a
                            class="nav-link nav-kbd-focus"
                            :class="['text-cream/90 hover:text-cream', '{{ request()->routeIs('blog.*') ? 'is-active' : '' }}']"
                            href="{{ route('blog.index') }}"
                        >
                            Journal
                        </a>

                        <div class="relative" x-data="{ dd: false }" @mouseenter="dd=true" @mouseleave="dd=false" @keydown.escape.window="dd=false">
                            <button
                                type="button"
                                class="nav-link nav-kbd-focus text-cream/90 hover:text-cream"
                                :class="['{{ request()->routeIs('projects.*') ? 'is-active' : '' }}']"
                                @click="dd = !dd"
                                :aria-expanded="dd.toString()"
                                aria-haspopup="true"
                            >
                                Projects
                                <span class="text-gold" :class="dd ? 'rotate-180' : ''" style="transition: transform 200ms ease;">▾</span>
                            </button>
                            <div
                                x-show="dd"
                                x-transition:enter="transition ease-out duration-180"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1"
                                @click.outside="dd=false"
                                class="absolute left-0 mt-4 w-[340px] rounded-2xl bg-dark/95 border border-cream/10 shadow-2xl overflow-hidden"
                            >
                                <div class="px-6 pt-5 pb-3">
                                    <div class="label text-cream/55">Browse</div>
                                    <div class="mt-2 text-cream/80 text-sm leading-relaxed">
                                        Explore finished work and active sites. Curated by category, location, and status.
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-0 border-t border-cream/10">
                                    <a class="group px-6 py-4 hover:bg-cream/5 focus:bg-cream/5 outline-none" href="{{ route('projects.finished') }}">
                                        <div class="text-cream font-medium">Finished</div>
                                        <div class="mt-1 text-xs text-cream/60">Completed projects</div>
                                        <div class="mt-2 text-gold text-sm">View →</div>
                                    </a>
                                    <a
                                        class="group px-6 py-4 hover:bg-cream/5 focus:bg-cream/5 outline-none border-l border-cream/10"
                                        href="{{ route('projects.under_construction') }}"
                                    >
                                        <div class="text-cream font-medium">In Progress</div>
                                        <div class="mt-1 text-xs text-cream/60">Under construction</div>
                                        <div class="mt-2 text-gold text-sm">View →</div>
                                    </a>
                                </div>
                                <div class="border-t border-cream/10">
                                    <a class="block px-6 py-4 text-cream/85 hover:text-cream hover:bg-cream/5" href="{{ route('projects.index') }}">
                                        <span class="label text-cream/60">All projects</span>
                                        <span class="text-gold"> →</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <a
                            class="nav-link nav-kbd-focus"
                            :class="['text-cream/90 hover:text-cream', '{{ request()->routeIs('contact') ? 'is-active' : '' }}']"
                            href="{{ route('contact') }}"
                        >
                            Contact
                        </a>
                    </nav>
                </div>

                <div class="hidden lg:flex items-center justify-end">
                    <a href="{{ route('contact') }}" class="btn btn-gold">
                        Get in Touch
                        <span class="text-dark/60">→</span>
                    </a>
                </div>

                <button
                    type="button"
                    class="lg:hidden inline-flex h-11 w-11 items-center justify-center rounded-full border border-cream/15 bg-dark text-cream shadow-lg shadow-black/20"
                    @click="open = true"
                    aria-label="Open menu"
                >
                    <span class="text-gold text-lg leading-none">☰</span>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" x-transition.opacity class="fixed inset-0 z-[80]" @keydown.escape.window="open=false">
        <div class="absolute inset-0 bg-dark/80 backdrop-blur-[4px]" @click="open=false" aria-hidden="true"></div>

        <aside
            x-show="open"
            x-transition:enter="transition transform duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 h-full w-[92vw] max-w-sm bg-dark border-l border-cream/10"
            role="dialog"
            aria-modal="true"
            aria-label="Site menu"
        >
            <div class="px-6 pt-6 pb-5 border-b border-cream/10">
                <div class="flex items-center justify-between">
                    <x-brand-mark variant="drawer" @click="open=false" />
                    <button
                        type="button"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-cream/15 bg-dark/30 text-cream"
                        @click="open=false"
                        aria-label="Close menu"
                    >
                        ✕
                    </button>
                </div>

                <div class="mt-5 grid gap-2 text-sm text-cream/75">
                    <a class="inline-flex items-center justify-between rounded-xl border border-cream/10 bg-dark/30 px-4 py-3 hover:bg-cream/5" href="tel:{{ config('kamali.phone_tel') }}">
                        <span>{{ config('kamali.phone_display') }}</span>
                        <span class="text-gold">↗</span>
                    </a>
                    <a class="inline-flex items-center justify-between rounded-xl border border-cream/10 bg-dark/30 px-4 py-3 hover:bg-cream/5" href="mailto:{{ config('kamali.email') }}">
                        <span class="break-all text-left">{{ config('kamali.email') }}</span>
                        <span class="text-gold">↗</span>
                    </a>
                </div>
            </div>

            <div class="px-6 py-6 space-y-2 text-cream/90">
                <a
                    class="block rounded-2xl px-5 py-4 text-base border border-transparent hover:border-cream/10 hover:bg-cream/5"
                    href="{{ route('home') }}"
                    @click="open=false"
                >
                    Home
                </a>
                <a
                    class="block rounded-2xl px-5 py-4 text-base border border-transparent hover:border-cream/10 hover:bg-cream/5"
                    href="{{ route('about') }}"
                    @click="open=false"
                >
                    About
                </a>
                <a
                    class="block rounded-2xl px-5 py-4 text-base border border-transparent hover:border-cream/10 hover:bg-cream/5"
                    href="{{ route('services') }}"
                    @click="open=false"
                >
                    Services
                </a>

                <a
                    class="block rounded-2xl px-5 py-4 text-base border border-transparent hover:border-cream/10 hover:bg-cream/5"
                    href="{{ route('blog.index') }}"
                    @click="open=false"
                >
                    Journal
                </a>

                <div class="rounded-xl border border-cream/10 overflow-hidden">
                    <button
                        type="button"
                        class="w-full px-5 py-4 flex items-center justify-between text-base hover:bg-cream/5"
                        @click="mobileProjects = !mobileProjects"
                        :aria-expanded="mobileProjects.toString()"
                    >
                        <span>Projects</span>
                        <span class="text-gold" :class="mobileProjects ? 'rotate-180' : ''" style="transition: transform 200ms ease;">▾</span>
                    </button>
                    <div x-show="mobileProjects" x-collapse class="bg-dark/40 border-t border-cream/10">
                        <a class="block px-5 py-4 text-cream/80 hover:bg-cream/5 hover:text-cream" href="{{ route('projects.index') }}" @click="open=false">All projects</a>
                        <a class="block px-5 py-4 text-cream/80 hover:bg-cream/5 hover:text-cream" href="{{ route('projects.finished') }}" @click="open=false">Finished</a>
                        <a class="block px-5 py-4 text-cream/80 hover:bg-cream/5 hover:text-cream" href="{{ route('projects.under_construction') }}" @click="open=false">Under construction</a>
                    </div>
                </div>

                <a
                    class="block rounded-2xl px-5 py-4 text-base border border-transparent hover:border-cream/10 hover:bg-cream/5"
                    href="{{ route('contact') }}"
                    @click="open=false"
                >
                    Contact
                </a>
            </div>

            <div class="px-6 pb-6">
                <a href="{{ route('contact') }}" class="btn btn-gold w-full" @click="open=false">Get in Touch →</a>

                <div class="mt-5 flex items-center justify-between text-xs text-cream/55">
                    <div>© {{ date('Y') }} Kamali</div>
                    <div class="flex gap-4">
                        <a class="hover:text-cream" href="#" aria-label="Instagram">IG</a>
                        <a class="hover:text-cream" href="#" aria-label="LinkedIn">IN</a>
                        <a class="hover:text-cream" href="#" aria-label="Behance">BE</a>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</header>

