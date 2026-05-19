@extends('layouts.app')

@section('title', 'Server error — Kamali Architects')
@section('body_class', 'min-h-screen bg-dark text-cream')
@section('main_class', 'min-h-[70vh]')
@section('footer_no_margin', true)

@section('content')
    <section class="bg-dark text-cream">
        <div class="container-wide pt-32 md:pt-40 pb-20">
            <div class="label text-cream/60" data-animate="fade-up">· 500</div>
            <h1 class="mt-4 font-display text-6xl leading-[0.95]" data-animate="fade-up">
                Something<br />
                <span class="italic text-gold">went wrong</span>
            </h1>
            <p class="mt-6 max-w-2xl text-cream/75 leading-relaxed" data-animate="fade-up">
                Please try again in a moment. If the issue persists, contact us.
            </p>
            <div class="mt-10 flex flex-wrap gap-4" data-animate="fade-up">
                <a class="btn btn-gold" href="{{ route('home') }}">Go home →</a>
                <a class="btn btn-outline" href="{{ route('contact') }}">Contact us</a>
            </div>
        </div>
    </section>
@endsection

