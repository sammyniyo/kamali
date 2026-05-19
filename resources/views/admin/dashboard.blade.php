@extends('admin.layout')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    @php
        $stats = [
            [
                'label' => 'Projects',
                'value' => \App\Models\Project::count(),
                'route' => 'admin.projects.index',
                'hint' => 'Portfolio entries',
            ],
            [
                'label' => 'Services',
                'value' => \App\Models\Service::count(),
                'route' => 'admin.services.index',
                'hint' => 'Expertise cards',
            ],
            [
                'label' => 'Team',
                'value' => \App\Models\TeamMember::count(),
                'route' => 'admin.team.index',
                'hint' => 'Architect profiles',
            ],
            [
                'label' => 'Blog',
                'value' => \App\Models\Blog::count(),
                'route' => 'admin.blogs.index',
                'hint' => 'Journal posts',
            ],
            [
                'label' => 'Unread',
                'value' => \App\Models\ContactMessage::whereNull('read_at')->count(),
                'route' => 'admin.messages.index',
                'hint' => 'Contact inbox',
            ],
        ];
    @endphp

    <div class="grid gap-4 sm:gap-6 sm:grid-cols-2 xl:grid-cols-5">
        @foreach ($stats as $card)
            <a
                href="{{ route($card['route']) }}"
                class="group rounded-2xl border border-dark/10 bg-white/70 p-5 shadow-[0_2px_24px_rgba(26,26,24,0.04)] backdrop-blur transition hover:-translate-y-0.5 hover:border-gold/35 hover:shadow-[0_8px_32px_rgba(26,26,24,0.08)] sm:p-6"
            >
                <div class="label text-dark/50">{{ $card['label'] }}</div>
                <div class="mt-2 font-display text-3xl text-dark tabular-nums sm:text-4xl">{{ $card['value'] }}</div>
                <div class="mt-2 flex items-center justify-between gap-2 text-xs text-dark/55 sm:text-sm">
                    <span>{{ $card['hint'] }}</span>
                    <span class="text-gold opacity-0 transition group-hover:opacity-100" aria-hidden="true">→</span>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-8 grid gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-2xl border border-dark/10 bg-white/70 p-5 backdrop-blur sm:p-6 lg:col-span-3">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="label text-dark/50">Visitors</div>
                    <div class="mt-1 font-display text-xl text-dark sm:text-2xl">Last 30 days</div>
                </div>
                <p class="text-xs text-dark/55 sm:text-sm">Page views and unique visitors (daily totals).</p>
            </div>
            <div class="mt-6 h-[min(22rem,55vw)] w-full min-h-[220px] sm:h-80">
                <canvas id="adminVisitorsChart" data-chart='@json($visitorChart ?? ['labels' => [], 'visits' => [], 'unique' => []])'></canvas>
            </div>
        </div>
    </div>

    <div class="mt-8 grid gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-2xl border border-dark/10 bg-white/70 p-5 backdrop-blur sm:p-6">
            <div class="label text-dark/50">Traffic today</div>
            <div class="mt-2 font-display text-3xl text-dark tabular-nums sm:text-4xl">{{ $visitsToday ?? 0 }}</div>
            <div class="mt-2 text-sm text-dark/60">Unique visitors: {{ $uniqueToday ?? 0 }}</div>
        </div>
        <div class="rounded-2xl border border-dark/10 bg-white/70 p-5 backdrop-blur sm:p-6">
            <div class="label text-dark/50">Last 7 days</div>
            <div class="mt-2 font-display text-3xl text-dark tabular-nums sm:text-4xl">{{ $visits7d ?? 0 }}</div>
            <div class="mt-2 text-sm text-dark/60">Unique (sum): {{ $unique7d ?? 0 }}</div>
        </div>
        <div class="rounded-2xl border border-dark/10 bg-white/70 p-5 backdrop-blur md:col-span-2 lg:col-span-1 sm:p-6">
            <div class="label text-dark/50">All time</div>
            <div class="mt-2 font-display text-3xl text-dark tabular-nums sm:text-4xl">{{ $visitsAll ?? 0 }}</div>
            <div class="mt-2 text-sm text-dark/60">Unique (sum): {{ $uniqueAll ?? 0 }}</div>
        </div>
    </div>

    <div class="mt-10 grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-dark/10 bg-white/70 p-6 backdrop-blur">
            <div class="font-display text-xl text-dark sm:text-2xl">Shortcuts</div>
            <p class="mt-2 text-sm text-dark/60">Jump to the areas you update most often.</p>
            <ul class="mt-5 grid gap-2 text-sm">
                <li>
                    <a class="flex items-center justify-between rounded-xl border border-dark/10 bg-cream/50 px-4 py-3 transition hover:border-gold/35 hover:bg-white" href="{{ route('admin.projects.create') }}">
                        <span>New project</span>
                        <span class="text-gold" aria-hidden="true">→</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between rounded-xl border border-dark/10 bg-cream/50 px-4 py-3 transition hover:border-gold/35 hover:bg-white" href="{{ route('admin.messages.index') }}">
                        <span>Inbox</span>
                        <span class="text-gold" aria-hidden="true">→</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between rounded-xl border border-dark/10 bg-cream/50 px-4 py-3 transition hover:border-gold/35 hover:bg-white" href="{{ route('admin.team.create') }}">
                        <span>New team member</span>
                        <span class="text-gold" aria-hidden="true">→</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between rounded-xl border border-dark/10 bg-cream/50 px-4 py-3 transition hover:border-gold/35 hover:bg-white" href="{{ route('admin.blogs.create') }}">
                        <span>New blog post</span>
                        <span class="text-gold" aria-hidden="true">→</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between rounded-xl border border-dark/10 bg-cream/50 px-4 py-3 transition hover:border-gold/35 hover:bg-white" href="{{ route('admin.users.index') }}">
                        <span>Admin users</span>
                        <span class="text-gold" aria-hidden="true">→</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="rounded-2xl border border-dark/10 bg-white/70 p-6 backdrop-blur">
            <div class="font-display text-xl text-dark sm:text-2xl">Tips</div>
            <ul class="mt-4 list-disc space-y-3 pl-5 text-sm leading-relaxed text-dark/70">
                <li>Upload cover images and galleries so project pages stay visual on the public site.</li>
                <li>Mark messages as read after you reply so the team can see what is still open.</li>
                <li>Use <strong class="font-medium text-dark/85">Featured</strong> on a project to surface it in homepage highlights.</li>
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js" crossorigin="anonymous"></script>
    <script>
        (function () {
            const canvas = document.getElementById('adminVisitorsChart');
            if (!canvas || typeof Chart === 'undefined') {
                return;
            }
            let payload;
            try {
                payload = JSON.parse(canvas.getAttribute('data-chart') || '{}');
            } catch (e) {
                return;
            }
            const labels = payload.labels || [];
            const visits = payload.visits || [];
            const unique = payload.unique || [];
            const gold = '#c9a84c';
            const dark = 'rgba(26, 26, 24, 0.55)';
            const grid = 'rgba(26, 26, 24, 0.08)';
            const rootStyles = getComputedStyle(document.documentElement);
            const cream = rootStyles.getPropertyValue('--color-cream').trim() || '#f5f0e8';

            new Chart(canvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Page views',
                            data: visits,
                            tension: 0.25,
                            borderColor: gold,
                            backgroundColor: 'rgba(201, 168, 76, 0.12)',
                            fill: true,
                            pointRadius: 0,
                            pointHitRadius: 8,
                            borderWidth: 2,
                        },
                        {
                            label: 'Unique visitors',
                            data: unique,
                            tension: 0.25,
                            borderColor: dark,
                            backgroundColor: 'rgba(26, 26, 24, 0.04)',
                            fill: true,
                            pointRadius: 0,
                            pointHitRadius: 8,
                            borderWidth: 2,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: { usePointStyle: true, boxWidth: 8 },
                        },
                        tooltip: {
                            backgroundColor: 'rgba(26, 26, 24, 0.92)',
                            titleColor: cream,
                            bodyColor: cream,
                            padding: 12,
                            cornerRadius: 12,
                        },
                    },
                    scales: {
                        x: {
                            grid: { color: grid },
                            ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 10, color: 'rgba(26,26,24,0.45)' },
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: grid },
                            ticks: { precision: 0, color: 'rgba(26,26,24,0.45)' },
                        },
                    },
                },
            });
        })();
    </script>
@endpush
