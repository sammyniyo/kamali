@extends('layouts.app')

@section('title', $blog->title.' — Kamali Architects')
@section('meta_description', $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->body), 155))

@section('content')
    <article>
        <header class="relative min-h-[min(52svh,32rem)] overflow-hidden bg-dark text-cream">
            <div class="absolute inset-0" aria-hidden="true">
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    style="background-image: url('{{ \App\Support\KamaliMedia::blogCover($blog->cover_image, 0) }}');"
                ></div>
                <div class="absolute inset-0 bg-dark/55"></div>
                <div class="absolute inset-0 overlay-gradient" aria-hidden="true"></div>
            </div>

            <div class="container-wide relative pb-14 pt-[calc(4.25rem+2rem)] sm:pb-16 md:pt-[calc(7rem+2.5rem)] lg:pt-40">
                <p class="label text-cream/70" data-animate="fade-up">
                    <a class="underline-offset-4 hover:underline" href="{{ route('blog.index') }}">Journal</a>
                    <span class="text-cream/40" aria-hidden="true"> · </span>
                    <time datetime="{{ $blog->published_at?->toIso8601String() }}">{{ $blog->published_at?->format('F j, Y') }}</time>
                </p>
                <h1 class="mt-4 max-w-4xl font-display text-[2rem] leading-[1.05] tracking-tight text-cream sm:text-4xl md:text-[2.75rem]" data-animate="fade-up">
                    {{ $blog->title }}
                </h1>
                @if ($blog->excerpt)
                    <p class="mt-6 max-w-2xl text-base leading-relaxed text-cream/80 sm:text-lg" data-animate="fade-up">
                        {{ $blog->excerpt }}
                    </p>
                @endif
            </div>
        </header>

        <div class="bg-cream">
            <div class="container-wide section-pad max-w-3xl">
                <div
                    class="prose prose-neutral max-w-none text-dark/85 prose-headings:font-display prose-a:text-gold prose-a:no-underline hover:prose-a:underline prose-blockquote:border-gold/40 prose-img:rounded-2xl prose-p:leading-relaxed prose-p:text-[15px] sm:prose-p:text-base"
                    data-animate="fade-up"
                >
                    {!! $blog->body !!}
                </div>

                <div class="mt-12 border-t border-dark/10 pt-10" data-animate="fade-up">
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-dark hover:text-gold">
                        ← Back to journal
                    </a>
                </div>
            </div>
        </div>
    </article>
@endsection
