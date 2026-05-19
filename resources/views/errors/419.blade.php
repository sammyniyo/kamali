@extends('layouts.app')

@section('title', 'Session expired — Kamali Architects')
@section('body_class', 'min-h-screen bg-dark text-cream')
@section('main_class', 'min-h-[70vh]')
@section('footer_no_margin', true)

@section('content')
    <section class="bg-dark text-cream">
        <div class="container-wide pt-32 md:pt-40 pb-20">
            <div class="label text-cream/60" data-animate="fade-up">· 419</div>
            <h1 class="mt-4 font-display text-6xl leading-[0.95]" data-animate="fade-up">
                Session<br />
                <span class="italic text-gold">expired</span>
            </h1>
            <p class="mt-6 max-w-2xl text-cream/75 leading-relaxed" data-animate="fade-up">
                Your session expired. Please refresh and try again.
            </p>
            <div class="mt-10 flex flex-wrap gap-4" data-animate="fade-up">
                <a class="btn btn-gold" href="{{ url()->current() }}">Refresh →</a>
                <a class="btn btn-outline" href="{{ route('admin.login') }}">Admin login</a>
            </div>
        </div>
    </section>
@endsection

