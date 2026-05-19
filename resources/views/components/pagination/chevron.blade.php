@props([
    'direction' => 'next',
])

@php
    $isText = in_array($direction, ['first', 'last'], true);
@endphp

@if ($isText)
    <span class="text-base leading-none font-medium" aria-hidden="true">{{ $direction === 'first' ? '«' : '»' }}</span>
@else
    @php
        $path = $direction === 'prev'
            ? 'M12.79 5.23a.75.75 0 0 1-.02 1.06L8.832 10l3.938 3.71a.75.75 0 1 1-1.04 1.08l-4.5-4.25a.75.75 0 0 1 0-1.08l4.5-4.25a.75.75 0 0 1 1.06.02Z'
            : 'M7.21 14.77a.75.75 0 0 1 .02-1.06L11.168 10 7.23 6.29a.75.75 0 1 1 1.04-1.08l4.5 4.25a.75.75 0 0 1 0 1.08l-4.5 4.25a.75.75 0 0 1-1.06-.02Z';
    @endphp
    <svg class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="{{ $path }}" clip-rule="evenodd" />
    </svg>
@endif
