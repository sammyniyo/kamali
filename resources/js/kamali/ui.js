const prefersReducedMotion = () =>
    window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches ?? false;

function clamp(n, min, max) {
    return Math.min(max, Math.max(min, n));
}

function qsAll(sel, root = document) {
    return Array.from(root.querySelectorAll(sel));
}

function bootFadeInUp() {
    if (prefersReducedMotion()) {
        qsAll('[data-animate="fade-up"]').forEach((el) => el.classList.add('is-in'));
        return;
    }

    const els = qsAll('[data-animate="fade-up"]');
    if (!els.length) return;

    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (!e.isIntersecting) return;
                e.target.classList.add('is-in');
                io.unobserve(e.target);
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -10% 0px' }
    );

    els.forEach((el) => {
        el.classList.add('fade-up');
        io.observe(el);
    });
}

function bootParallaxHero() {
    const hero = document.querySelector('[data-parallax="hero"]');
    if (!hero || prefersReducedMotion()) return;

    const onScroll = () => {
        const rect = hero.getBoundingClientRect();
        const progress = clamp((0 - rect.top) / Math.max(1, rect.height), 0, 1);
        hero.style.setProperty('--parallax-y', `${progress * 24}px`);
    };

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

function bootNavbarScroll() {
    const nav = document.querySelector('[data-nav="main"]');
    if (!nav) return;

    const onScroll = () => {
        const scrolled = window.scrollY > 24;
        nav.classList.toggle('is-scrolled', scrolled);
    };

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

function bootScrollProgressAndTop() {
    const bar = document.querySelector('[data-scroll="progress"]');
    const btn = document.querySelector('[data-scroll="to-top"]');
    if (!bar && !btn) return;

    const onScroll = () => {
        const doc = document.documentElement;
        const max = Math.max(1, doc.scrollHeight - doc.clientHeight);
        const p = clamp(window.scrollY / max, 0, 1);
        if (bar) bar.style.width = `${p * 100}%`;
        if (btn) btn.classList.toggle('hidden', window.scrollY < 600);
    };

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    if (btn) {
        btn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: prefersReducedMotion() ? 'auto' : 'smooth' });
        });
    }
}

function bootPageTransitions() {
    const overlay = document.querySelector('[data-transition="overlay"]');
    if (!overlay) return;

    const hide = () => overlay.classList.remove('is-on');

    hide();
    // bfcache / back-forward: ensure we never leave a dim layer stuck on screen
    window.addEventListener('pageshow', hide);
    window.addEventListener('pagehide', hide);

    // Intentionally do NOT show the full-screen overlay on internal link clicks.
    // It stayed active until the *next* document loaded, so a slow server/TTFB
    // felt like the site was "hanging" behind a dark sheet. The slim top progress
    // bar (`data-scroll="progress"`) is enough navigation feedback.
}

/**
 * Hover-prefetch internal links so the next page is in the HTTP cache
 * before the user clicks. Big perceived-speed win.
 */
