@extends('admin.layout')

@section('title', 'Edit Project')
@section('header', 'Edit Project')

@section('content')
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-dark/10 bg-white/70 backdrop-blur px-5 py-4 text-sm text-dark/80">
            {{ $errors->first() }}
        </div>
    @endif

    <form
        id="admin-project-form"
        method="post"
        action="{{ route('admin.projects.update', $project) }}"
        enctype="multipart/form-data"
        x-data="adminProjectForm({ isEdit: true, currentSort: {{ (int) $project->sort_order }} })"
        @submit.prevent="submit()"
    >
        @csrf
        @method('put')
        @include('admin.projects._form', ['project' => $project])
    </form>
@endsection

