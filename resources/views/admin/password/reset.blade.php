<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Set New Password — Admin — Kamali Architects</title>
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

                <h1 class="mt-6 font-display text-3xl">Choose a new password</h1>
                <p class="mt-2 text-sm text-cream/70">Use a strong password you don’t reuse elsewhere.</p>

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-cream/10 bg-dark/40 p-4 text-sm text-cream/80">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="mt-6 grid gap-5" method="post" action="{{ route('admin.password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}" />
                    <div>
                        <label class="label text-cream/60" for="email">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $email) }}"
                            class="mt-2 w-full rounded-2xl border border-cream/10 bg-dark/40 px-4 py-3 text-cream outline-none focus:border-gold/60"
                            required
                            autofocus
                        />
                    </div>
                    <div>
                        <label class="label text-cream/60" for="password">New password</label>
                        <div class="relative mt-2" data-password-field>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="w-full rounded-2xl border border-cream/10 bg-dark/40 px-4 py-3 pr-12 text-cream outline-none focus:border-gold/60"
                                required
                            />
                            <button
                                type="button"
                                class="absolute right-2 top-1/2 -translate-y-1/2 inline-flex h-9 w-9 items-center justify-center rounded-full border border-cream/15 bg-dark/30 text-cream/80 hover:text-cream hover:bg-dark/45 transition focus:outline-none focus:ring-2 focus:ring-gold/25"
                                data-password-toggle
                                aria-label="Show password"
                            >
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true" data-eye="open">
                                    <path
                                        d="M2.5 12s3.4-6.5 9.5-6.5S21.5 12 21.5 12s-3.4 6.5-9.5 6.5S2.5 12 2.5 12Z"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                    <path
                                        d="M12 15.2a3.2 3.2 0 1 0 0-6.4 3.2 3.2 0 0 0 0 6.4Z"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                                <svg class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true" data-eye="closed">
                                    <path
                                        d="M4 4l16 16"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linecap="round"
                                    />
                                    <path
                                        d="M10.2 10.3a2.8 2.8 0 0 0 3.5 3.5"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                    <path
                                        d="M6.6 6.9C4 8.7 2.5 12 2.5 12s3.4 6.5 9.5 6.5c1.7 0 3.2-.3 4.6-.9"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                    <path
                                        d="M9.4 5.8c.8-.2 1.7-.3 2.6-.3C18.1 5.5 21.5 12 21.5 12s-1.3 2.5-3.9 4.4"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="label text-cream/60" for="password_confirmation">Confirm password</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="mt-2 w-full rounded-2xl border border-cream/10 bg-dark/40 px-4 py-3 text-cream outline-none focus:border-gold/60"
                            required
                        />
                    </div>

                    <button class="btn btn-gold w-full" type="submit">Reset password →</button>
                </form>

                <div class="mt-6 text-center">
                    <a class="text-sm text-cream/70 hover:text-cream" href="{{ route('admin.login') }}">Back to sign in</a>
                </div>
            </div>
        </div>
    </body>
</html>

