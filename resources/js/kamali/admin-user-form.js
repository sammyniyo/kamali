import axios from 'axios';

export function registerAdminUserForm(Alpine) {
    Alpine.data('adminUserForm', (config = {}) => ({
        isEdit: Boolean(config.isEdit),

        uploading: false,
        uploadProgress: 0,
        submitError: '',

        preview: {
            name: '',
            email: '',
            is_admin: false,
        },

        init() {
            this.syncPreview();
            this.$el.addEventListener('input', () => this.syncPreview());
            this.$el.addEventListener('change', () => this.syncPreview());
        },

        syncPreview() {
            const el = this.$el;
            this.preview.name = el.querySelector('#name')?.value?.trim() ?? '';
            this.preview.email = el.querySelector('#email')?.value?.trim() ?? '';
            const admin = el.querySelector('input[name="is_admin"]');
            this.preview.is_admin = Boolean(admin?.checked);
        },

        passwordHint() {
            const p = this.$el.querySelector('#password')?.value ?? '';
            if (!this.isEdit) {
                return p.length ? `${p.length} characters` : 'Required';
            }
            return p.length ? `New password (${p.length} characters)` : 'Leave blank to keep current password';
        },

        async submit() {
            this.submitError = '';
            this.uploading = true;
            this.uploadProgress = 0;

            try {
                const res = await axios.post(this.$el.action, new FormData(this.$el), {
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
                this.submitError = 'Could not save. Check your connection and try again.';
            }
        },
    }));
}
