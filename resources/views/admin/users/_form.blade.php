@php
    /** @var \App\Models\User|null $user */
    $user = $user ?? null;
    $isEdit = (bool) $user;
@endphp

<div x-show="submitError" x-cloak class="mb-6 rounded-2xl border border-red-500/35 bg-red-500/10 px-5 py-4 text-sm text-dark" role="alert">
    <span x-text="submitError"></span>
</div>

<div class="grid gap-6 lg:grid-cols-12">
    <div class="lg:col-span-6">
        <div class="rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="font-display text-xl text-dark sm:text-2xl">Account</div>
            <div class="mt-5 grid gap-5">
                <div>
                    <label class="label text-dark/50" for="name">Name</label>
                    <input
                        id="name"
                        name="name"
                        value="{{ old('name', $user?->name) }}"
                        class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3 outline-none focus:border-gold/60 focus:ring-2 focus:ring-gold/25"
                        required
                        autocomplete="name"
                    />
                </div>
                <div>
                    <label class="label text-dark/50" for="email">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $user?->email) }}"
                        class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3 outline-none focus:border-gold/60 focus:ring-2 focus:ring-gold/25"
                        required
                        autocomplete="email"
                    />
                </div>
                <div>
                    <label class="label text-dark/50" for="password">{{ $isEdit ? 'New password (optional)' : 'Password' }}</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3 outline-none focus:border-gold/60 focus:ring-2 focus:ring-gold/25"
                        {{ $isEdit ? '' : 'required' }}
                        autocomplete="new-password"
                    />
                    <p class="mt-2 text-xs text-dark/55" x-text="passwordHint()"></p>
                </div>
                <div>
                    <label class="label text-dark/50" for="password_confirmation">Confirm password</label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3 outline-none focus:border-gold/60 focus:ring-2 focus:ring-gold/25"
                        {{ $isEdit ? '' : 'required' }}
                        autocomplete="new-password"
                    />
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-3">
        <div class="rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="font-display text-xl text-dark sm:text-2xl">Permissions</div>
            <div class="mt-5">
                <label class="inline-flex items-center gap-3 text-sm text-dark/80">
                    <input
                        type="checkbox"
                        name="is_admin"
                        value="1"
                        class="h-4 w-4 rounded border-dark/20"
                        @checked(old('is_admin', $user?->is_admin ?? false))
                        @disabled($isEdit && auth()->id() === $user->id)
                    />
                    Admin access
                </label>
                <div class="mt-3 text-sm text-dark/60">
                    Admins can manage projects, services, team, messages, and users.
                </div>
                @if ($isEdit && auth()->id() === $user->id)
                    <p class="mt-4 rounded-xl border border-gold/30 bg-gold/10 px-4 py-3 text-xs leading-relaxed text-dark/80">
                        You cannot remove your own admin access while signed in as this user.
                    </p>
                @endif
            </div>
        </div>

        <div x-show="uploading" x-cloak class="mt-6 rounded-2xl border border-gold/35 bg-gold/10 px-5 py-4">
            <div class="flex items-center justify-between gap-3 text-sm font-medium text-dark">
                <span>Saving…</span>
                <span x-text="uploadProgress + '%'"></span>
            </div>
            <div class="mt-2 h-2 overflow-hidden rounded-full bg-dark/10">
                <div class="h-full rounded-full bg-gold transition-[width] duration-150" :style="'width:' + uploadProgress + '%'"></div>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
            <button class="btn btn-gold w-full shrink-0 justify-center sm:flex-1" type="submit" :disabled="uploading" :class="uploading && 'opacity-70 pointer-events-none'">
                <span x-show="!uploading">{{ $isEdit ? 'Save changes' : 'Create user' }} →</span>
                <span x-show="uploading" x-cloak>Please wait…</span>
            </button>
            <a class="btn btn-dark-outline w-full shrink-0 justify-center sm:flex-1" href="{{ route('admin.users.index') }}">Cancel</a>
        </div>
    </div>

    <aside class="lg:col-span-3 lg:sticky lg:top-28 lg:self-start">
        <div class="rounded-2xl border border-dark/10 bg-white/80 p-6 shadow-[0_2px_28px_rgba(26,26,24,0.06)] backdrop-blur">
            <div class="label text-dark/50">Live preview</div>
            <div class="mt-3 font-display text-xl leading-snug text-dark" x-text="preview.name || '—'"></div>
            <div class="mt-2 break-all text-sm text-dark/70" x-text="preview.email || '—'"></div>
            <div class="mt-5 border-t border-dark/10 pt-5 text-sm">
                <span class="label text-dark/45">Access</span>
                <p class="mt-2 font-medium text-dark" x-text="preview.is_admin ? 'Administrator' : 'Standard user'"></p>
            </div>
            <div class="mt-5 border-t border-dark/10 pt-5 text-xs leading-relaxed text-dark/55">
                Passwords are never shown here. Use a strong unique password; on edit, leave both password fields empty to keep the current one.
            </div>
        </div>
    </aside>
</div>
