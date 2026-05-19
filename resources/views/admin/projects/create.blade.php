@extends('admin.layout')

@section('title', 'New Project')
@section('header', 'New Project')

@section('content')
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-dark/10 bg-white/70 backdrop-blur px-5 py-4 text-sm text-dark/80">
            {{ $errors->first() }}
        </div>
    @endif

    <form
        id="admin-project-form"
        method="post"
        action="{{ route('admin.projects.store') }}"
        enctype="multipart/form-data"
        x-data="adminProjectForm({ isEdit: false, nextSort: {{ (int) ($nextSortOrder ?? 1) }} })"
        @submit.prevent="submit()"
    >
        @csrf
        @include('admin.projects._form')
    </form>
@endsection

