@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Pagination\Paginator $paginator */
    $variant = $variant ?? 'public';
    $itemLabel = $itemLabel ?? 'results';
    $perPageOptions = $perPageOptions ?? null;

    $from = $paginator->firstItem() ?? 0;
    $to = $paginator->lastItem() ?? 0;
    $total = $paginator->total();
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();

    $isAdmin = $variant === 'admin';
    $btnBase = $isAdmin
        ? 'inline-flex h-10 min-w-10 items-center justify-center rounded-xl border text-sm transition focus:outline-none focus:ring-2 focus:ring-gold/30 focus:ring-offset-2 focus:ring-offset-cream'
        : 'inline-flex h-10 min-w-10 items-center justify-center rounded-full border text-sm transition focus:outline-none focus:ring-2 focus:ring-gold/25';

    $btnIdle = $isAdmin
        ? 'border-dark/10 bg-white/80 text-dark hover:border-dark/20 hover:bg-white'
        : 'border-dark/10 bg-white/70 text-dark hover:bg-white';

    $btnDisabled = $isAdmin
        ? 'border-dark/10 bg-cream/60 text-dark/30 cursor-not-allowed'
        : 'border-dark/10 bg-white/50 text-dark/30 cursor-not-allowed';

    $btnActive = $isAdmin
        ? 'border-gold/50 bg-dark text-cream shadow-[0_8px_24px_rgba(0,0,0,0.1)]'
        : 'border-gold/40 bg-dark text-cream shadow-[0_10px_30px_rgba(0,0,0,0.12)]';

    $summaryText = $total === 0
        ? 'No '.$itemLabel
        : ($total === 1
            ? 'Showing 1 '.$itemLabel
            : 'Showing '.$from.'–'.$to.' of '.$total.' '.$itemLabel);

    $adminPerPage = \App\Support\ProjectPagination::adminPerPage(request());
@endphp

@if ($total > 0)
    <div
        class="kamali-pagination {{ $isAdmin ? 'kamali-pagination--admin' : 'kamali-pagination--public' }}"
        data-pagination
        @if (! $isAdmin) data-pagination-scroll-target @endif
    >
        <div class="kamali-pagination__bar">
            <p class="kamali-pagination__summary">
                {{ $summaryText }}
            </p>

            @if ($isAdmin && is_array($perPageOptions) && count($perPageOptions))
                <form method="get" class="kamali-pagination__per-page" aria-label="Results per page">
                    @foreach (request()->except(['per_page', 'page']) as $key => $value)
                        @if (is_array($value))
                            @foreach ($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}" />
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
                        @endif
                    @endforeach
                    <label class="sr-only" for="pagination-per-page">Per page</label>
                    <select
                        id="pagination-per-page"
                        name="per_page"
                        class="rounded-xl border border-dark/10 bg-white/80 px-3 py-2 text-sm text-dark outline-none focus:border-gold/60 focus:ring-2 focus:ring-gold/25"
                        onchange="this.form.submit()"
                    >
                        @foreach ($perPageOptions as $option)
                            <option value="{{ $option }}" @selected($adminPerPage === (int) $option)>
                                {{ $option }} / page
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif

            @if ($paginator->hasPages())
                <nav class="kamali-pagination__nav" aria-label="Pagination">
                    @if ($paginator->onFirstPage())
                        <span class="{{ $btnBase }} {{ $btnDisabled }} px-3" aria-disabled="true">
                            <span class="sr-only">First page</span>
                            <x-pagination.chevron direction="first" />
                        </span>
                    @else
                        <a
                            href="{{ $paginator->url(1) }}"
                            class="{{ $btnBase }} {{ $btnIdle }} px-3"
                            aria-label="First page"
                            @if (! $isAdmin) data-pagination-link @endif
                        >
                            <x-pagination.chevron direction="first" />
                        </a>
                    @endif

                    @if ($paginator->onFirstPage())
                        <span class="{{ $btnBase }} {{ $btnDisabled }} gap-1.5 px-3 sm:px-4" aria-disabled="true">
                            <x-pagination.chevron direction="prev" />
                            <span class="hidden sm:inline">Prev</span>
                        </span>
                    @else
                        <a
                            href="{{ $paginator->previousPageUrl() }}"
                            rel="prev"
                            class="{{ $btnBase }} {{ $btnIdle }} gap-1.5 px-3 sm:px-4"
                            aria-label="Previous page"
                            @if (! $isAdmin) data-pagination-link @endif
                        >
                            <x-pagination.chevron direction="prev" />
                            <span class="hidden sm:inline">Prev</span>
                        </a>
                    @endif

                    <div class="kamali-pagination__pages hidden sm:flex" role="list">
                        @foreach ($elements as $element)
                            @if (is_string($element))
                                <span class="px-1 text-sm text-dark/40" aria-hidden="true">{{ $element }}</span>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $current)
                                        <span
                                            class="{{ $btnBase }} {{ $btnActive }} min-w-[2.5rem] px-3"
                                            aria-current="page"
                                            role="listitem"
                                        >
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a
                                            href="{{ $url }}"
                                            class="{{ $btnBase }} {{ $btnIdle }} min-w-[2.5rem] px-3"
                                            aria-label="Go to page {{ $page }}"
                                            role="listitem"
                                            @if (! $isAdmin) data-pagination-link @endif
                                        >
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </div>

                    <div class="kamali-pagination__mobile-indicator sm:hidden" aria-live="polite">
                        Page <span class="font-medium text-dark">{{ $current }}</span>
                        <span class="text-dark/40">/</span>
                        {{ $last }}
                    </div>

                    @if ($paginator->hasMorePages())
                        <a
                            href="{{ $paginator->nextPageUrl() }}"
                            rel="next"
                            class="{{ $btnBase }} {{ $btnIdle }} gap-1.5 px-3 sm:px-4"
                            aria-label="Next page"
                            @if (! $isAdmin) data-pagination-link @endif
                        >
                            <span class="hidden sm:inline">Next</span>
                            <x-pagination.chevron direction="next" />
                        </a>
                    @else
                        <span class="{{ $btnBase }} {{ $btnDisabled }} gap-1.5 px-3 sm:px-4" aria-disabled="true">
                            <span class="hidden sm:inline">Next</span>
                            <x-pagination.chevron direction="next" />
                        </span>
                    @endif

                    @if ($current >= $last)
                        <span class="{{ $btnBase }} {{ $btnDisabled }} px-3" aria-disabled="true">
                            <span class="sr-only">Last page</span>
                            <x-pagination.chevron direction="last" />
                        </span>
                    @else
                        <a
                            href="{{ $paginator->url($last) }}"
                            class="{{ $btnBase }} {{ $btnIdle }} px-3"
                            aria-label="Last page"
                            @if (! $isAdmin) data-pagination-link @endif
                        >
                            <x-pagination.chevron direction="last" />
                        </a>
                    @endif
                </nav>
            @endif
        </div>
    </div>
@endif
