import axios from 'axios';

function slugifyTitle(title) {
    return String(title || '')
        .trim()
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

async function fileFingerprint(file) {
    const n = file.size;
    const sliceLen = Math.min(n, 512 * 1024);
    const buf = await file.slice(0, sliceLen).arrayBuffer();
    const digest = await crypto.subtle.digest('SHA-256', buf);
    const hex = [...new Uint8Array(digest)].map((b) => b.toString(16).padStart(2, '0')).join('');
    return `${n}:${hex}`;
}

export function registerAdminProjectForm(Alpine) {
    Alpine.data('adminProjectForm', (config = {}) => ({
        isEdit: Boolean(config.isEdit),
        nextSort: config.nextSort ?? null,
        currentSort: config.currentSort ?? null,

        uploading: false,
        uploadProgress: 0,
        submitError: '',

        preview: {
            title: '',
            slug: '',
            description: '',
            location: '',
            year: '',
            surface_area: '',
            category: '',
            categoryLabel: '',
            status: '',
            statusLabel: '',
            featured: false,
            architect_name: '',
            client_name: '',
        },

        coverPreviewUrl: null,
        galleryPreviewUrls: [],
        clientDuplicateHint: '',

        init() {
            this.syncPreviewFromDom();
            this.syncFilePreviews();

            this.$el.addEventListener('input', () => {
                this.syncPreviewFromDom();
            });
            this.$el.addEventListener('change', (e) => {
                if (e.target?.type === 'file') {
                    this.syncFilePreviews();
                }
                this.syncPreviewFromDom();
            });
        },

        get previewSlug() {
            const manual = (this.preview.slug || '').trim();
            if (manual) return manual;
            const s = slugifyTitle(this.preview.title);
            return s || '—';
        },

        descriptionPreview() {
            const t = (this.preview.description || '').trim();
            if (!t) return '—';
            return t.length > 240 ? `${t.slice(0, 240)}…` : t;
        },

        surfaceLine() {
            if (!this.preview.surface_area) return '—';
            return `${this.preview.surface_area} m²`;
        },

        syncPreviewFromDom() {
            const el = this.$el;
            const val = (name) => el.querySelector(`[name="${name}"]`)?.value ?? '';
            this.preview.title = val('title');
            this.preview.slug = val('slug');
            this.preview.description = val('description');
            this.preview.location = val('location');
            this.preview.year = val('year');
            this.preview.surface_area = val('surface_area');
            this.preview.category = val('category');
            this.preview.status = val('status');
            this.preview.architect_name = val('architect_name');
            this.preview.client_name = val('client_name');

            const cat = el.querySelector('[name="category"]');
            this.preview.categoryLabel = cat?.selectedOptions?.[0]?.text?.trim() || this.preview.category || '—';

            const st = el.querySelector('[name="status"]');
            this.preview.statusLabel = st?.selectedOptions?.[0]?.text?.trim() || this.preview.status || '—';

            const feat = el.querySelector('[name="featured"]');
            this.preview.featured = Boolean(feat?.checked);
        },

        revokeUrls() {
            if (this.coverPreviewUrl) {
                URL.revokeObjectURL(this.coverPreviewUrl);
                this.coverPreviewUrl = null;
            }
            this.galleryPreviewUrls.forEach((row) => URL.revokeObjectURL(row.url));
            this.galleryPreviewUrls = [];
        },

        async syncFilePreviews() {
            this.revokeUrls();
            this.clientDuplicateHint = '';

            const coverInput = this.$el.querySelector('#cover_image');
            const galleryInput = this.$el.querySelector('#gallery');
            const coverFile = coverInput?.files?.[0];
            const galleryFiles = galleryInput?.files ? [...galleryInput.files] : [];

            const staged = [];
            if (coverFile?.type?.startsWith('image/')) {
                staged.push({ kind: 'cover', file: coverFile, fp: await fileFingerprint(coverFile) });
            }
            for (const f of galleryFiles) {
                if (!f.type.startsWith('image/')) continue;
                staged.push({ kind: 'gallery', file: f, fp: await fileFingerprint(f) });
            }

            const seen = new Map();
            for (const row of staged) {
                if (seen.has(row.fp)) {
                    const prev = seen.get(row.fp);
                    const involvesCover = prev.kind === 'cover' || row.kind === 'cover';
                    this.clientDuplicateHint = involvesCover
                        ? 'The cover image matches one of the gallery files — use distinct images.'
                        : 'Two gallery files appear identical — remove duplicates before uploading.';
                    return;
                }
                seen.set(row.fp, row);
            }

            if (coverFile?.type?.startsWith('image/')) {
                this.coverPreviewUrl = URL.createObjectURL(coverFile);
            }
            for (const f of galleryFiles) {
                if (!f.type.startsWith('image/')) continue;
                this.galleryPreviewUrls.push({
                    name: f.name,
                    url: URL.createObjectURL(f),
                });
            }
        },

        async submit() {
            this.submitError = '';
            await this.syncFilePreviews();
            if (this.clientDuplicateHint) {
                this.submitError = this.clientDuplicateHint;
                return;
            }

            this.uploading = true;
            this.uploadProgress = 0;

            const fd = new FormData(this.$el);

            try {
                const res = await axios.post(this.$el.action, fd, {
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    onUploadProgress: (e) => {
                        if (e.total) {
                            this.uploadProgress = Math.min(100, Math.round((100 * e.loaded) / e.total));
                        }
                    },
                });

                const dest = res.request?.responseURL || this.$el.action;
                window.location.assign(dest);
            } catch (err) {
                this.uploading = false;
                this.uploadProgress = 0;
                if (err.response?.status === 422) {
                    const body = err.response.data;
                    const msgs = body.errors ? Object.values(body.errors).flat() : [];
                    this.submitError = msgs.length ? msgs.join(' ') : body.message || 'Please fix the errors and try again.';
                    return;
                }
                if (err.response?.status === 419) {
                    this.submitError = 'Session expired — refresh the page and try again.';
                    return;
                }
                if (err.response?.status === 413) {
                    this.submitError =
                        'Upload too large. Use images up to 6 MB each, or save the cover first and add gallery images in a second save.';
                    return;
                }
                this.submitError = 'Could not save. Check your connection and try again.';
            }
        },
    }));
}
