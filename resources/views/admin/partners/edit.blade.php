@extends('admin.layout')

@section('title', 'Edit Partner')
@section('header', 'Edit Partner')

@section('content')
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-dark/10 bg-white/70 backdrop-blur px-5 py-4 text-sm text-dark/80">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="post" action="{{ route('admin.partners.update', $partner) }}" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('admin.partners._form', ['partner' => $partner])
    </form>
@endsection
