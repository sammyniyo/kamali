/**
 * Project page gallery: stage viewer, mosaic grid, lightbox with zoom & swipe.
 */
export function registerProjectGallery(Alpine) {
    Alpine.data('projectGallery', ({ images }) => ({
        i: 0,
        open: false,
        /** 'stage' = hero + strip; 'mosaic' = editorial grid */
        view: 'stage',
        zoom: 1,
        lbTouchStart: null,
        stTouchX: null,
        images,

        init() {
            this.$watch('open', (value) => {
                document.body.style.overflow = value ? 'hidden' : '';
            });
        },

        next() {
            this.i = (this.i + 1) % this.images.length;
        },

        prev() {
            this.i = (this.i - 1 + this.images.length) % this.images.length;
        },

        openAt(index) {
            this.i = index;
            this.open = true;
            this.zoom = 1;
        },

        closeLightbox() {
            this.open = false;
            this.zoom = 1;
        },

        zoomIn() {
            this.zoom = Math.min(2.5, Math.round((this.zoom + 0.25) * 100) / 100);
        },

        zoomOut() {
            this.zoom = Math.max(1, Math.round((this.zoom - 0.25) * 100) / 100);
        },

        resetZoom() {
            this.zoom = 1;
        },

        mosaicClass(idx, len) {
            if (len <= 0) return '';
            const base =
                'group relative block overflow-hidden rounded-2xl border border-dark/10 bg-dark text-left shadow-sm outline-none transition duration-500 focus-visible:ring-2 focus-visible:ring-gold/50 focus-visible:ring-offset-2 focus-visible:ring-offset-cream motion-safe:hover:border-gold/35 motion-safe:hover:shadow-xl';
            if (len === 1) {
                return `${base} col-span-2 aspect-[16/10] sm:aspect-[21/9]`;
            }
            if (idx === 0 && len > 1) {
                return `${base} col-span-2 aspect-[16/10] sm:aspect-[21/9]`;
            }
            return `${base} col-span-1 aspect-[4/3]`;
        },

        onLbTouchStart(e) {
            this.lbTouchStart = e.changedTouches[0].clientX;
        },

        onLbTouchEnd(e) {
            if (this.lbTouchStart == null) return;
            const end = e.changedTouches[0].clientX;
            const d = end - this.lbTouchStart;
            if (Math.abs(d) > 55) {
                if (d < 0) this.next();
                else this.prev();
            }
            this.lbTouchStart = null;
        },

        onStageTouchStart(e) {
            this.stTouchX = e.touches[0].clientX;
        },

        onStageTouchEnd(e) {
            if (this.stTouchX == null) return;
            const end = e.changedTouches[0].clientX;
            const d = end - this.stTouchX;
            if (Math.abs(d) > 65) {
                if (d < 0) this.next();
                else this.prev();
            }
            this.stTouchX = null;
        },

        onKeydown(e) {
            if (!this.open) return;
            if (e.key === 'Escape') {
                this.closeLightbox();
                return;
            }
            if (e.key === 'ArrowRight') {
                e.preventDefault();
                this.next();
                return;
            }
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                this.prev();
                return;
            }
            if (e.key === '+' || e.key === '=') {
                e.preventDefault();
                this.zoomIn();
                return;
            }
            if (e.key === '-' || e.key === '_') {
                e.preventDefault();
                this.zoomOut();
                return;
            }
            if (e.key === '0') {
                e.preventDefault();
                this.resetZoom();
            }
        },
    }));
}
