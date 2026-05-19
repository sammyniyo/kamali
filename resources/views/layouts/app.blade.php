<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
        <meta name="theme-color" content="#f5f0e8" />
        <meta name="color-scheme" content="light" />

        <title>@yield('title', 'Kamali Architects')</title>
        <meta name="description" content="@yield('meta_description', 'Kamali Architects — luxury architecture and design studio.')" />

        @stack('head')

        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/kamali-logo-mark.png') }}" />
        <link rel="apple-touch-icon" href="{{ asset('images/kamali-logo-mark.png') }}" />

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            rel="preload"
            href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,600&display=swap"
            as="style"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,600&display=swap"
            rel="stylesheet"
            media="print"
            onload="this.media='all'"
        />
        <noscript>
            <link
                href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,600&display=swap"
                rel="stylesheet"
            />
        </noscript>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="@yield('body_class', 'min-h-screen')">
        <div data-transition="overlay" class="transition-overlay" aria-hidden="true"></div>
        <div class="fixed left-0 top-0 z-[60] h-[2px] w-full bg-gold/20">
            <div data-scroll="progress" class="h-full w-0 bg-gold"></div>
        </div>

        @include('partials.nav')

        <main class="@yield('main_class', 'min-h-[60vh]')">
            @yield('content')
        </main>

        @include('partials.footer')

        <button
            type="button"
            data-scroll="to-top"
            class="fixed bottom-[max(1.5rem,env(safe-area-inset-bottom,0px))] right-[max(1.5rem,env(safe-area-inset-right,0px))] z-[60] hidden h-11 w-11 items-center justify-center rounded-full border border-dark/10 bg-cream/90 text-dark shadow-lg backdrop-blur transition motion-reduce:hover:translate-y-0 hover:-translate-y-0.5"
            aria-label="Back to top"
        >
            ↑
        </button>
    </body>
</html>

