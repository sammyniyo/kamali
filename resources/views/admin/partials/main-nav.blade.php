@php
    $mainNav = [
        ['match' => 'admin.dashboard', 'route' => 'admin.dashboard', 'label' => 'Dashboard'],
        ['match' => 'admin.projects.*', 'route' => 'admin.projects.index', 'label' => 'Projects'],
        ['match' => 'admin.blogs.*', 'route' => 'admin.blogs.index', 'label' => 'Blog'],
        ['match' => 'admin.services.*', 'route' => 'admin.services.index', 'label' => 'Services'],
        ['match' => 'admin.team.*', 'route' => 'admin.team.index', 'label' => 'Team'],
        ['match' => 'admin.partners.*', 'route' => 'admin.partners.index', 'label' => 'Partners'],
        ['match' => 'admin.users.*', 'route' => 'admin.users.index', 'label' => 'Users'],
        ['match' => 'admin.messages.*', 'route' => 'admin.messages.index', 'label' => 'Messages'],
    ];
@endphp

<nav class="space-y-1 text-sm" aria-label="Admin sections">
    @foreach ($mainNav as $link)
        @php
            $active = request()->routeIs($link['match']);
        @endphp
        <a
            href="{{ route($link['route']) }}"
            @if (isset($closeMobileNav) && $closeMobileNav)
                @click="mobileNav = false"
            @endif
            @class([
                'flex items-center rounded-xl px-4 py-3 border transition',
                'bg-dark text-cream border-dark shadow-sm' => $active,
                'border-transparent text-dark hover:bg-cream/80 hover:border-dark/10' => ! $active,
            ])
            @if ($active) aria-current="page" @endif
        >
            <span class="min-w-0 truncate">{{ $link['label'] }}</span>
        </a>
    @endforeach
</nav>
