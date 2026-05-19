@extends('admin.layout')

@section('title', 'Message')
@section('header', 'Message')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a class="btn btn-dark-outline" href="{{ route('admin.messages.index') }}">← Back</a>
        <div class="flex items-center gap-3">
            @if (is_null($message->read_at))
                <form method="post" action="{{ route('admin.messages.read', $message) }}">
                    @csrf
                    <button class="btn btn-gold" type="submit">Mark as read</button>
                </form>
            @else
                <form method="post" action="{{ route('admin.messages.unread', $message) }}">
                    @csrf
                    <button class="btn btn-dark-outline" type="submit">Mark as unread</button>
                </form>
            @endif
            <form method="post" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
                @csrf
                @method('delete')
                <button class="btn btn-dark-outline" type="submit">Delete</button>
            </form>
        </div>
    </div>

    <div class="mt-8 rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <div class="label text-dark/50">From</div>
                <div class="mt-2 text-lg font-medium text-dark">{{ $message->name }}</div>
                <div class="mt-2 text-sm text-dark/70">{{ $message->email }}</div>
                @if ($message->phone)
                    <div class="mt-1 text-sm text-dark/70">{{ $message->phone }}</div>
                @endif
            </div>
            <div>
                <div class="label text-dark/50">Meta</div>
                <div class="mt-2 text-sm text-dark/70">Received: {{ $message->created_at->format('Y-m-d H:i') }}</div>
                <div class="mt-1 text-sm text-dark/70">Status: {{ $message->read_at ? 'Read' : 'Unread' }}</div>
                <div class="mt-1 text-sm text-dark/70">Subject: {{ $message->subject ?? '—' }}</div>
            </div>
        </div>

        <div class="mt-8">
            <div class="label text-dark/50">Message</div>
            <div class="mt-3 whitespace-pre-wrap text-dark/80 leading-relaxed">{{ $message->message }}</div>
        </div>
    </div>
@endsection

