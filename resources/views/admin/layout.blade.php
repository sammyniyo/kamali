<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="robots" content="noindex, nofollow" />
        <title>@yield('title', 'Admin') — Kamali Architects</title>
        <link rel="icon" type="image/png" href="{{ asset('images/kamali-logo-mark.png') }}" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body
        class="min-h-full bg-cream text-dark antialiased"
        x-data="{ mobileNav: false }"
        x-bind:class="mobileNav ? 'overflow-hidden lg:overflow-auto' : ''"
    >
        {{-- Mobile menu overlay --}}
        <div
            x-show="mobileNav"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-50 bg-dark/50 backdrop-blur-[2px] lg:hidden"
            @click="mobileNav = false"
            aria-hidden="true"
        ></div>

        {{-- Mobile slide-out --}}
        <aside
            x-show="mobileNav"
            x-cloak
            x-transition:enter="transition transform duration-200 ease-out"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform duration-200 ease-in"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed left-0 top-0 z-[60] flex h-full w-[min(20rem,92vw)] flex-col border-r border-dark/10 bg-white shadow-2xl lg:hidden"
            id="admin-mobile-nav"
            role="dialog"
            aria-modal="true"
            aria-label="Admin menu"
        >
            <div class="flex items-center justify-between border-b border-dark/10 px-4 py-4">
                <span class="font-display text-lg text-dark">Menu</span>
                <button
                    type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-dark/10 text-dark hover:bg-cream/80 focus:outline-none focus:ring-2 focus:ring-gold/25"
                    @click="mobileNav = false"
                    aria-label="Close menu"
                >
                    <span class="text-lg leading-none" aria-hidden="true">✕</span>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-4">
                @include('admin.partials.main-nav', ['closeMobileNav' => true])
            </div>
            <div class="border-t border-dark/10 p-4">
                <form method="post" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full btn btn-dark-outline">Logout</button>
                </form>
            </div>
        </aside>

        <div class="flex min-h-screen">
            <aside class="hidden w-72 shrink-0 flex-col border-r border-dark/10 bg-white/60 backdrop-blur lg:flex">
                <div class="border-b border-dark/10 px-6 py-6">
                    <div class="inline-flex rounded-xl bg-dark p-3 shadow-[inset_0_1px_0_rgba(255,255,255,0.06)] ring-1 ring-dark/20">
                        <x-brand-mark variant="compact" class="hover:opacity-100 focus-visible:ring-offset-dark" />
                    </div>
                    <div class="mt-4">
                        <span class="font-display text-xl text-dark">Admin</span>
                        <span class="mt-1 block text-[11px] uppercase tracking-[0.34em] text-gray">Kamali Architects</span>
                    </div>
                </div>
                <div class="flex-1 overflow-y-auto p-4">
                    @include('admin.partials.main-nav')
                </div>
                <div class="mt-auto border-t border-dark/10 p-4">
                    <form method="post" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="w-full btn btn-dark-outline">Logout</button>
                    </form>
                </div>
            </aside>

            <div class="flex min-w-0 flex-1 flex-col">
                <header class="sticky top-0 z-40 border-b border-dark/10 bg-cream/90 backdrop-blur">
                    <div class="mx-auto flex h-14 max-w-7xl items-center justify-between gap-3 px-4 sm:h-16 sm:px-8">
                        <div class="flex min-w-0 items-center gap-2 sm:gap-3">
                            <button
                                type="button"
                                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-dark/10 bg-white/80 text-dark hover:bg-white focus:outline-none focus:ring-2 focus:ring-gold/25 lg:hidden"
                                @click="mobileNav = true"
                                :aria-expanded="mobileNav.toString()"
                                aria-controls="admin-mobile-nav"
                                aria-label="Open menu"
                            >
                                <span class="sr-only">Open menu</span>
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path
                                        d="M5 7h14M5 12h14M5 17h14"
                                        stroke="currentColor"
                                        stroke-width="1.75"
                                        stroke-linecap="round"
                                    />
                                </svg>
                            </button>
                            <div class="min-w-0 font-display text-lg tracking-tight text-dark sm:text-xl">
                                <span class="truncate">@yield('header', 'Dashboard')</span>
                            </div>
                        </div>
                        <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                            <a
                                href="{{ route('home') }}"
                                target="_blank"
                                rel="noreferrer"
                                class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-dark/10 bg-white/70 text-dark hover:border-gold/40 sm:hidden"
                                aria-label="View public site"
                            >
                                <span class="text-gold" aria-hidden="true">↗</span>
                            </a>
                            <a
                                href="{{ route('home') }}"
                                target="_blank"
                                rel="noreferrer"
                                class="hidden rounded-full border border-dark/10 bg-white/70 px-3 py-2 text-xs font-medium text-dark/80 hover:border-gold/40 hover:text-dark sm:inline-flex sm:px-4 sm:text-sm"
                            >
                                View site <span class="text-gold" aria-hidden="true">↗</span>
                            </a>
                            <span class="hidden max-w-[10rem] truncate text-xs text-dark/55 sm:block md:max-w-[14rem] md:text-sm" title="{{ auth()->user()->email ?? '' }}">
                                {{ auth()->user()->email ?? '' }}
                            </span>
                        </div>
                    </div>
                </header>

                <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-8 sm:py-10">
                    @if (session('status'))
                        <div
                            class="mb-6 rounded-2xl border border-gold/35 bg-gold/10 px-5 py-4 text-sm text-dark"
                            role="status"
                        >
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div
                            class="mb-6 rounded-2xl border border-red-500/35 bg-red-500/10 px-5 py-4 text-sm text-dark"
                            role="alert"
                        >
                            {{ session('error') }}
                        </div>
                    @endif
                    @yield('content')
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
