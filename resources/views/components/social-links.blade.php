@props([
    'variant' => 'dark', // 'dark' (on cream) | 'light' (on dark)
])

@php
    $items = [
        [
            'label' => 'Website',
            'href' => config('kamali.website_url'),
            'icon' => 'website',
        ],
        [
            'label' => 'Instagram',
            'href' => 'https://www.instagram.com/kamaliarchitects/',
            'icon' => 'instagram',
        ],
        [
            'label' => 'Linktree',
            'href' => 'https://linktr.ee/KAMALIArchitects',
            'icon' => 'link',
        ],
    ];

    $base =
        'inline-flex h-10 w-10 items-center justify-center rounded-full border transition focus:outline-none focus:ring-2 focus:ring-gold/25';

    $theme =
        $variant === 'light'
            ? 'border-cream/15 bg-dark/35 text-cream/85 hover:text-cream hover:bg-cream/5'
            : 'border-dark/10 bg-white/70 text-dark/70 hover:text-dark hover:bg-white';
@endphp

<div class="flex items-center gap-3">
    @foreach ($items as $it)
        <a
            class="{{ $base }} {{ $theme }}"
            href="{{ $it['href'] }}"
            target="_blank"
            rel="noreferrer"
            aria-label="{{ $it['label'] }}"
            title="{{ $it['label'] }}"
        >
            <span class="sr-only">{{ $it['label'] }}</span>

            @if ($it['icon'] === 'website')
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path
                        d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"
                        stroke="currentColor"
                        stroke-width="1.6"
                    />
                    <path
                        d="M3.6 9h16.8M3.6 15h16.8M12 3a15.3 15.3 0 0 1 4 9 15.3 15.3 0 0 1-4 9 15.3 15.3 0 0 1-4-9 15.3 15.3 0 0 1 4-9Z"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                    />
                </svg>
            @elseif ($it['icon'] === 'instagram')
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path
                        d="M16.5 7.5h.01M7.75 3.5h8.5A4.75 4.75 0 0 1 21 8.25v8.5A4.75 4.75 0 0 1 16.25 21.5h-8.5A4.75 4.75 0 0 1 3 16.75v-8.5A4.75 4.75 0 0 1 7.75 3.5Z"
                        stroke="currentColor"
                        stroke-width="1.6"
                    />
                    <path
                        d="M12 16.2a4.2 4.2 0 1 0 0-8.4 4.2 4.2 0 0 0 0 8.4Z"
                        stroke="currentColor"
                        stroke-width="1.6"
                    />
                </svg>
            @else
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path
                        d="M10.6 13.4a3.5 3.5 0 0 0 4.9 0l2.3-2.3a3.5 3.5 0 0 0-5-5l-1.3 1.3"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M13.4 10.6a3.5 3.5 0 0 0-4.9 0L6.2 12.9a3.5 3.5 0 0 0 5 5l1.3-1.3"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            @endif
        </a>
    @endforeach
</div>