function bootHoverPrefetch() {
    if (!('IntersectionObserver' in window) || !('fetch' in window)) return;
    if (prefersReducedMotion()) {
        // Still useful for non-animated users, but limit aggressiveness
    }

    const prefetched = new Set();
    const head = document.head;

    const slow = (() => {
        const c = navigator.connection;
        if (!c) return false;
        if (c.saveData) return true;
        return /(^|-)2g$/.test(String(c.effectiveType || ''));
    })();
    if (slow) return;

    const isInternalNav = (a) => {
        const href = a.getAttribute('href');
        if (!href) return false;
        if (href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')) return false;
        if (a.target === '_blank' || a.hasAttribute('download')) return false;
        if (a.getAttribute('rel')?.includes('external')) return false;
        try {
            const url = new URL(href, window.location.origin);
            if (url.origin !== window.location.origin) return false;
            if (url.pathname.startsWith('/admin')) return false;
            if (url.pathname.startsWith('/storage') || url.pathname.startsWith('/build')) return false;
            if (url.pathname === window.location.pathname && url.search === window.location.search) return false;
            return url;
        } catch {
            return false;
        }
    };

    const prefetch = (url) => {
        const key = url.pathname + url.search;
        if (prefetched.has(key)) return;
        prefetched.add(key);

        const link = document.createElement('link');
        link.rel = 'prefetch';
        link.href = url.href;
        link.as = 'document';
        head.appendChild(link);
    };

    let hoverTimer = null;
    document.addEventListener(
        'mouseover',
        (e) => {
            const a = e.target?.closest?.('a');
            if (!a) return;
            const url = isInternalNav(a);
            if (!url) return;
            clearTimeout(hoverTimer);
            hoverTimer = setTimeout(() => prefetch(url), 65);
        },
        { passive: true }
    );

    document.addEventListener(
        'mouseout',
        (e) => {
            if (e.target?.closest?.('a')) clearTimeout(hoverTimer);
        },
        { passive: true }
    );

    document.addEventListener(
        'touchstart',
        (e) => {
            const a = e.target?.closest?.('a');
            if (!a) return;
            const url = isInternalNav(a);
            if (url) prefetch(url);
        },
        { passive: true }
    );
}

function bootPasswordReveal() {
    const fields = qsAll('[data-password-field]');
    if (!fields.length) return;

    fields.forEach((wrap) => {
        const input = wrap.querySelector('input');
        const btn = wrap.querySelector('[data-password-toggle]');
        if (!input || !btn) return;

        const openIcon = btn.querySelector('[data-eye="open"]');
        const closedIcon = btn.querySelector('[data-eye="closed"]');

        const setState = (isVisible) => {
            input.type = isVisible ? 'text' : 'password';
            btn.setAttribute('aria-label', isVisible ? 'Hide password' : 'Show password');
            if (openIcon && closedIcon) {
                openIcon.classList.toggle('hidden', isVisible);
                closedIcon.classList.toggle('hidden', !isVisible);
            }
        };

        setState(false);
        btn.addEventListener('click', () => setState(input.type === 'password'));
    });
}

function bootProjectsRealtimeSearch() {
    const root = document.querySelector('[data-projects-search]');
    if (!root) return;

    const endpoint = root.getAttribute('data-endpoint');
    const q = root.querySelector('input[name="q"]');
    const statusInput = root.querySelector('input[name="status"]');
    const categoryInput = root.querySelector('input[name="category"]');
    const grid = root.querySelector('[data-projects-grid]');
    const pagination = root.querySelector('[data-projects-pagination]');
    const count = document.querySelector('[data-projects-count]');

    if (!endpoint || !q || !statusInput || !categoryInput || !grid || !pagination) return;

    let t = null;
    let controller = null;

    const params = (overrides = {}) => {
        const p = new URLSearchParams();
        p.set('q', q.value || '');
        p.set('status', statusInput.value || 'all');
        p.set('category', categoryInput.value || 'all');
        Object.entries(overrides).forEach(([k, v]) => p.set(k, String(v)));
        return p;
    };

    const replaceUrl = (p) => {
        const url = `${window.location.pathname}?${p.toString()}`;
        window.history.replaceState({}, '', url);
    };

    const scrollToGrid = () => {
        const target = grid;
        if (!target) return;
        const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        target.scrollIntoView({ behavior: reduced ? 'auto' : 'smooth', block: 'start' });
    };

    const fetchAndRender = async (overrides = {}, { scroll = false } = {}) => {
        const p = params(overrides);
        replaceUrl(p);

        if (controller) controller.abort();
        controller = new AbortController();

        root.classList.add('opacity-80');
        try {
            const res = await fetch(`${endpoint}?${p.toString()}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: controller.signal,
            });
            if (!res.ok) return;
            const data = await res.json();
            if (typeof data?.grid_html === 'string') grid.innerHTML = data.grid_html;
            if (typeof data?.pagination_html === 'string') pagination.innerHTML = data.pagination_html;
            if (count && typeof data?.total === 'number') count.textContent = String(data.total);
            if (scroll) scrollToGrid();
        } catch (err) {
            // Ignore aborted requests during fast typing
        } finally {
            root.classList.remove('opacity-80');
        }
    };

    const debounceFetch = () => {
        if (t) window.clearTimeout(t);
        t = window.setTimeout(() => fetchAndRender({ page: 1 }), 220);
    };

    q.addEventListener('input', debounceFetch);

    root.addEventListener('click', (e) => {
        const btn = e.target?.closest?.('button[name="status"],button[name="category"]');
        if (btn) {
            e.preventDefault();
            const name = btn.getAttribute('name');
            const value = btn.getAttribute('value') ?? '';
            if (name === 'status') statusInput.value = value;
            if (name === 'category') categoryInput.value = value;
            fetchAndRender({ page: 1 });
            return;
        }

        const a = e.target?.closest?.('a[data-pagination-link]');
        if (!a || !pagination.contains(a)) return;
        const href = a.getAttribute('href');
        if (!href) return;
        e.preventDefault();
        const url = new URL(href, window.location.origin);
        const page = url.searchParams.get('page') ?? '1';
        fetchAndRender({ page }, { scroll: true });
    });
}

function bootStatCounters() {
    const strip = document.querySelector('[data-stats-strip]');
    if (!strip) return;

    const nodes = qsAll('[data-stat-value]', strip);
    if (!nodes.length) return;

    const animate = (el) => {
        const target = Number.parseInt(el.getAttribute('data-stat-value') ?? '0', 10);
        const suffix = el.getAttribute('data-stat-suffix') ?? '';
        const display = el.querySelector('[data-stat-display]');
        if (!display || Number.isNaN(target)) return;

        if (prefersReducedMotion() || target <= 0) {
            display.textContent = `${target}${suffix}`;
            return;
        }

        const duration = 900;
        const start = performance.now();

        const tick = (now) => {
            const t = clamp((now - start) / duration, 0, 1);
            const eased = 1 - (1 - t) ** 3;
            const current = Math.round(target * eased);
            display.textContent = `${current}${suffix}`;
            if (t < 1) requestAnimationFrame(tick);
            else display.textContent = `${target}${suffix}`;
        };

        display.textContent = `0${suffix}`;
        requestAnimationFrame(tick);
    };

    if (prefersReducedMotion()) {
        nodes.forEach(animate);
        return;
    }

    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (!e.isIntersecting) return;
                animate(e.target);
                io.unobserve(e.target);
            });
        },
        { threshold: 0.35 }
    );

    nodes.forEach((el) => io.observe(el));
}

export function bootKamaliUI() {
    bootFadeInUp();
    bootParallaxHero();
    bootNavbarScroll();
    bootScrollProgressAndTop();
    bootPageTransitions();
    bootHoverPrefetch();
    bootPasswordReveal();
    bootProjectsRealtimeSearch();
    bootStatCounters();
}

