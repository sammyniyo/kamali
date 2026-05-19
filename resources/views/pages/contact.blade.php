@extends('layouts.app')

@section('title', 'Contact — Kamali Architects')
@section('meta_description', 'Contact Kamali Architects in Kigali. Share your project scope and timeline — we’ll respond with next steps.')

@section('content')
    <section class="relative overflow-hidden bg-dark text-cream">
        <div class="pointer-events-none absolute inset-0 grain-soft opacity-[0.07]" aria-hidden="true"></div>
        <div class="container-wide relative pb-10 pt-[calc(4.25rem+2rem)] sm:pb-12 md:pb-14 md:pt-[calc(7rem+2.5rem)] lg:pt-40">
            <div class="max-w-3xl">
                <p class="label text-cream/70" data-animate="fade-up">· Contact</p>
                <h1 class="mt-4 h-display" data-animate="fade-up">Get in <span class="italic text-gold">Touch</span></h1>
                <p class="mt-5 max-w-2xl text-[15px] leading-relaxed text-cream/80 sm:mt-6 sm:text-base" data-animate="fade-up">
                    Share a short brief — site, programme, and timing. We read every message and reply with clear next steps (not a generic auto-reply).
                </p>
                <dl class="mt-8 flex flex-wrap gap-x-8 gap-y-4 text-sm text-cream/70" data-animate="fade-up">
                    <div>
                        <dt class="label text-cream/50">Response</dt>
                        <dd class="mt-1 font-medium text-cream/90">1–2 business days</dd>
                    </div>
                    <div>
                        <dt class="label text-cream/50">Studio</dt>
                        <dd class="mt-1 font-medium text-cream/90">{{ config('kamali.address.city') }}, {{ config('kamali.address.country') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>

    <section class="relative border-t border-dark/[0.06] bg-cream">
        <div class="pointer-events-none absolute inset-0 grain-soft opacity-[0.06] mix-blend-multiply" aria-hidden="true"></div>
        <div class="container-wide relative z-[1] py-12 sm:py-14 md:py-16">
            <div class="grid gap-8 sm:gap-10 lg:grid-cols-12 lg:gap-12">
                {{-- Reach us --}}
                <div class="lg:col-span-5" data-animate="fade-up">
                    <div class="overflow-hidden rounded-2xl border border-dark/10 bg-white/80 shadow-[0_2px_40px_rgba(26,26,24,0.04)] backdrop-blur md:rounded-3xl">
                        <div class="border-b border-dark/10 bg-gradient-to-br from-cream via-white to-cream px-6 py-6 sm:px-8 sm:py-7">
                            <p class="label text-dark/50">Reach us</p>
                            <p class="mt-2 font-display text-xl text-dark sm:text-2xl">Studio &amp; enquiries</p>
                            <p class="mt-3 text-sm leading-relaxed text-dark/60">
                                Call, email, or use the form — whichever is easiest. For site visits, we’ll coordinate a time that suits your calendar.
                            </p>
                        </div>
                        <div class="space-y-5 px-6 py-6 text-dark/75 sm:px-8 sm:py-7">
                            <div class="flex gap-4">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-gold/30 bg-gold/10 text-gold" aria-hidden="true">◎</span>
                                <div class="min-w-0">
                                    <div class="text-xs font-medium uppercase tracking-[0.2em] text-dark/45">Address</div>
                                    <p class="mt-1 leading-relaxed text-dark">
                                        <span class="block font-medium text-dark">{{ config('kamali.address.street') }}</span>
                                        <span class="block">{{ config('kamali.address.city') }}, {{ config('kamali.address.country') }}</span>
                                    </p>
                                    <a
                                        class="mt-3 inline-flex items-center gap-2 text-sm font-medium text-dark hover:text-dark/70"
                                        href="https://www.google.com/maps/search/?api=1&query={{ urlencode(config('kamali.map_embed_query')) }}"
                                        target="_blank"
                                        rel="noreferrer"
                                    >
                                        <span>Open in Google Maps</span>
                                        <span class="text-gold" aria-hidden="true">↗</span>
                                    </a>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-gold/30 bg-gold/10 text-gold" aria-hidden="true">☎</span>
                                <div class="min-w-0">
                                    <div class="text-xs font-medium uppercase tracking-[0.2em] text-dark/45">Phone</div>
                                    <a class="mt-1 block text-lg font-medium text-dark hover:text-dark/70" href="tel:{{ config('kamali.phone_tel') }}">{{ config('kamali.phone_display') }}</a>
                                    <a
                                        class="mt-2 inline-flex text-sm text-dark/65 hover:text-dark"
                                        href="https://wa.me/{{ preg_replace('/\D/', '', config('kamali.phone_tel')) }}"
                                        target="_blank"
                                        rel="noreferrer"
                                    >
                                        Message on WhatsApp <span class="ml-1 text-gold" aria-hidden="true">↗</span>
                                    </a>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-gold/30 bg-gold/10 text-gold" aria-hidden="true">✉</span>
                                <div class="min-w-0">
                                    <div class="text-xs font-medium uppercase tracking-[0.2em] text-dark/45">Email</div>
                                    <a class="mt-1 block break-all text-lg font-medium text-dark hover:text-dark/70" href="mailto:{{ config('kamali.email') }}">{{ config('kamali.email') }}</a>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-gold/30 bg-gold/10 text-gold" aria-hidden="true">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        />
                                        <path
                                            d="M3.6 9h16.8M3.6 15h16.8M12 3a15.3 15.3 0 0 1 4 9 15.3 15.3 0 0 1-4 9 15.3 15.3 0 0 1-4-9 15.3 15.3 0 0 1 4-9Z"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                        />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <div class="text-xs font-medium uppercase tracking-[0.2em] text-dark/45">Web</div>
                                    <a class="mt-1 block break-all font-medium text-dark hover:text-dark/70" href="{{ config('kamali.website_url') }}" target="_blank" rel="noreferrer">{{ config('kamali.website_host') }}</a>
                                </div>
                            </div>
                            <div class="rounded-2xl border border-dark/10 bg-cream/80 px-4 py-4">
                                <div class="label text-dark/45">Follow</div>
                                <div class="mt-3">
                                    <x-social-links variant="dark" />
                                </div>
                            </div>
                            <div>
                                <div class="label text-dark/45">Office hours</div>
                                <p class="mt-2 text-sm leading-relaxed text-dark/70">Mon–Fri · 09:00–18:00 <span class="text-dark/45">(CAT)</span></p>
                            </div>
                        </div>

                        <div class="border-t border-dark/10 px-2 pb-2 pt-2 sm:px-3 sm:pb-3">
                            <iframe
                                title="Map — {{ config('kamali.map_embed_query') }}"
                                class="h-52 w-full rounded-xl sm:h-60"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://www.google.com/maps?q={{ urlencode(config('kamali.map_embed_query')) }}&output=embed"
                            ></iframe>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <div class="lg:col-span-7" data-animate="fade-up">
                    <div class="scroll-mt-28 overflow-hidden rounded-2xl border border-dark/10 bg-white/80 shadow-[0_2px_48px_rgba(26,26,24,0.05)] backdrop-blur md:rounded-3xl md:scroll-mt-[8.75rem]" id="contact-form">
                        <div class="border-b border-dark/10 px-6 py-6 sm:px-8 sm:py-7">
                            <p class="label text-dark/50">Send a message</p>
                            <h2 class="mt-2 font-display text-2xl tracking-tight text-dark sm:text-3xl">Project enquiry</h2>
                            <p class="mt-3 max-w-xl text-sm leading-relaxed text-dark/60">
                                Fields marked with <span class="text-gold">*</span> are required. A little detail goes a long way — include location, approximate size, and whether you’re at concept stage or ready to appoint a team.
                            </p>
                        </div>

                        <div class="px-6 py-6 sm:px-8 sm:py-8">
                            @if (session('contact_status'))
                                <div
                                    class="mb-6 rounded-2xl border border-gold/35 bg-gold/10 px-5 py-4 text-dark"
                                    role="status"
                                >
                                    {{ session('contact_status') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div
                                    class="mb-6 rounded-2xl border border-dark/15 bg-cream px-5 py-4 text-dark"
                                    role="alert"
                                >
                                    <div class="font-medium text-dark">We couldn’t send that yet</div>
                                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-dark/80">
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="relative grid gap-6" method="post" action="{{ route('contact.store') }}" id="contact-form-fields">
                                @csrf
                                <input type="hidden" name="contact_form_nonce" value="{{ $contactFormNonce }}" autocomplete="off" />
                                <input
                                    type="hidden"
                                    name="form_opened_at"
                                    id="contact-form-opened-at"
                                    value="{{ old('form_opened_at', $contactFormOpenedAt ?? time()) }}"
                                    autocomplete="off"
                                />

                                {{-- Honeypot: leave empty (hidden from users, tempting for bots). --}}
                                <div class="absolute -left-[9999px] top-auto h-0 w-0 overflow-hidden" aria-hidden="true">
                                    <label for="company_website">Company website</label>
                                    <input
                                        id="company_website"
                                        type="text"
                                        name="company_website"
                                        tabindex="-1"
                                        autocomplete="off"
                                        value=""
                                    />
                                </div>

                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="label text-dark/50" for="name">Full name <span class="text-gold">*</span></label>
                                        <input
                                            id="name"
                                            name="name"
                                            class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3.5 text-dark placeholder:text-dark/35 outline-none transition focus:border-gold/60 focus:ring-2 focus:ring-gold/25 @error('name') border-red-500/60 @enderror"
                                            value="{{ old('name') }}"
                                            required
                                            autocomplete="name"
                                            placeholder="e.g. Jean Mukamana"
                                            maxlength="120"
                                        />
                                    </div>
                                    <div>
                                        <label class="label text-dark/50" for="email">Email <span class="text-gold">*</span></label>
                                        <input
                                            id="email"
                                            name="email"
                                            type="email"
                                            inputmode="email"
                                            class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3.5 text-dark placeholder:text-dark/35 outline-none transition focus:border-gold/60 focus:ring-2 focus:ring-gold/25 @error('email') border-red-500/60 @enderror"
                                            value="{{ old('email') }}"
                                            required
                                            autocomplete="email"
                                            placeholder="you@company.com"
                                            maxlength="255"
                                        />
                                    </div>
                                </div>
                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="label text-dark/50" for="phone">Phone <span class="text-dark/45">(optional)</span></label>
                                        <input
                                            id="phone"
                                            name="phone"
                                            type="tel"
                                            inputmode="tel"
                                            class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3.5 text-dark placeholder:text-dark/35 outline-none transition focus:border-gold/60 focus:ring-2 focus:ring-gold/25 @error('phone') border-red-500/60 @enderror"
                                            value="{{ old('phone') }}"
                                            autocomplete="tel"
                                            placeholder="+250 780 000 000"
                                            maxlength="40"
                                        />
                                    </div>
                                    <div>
                                        <label class="label text-dark/50" for="subject">Subject <span class="text-gold">*</span></label>
                                        <input
                                            id="subject"
                                            name="subject"
                                            type="text"
                                            class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3.5 text-dark placeholder:text-dark/35 outline-none transition focus:border-gold/60 focus:ring-2 focus:ring-gold/25 @error('subject') border-red-500/60 @enderror"
                                            value="{{ old('subject') }}"
                                            required
                                            placeholder="e.g. New residence — KN 7 area, feasibility"
                                            maxlength="200"
                                        />
                                    </div>
                                </div>
                                <div>
                                    <label class="label text-dark/50" for="message">Message <span class="text-gold">*</span></label>
                                    <textarea
                                        id="message"
                                        name="message"
                                        rows="7"
                                        class="mt-2 min-h-[10.5rem] w-full resize-y rounded-2xl border border-dark/10 bg-cream px-4 py-3.5 text-dark placeholder:text-dark/35 outline-none transition focus:border-gold/60 focus:ring-2 focus:ring-gold/25 @error('message') border-red-500/60 @enderror"
                                        required
                                        minlength="25"
                                        maxlength="8000"
                                        placeholder="Tell us about the site (neighbourhood or plot reference), the spaces you need, your ideal timeline, and any constraints (budget band, approvals, etc.). Example: ‘200 m² corner plot near …, looking for a 4-bed family home, would like to start concept in Q3 …’"
                                        aria-describedby="message-hint"
                                    >{{ old('message') }}</textarea>
                                    <p id="message-hint" class="mt-2 text-sm leading-relaxed text-dark/55">
                                        Minimum 25 characters — a short paragraph is enough. We read everything in full before replying.
                                    </p>
                                </div>

                                <div class="flex flex-col gap-4 rounded-2xl border border-dark/10 bg-cream/60 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                                    <p class="text-sm leading-relaxed text-dark/60">
                                        <span class="font-medium text-dark/75">Privacy:</span> we use your details only to respond to this enquiry — never for mailing lists or resale.
                                    </p>
                                    <button type="submit" class="btn btn-gold w-full shrink-0 justify-center sm:w-auto sm:min-w-[11rem]">
                                        Send message →
                                    </button>
                                </div>
                            </form>

                            @if (!$errors->any())
                                <script>
                                    (function () {
                                        var el = document.getElementById('contact-form-opened-at');
                                        if (el) {
                                            el.value = String(Math.floor(Date.now() / 1000));
                                        }
                                    })();
                                </script>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
