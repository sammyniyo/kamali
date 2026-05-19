<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Reset Password — Admin — Kamali Architects</title>
        <link rel="icon" type="image/png" href="{{ asset('images/kamali-logo-mark.png') }}" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-dark text-cream">
        <div class="min-h-screen flex items-center justify-center px-5">
            <div class="w-full max-w-md rounded-2xl border border-cream/10 bg-dark/55 backdrop-blur p-8">
                <div class="flex flex-wrap items-center gap-4">
                    <x-brand-mark variant="admin" />
                    <span class="label text-cream/55">Admin</span>
                </div>

                <h1 class="mt-6 font-display text-3xl">Reset password</h1>
                <p class="mt-2 text-sm text-cream/70">We’ll email you a secure reset link.</p>

                @if (session('status'))
                    <div class="mt-6 rounded-2xl border border-cream/10 bg-dark/40 p-4 text-sm text-cream/80">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-cream/10 bg-dark/40 p-4 text-sm text-cream/80">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="mt-6 grid gap-5" method="post" action="{{ route('admin.password.email') }}">
                    @csrf
                    <div>
                        <label class="label text-cream/60" for="email">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            class="mt-2 w-full rounded-2xl border border-cream/10 bg-dark/40 px-4 py-3 text-cream outline-none focus:border-gold/60"
                            required
                            autofocus
                        />
                    </div>
                    <button class="btn btn-gold w-full" type="submit">Send reset link →</button>
                </form>

                <div class="mt-6 text-center">
                    <a class="text-sm text-cream/70 hover:text-cream" href="{{ route('admin.login') }}">Back to sign in</a>
                </div>
            </div>
        </div>
    </body>
</html>

