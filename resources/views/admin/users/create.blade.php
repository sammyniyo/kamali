@extends('admin.layout')

@section('title', 'New user')
@section('header', 'New user')

@section('content')
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-dark/10 bg-white/70 backdrop-blur px-5 py-4 text-sm text-dark/80">
            {{ $errors->first() }}
        </div>
    @endif

    <form
        id="admin-user-form"
        method="post"
        action="{{ route('admin.users.store') }}"
        x-data="adminUserForm({ isEdit: false })"
        @submit.prevent="submit()"
    >
        @csrf
        @include('admin.users._form')
    </form>
@endsection

