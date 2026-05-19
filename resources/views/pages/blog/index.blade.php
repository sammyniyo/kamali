@extends('layouts.app')

@section('title', 'Journal — Kamali Architects')
@section('meta_description', 'Notes on architecture, materials, and studio process from Kamali Architects.')

@section('content')
    <section class="relative overflow-hidden bg-dark text-cream">
        <div class="container-wide pb-10 pt-[calc(4.25rem+2rem)] sm:pb-12 md:pb-14 md:pt-[calc(7rem+2.5rem)] lg:pt-40">
            <p class="label text-cream/70" data-animate="fade-up">· Journal</p>
            <div class="mt-3 flex flex-col gap-3 sm:mt-4 sm:flex-row sm:flex-wrap sm:items-end sm:justify-between sm:gap-6" data-animate="fade-up">
                <h1 class="h-display">Studio <span class="italic text-gold">Writing</span></h1>
                <p class="text-sm text-cream/70 sm:text-base"><span class="tabular-nums">{{ $posts->total() }}</span> articles</p>
            </div>
        </div>
    </section>

    <section class="bg-cream">
        <div class="container-wide py-10 sm:py-12 md:py-14">
            @if ($posts->isEmpty())
                <x-empty-state
                    heading="Coming soon"
                    body="We are preparing editorial pieces on process, materials, and selected projects."
                />
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <article
                            class="group relative flex flex-col overflow-hidden rounded-2xl border border-dark/10 bg-white/70 shadow-[0_2px_24px_rgba(26,26,24,0.04)] backdrop-blur transition hover:-translate-y-0.5 hover:border-gold/35 hover:shadow-[0_8px_32px_rgba(26,26,24,0.08)]"
                            data-animate="fade-up"
                        >
                            <div class="aspect-[16/10] bg-dark/10">
                                <img
                                    src="{{ \App\Support\KamaliMedia::blogCover($post->cover_image, $loop->index) }}"
                                    alt=""
                                    class="h-full w-full object-cover"
                                    loading="lazy"
                                />
                            </div>
                            <div class="flex flex-1 flex-col p-6">
                                <time class="label text-dark/45" datetime="{{ $post->published_at?->toIso8601String() }}">
                                    {{ $post->published_at?->format('M j, Y') }}
                                </time>
                                <h2 class="mt-3 font-display text-2xl leading-snug text-dark group-hover:text-dark/90">
                                    <a class="stretched-link outline-none focus-visible:ring-2 focus-visible:ring-gold/40 rounded-lg" href="{{ route('blog.show', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                @if ($post->excerpt)
                                    <p class="mt-3 flex-1 text-sm leading-relaxed text-dark/65">{{ $post->excerpt }}</p>
                                @endif
                                <div class="mt-5 text-sm text-gold">Read →</div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($posts->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $posts->onEachSide(1)->links('components.pagination') }}
                    </div>
                @endif
            @endif
        </div>
    </section>
@endsection
