@extends('admin.layout')

@section('title', 'New Service')
@section('header', 'New Service')

@section('content')
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-dark/10 bg-white/70 backdrop-blur px-5 py-4 text-sm text-dark/80">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="post" action="{{ route('admin.services.store') }}">
        @csrf
        @include('admin.services._form')
    </form>
@endsection

