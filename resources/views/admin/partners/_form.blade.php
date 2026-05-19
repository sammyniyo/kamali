@php
    /** @var \App\Models\Partner|null $partner */
    $partner = $partner ?? null;
    $isEdit = (bool) $partner;
    $previewPartner = $partner ?? new \App\Models\Partner([
        'name' => 'Publication name',
        'note' => 'Editorial feature',
        'url' => null,
        'logo' => null,
        'is_visible' => true,
    ]);
@endphp

<div class="grid gap-6 lg:grid-cols-12">
    <div class="lg:col-span-7">
        <div class="rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="font-display text-2xl text-dark">Details</div>
            <div class="mt-5 grid gap-5">
                <div>
                    <label class="label text-dark/50" for="name">Name</label>
                    <input
                        id="name"
                        name="name"
                        class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3"
                        value="{{ old('name', $partner?->name) }}"
                        required
                    />
                </div>
                <div>
                    <label class="label text-dark/50" for="note">Category</label>
                    <input
                        id="note"
                        name="note"
                        class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3"
                        value="{{ old('note', $partner?->note) }}"
                        placeholder="e.g. General contractor"
                    />
                    <p class="mt-2 text-xs leading-relaxed text-dark/55">
                        Small label under the logo on the homepage (e.g. Pharmacy, Energy). Optional.
                    </p>
                </div>
                <div>
                    <label class="label text-dark/50" for="url">Website URL</label>
                    <input
                        id="url"
                        name="url"
                        type="url"
                        class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3"
                        value="{{ old('url', $partner?->url) }}"
                        placeholder="https://…"
                    />
                </div>
            </div>
        </div>

        <div class="mt-6 rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="font-display text-2xl text-dark">Logo</div>
            <div class="mt-5 grid gap-5 sm:grid-cols-2 sm:items-start">
                <div>
                    <label class="label text-dark/50" for="logo">{{ $isEdit ? 'Replace logo' : 'Logo' }}</label>
                    <input
                        id="logo"
                        name="logo"
                        type="file"
                        accept="image/*"
                        class="mt-2 block w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-dark file:px-4 file:py-2 file:text-sm file:text-cream"
                    />
                    <p class="mt-2 text-xs text-dark/55">Optional PNG or SVG on white. Max 4&nbsp;MB.</p>
                    @if ($isEdit && $partner->logo)
                        <label class="mt-4 inline-flex items-center gap-2 text-sm text-dark/70">
                            <input type="checkbox" name="logo_remove" value="1" class="h-4 w-4 rounded border-dark/20" />
                            Remove logo
                        </label>
                    @endif
                </div>
                @if ($isEdit && $partner->logo)
                    <div class="flex min-h-[5.5rem] items-center justify-center rounded-xl border border-dark/10 bg-cream/80 p-4">
                        <img
                            src="{{ \App\Support\KamaliMedia::partnerLogo($partner->logo) }}"
                            alt=""
                            class="max-h-12 max-w-full object-contain"
                        />
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-5">
        <div class="rounded-2xl border border-gold/25 bg-gradient-to-br from-gold/8 via-white/80 to-cream/90 p-7 shadow-[0_4px_32px_rgba(201,168,76,0.08)] backdrop-blur">
            <p class="label text-dark/50">Live preview</p>
            <p class="mt-1 text-sm text-dark/60">Homepage logo grid</p>
            <div class="mt-5 rounded-xl border border-dark/10 bg-white p-6">
                <ul class="partners-trust__grid !grid-cols-1 !gap-y-0 mx-auto max-w-[12rem]" role="list">
                    <x-partner-logo-cell :partner="$previewPartner" />
                </ul>
            </div>
            <p class="mt-4 text-xs leading-relaxed text-dark/50">
                Logos show in grayscale on the site; color on hover. Logo file updates after save on edit.
            </p>
        </div>

        <div class="mt-6 rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="font-display text-2xl text-dark">Visibility</div>
            <label class="mt-5 flex items-center gap-3 text-sm text-dark/80">
                <input
                    type="checkbox"
                    name="is_visible"
                    value="1"
                    class="h-4 w-4 rounded border-dark/20 text-gold focus:ring-gold/30"
                    @checked(old('is_visible', $partner?->is_visible ?? true))
                />
                Show on public site
            </label>
            @if ($isEdit)
                <p class="mt-4 text-xs text-dark/55">
                    List order: <strong class="text-dark/80">#{{ $partner->sort_order }}</strong>
                </p>
            @else
                <p class="mt-4 text-xs text-dark/55">
                    New partners are appended as order <strong class="text-dark/80">#{{ $nextSortOrder ?? 1 }}</strong>.
                </p>
            @endif
        </div>

        <div class="mt-6 flex flex-col gap-3">
            <button class="btn btn-gold w-full" type="submit">{{ $isEdit ? 'Save changes' : 'Create partner' }} →</button>
            <a class="btn btn-dark-outline w-full text-center" href="{{ route('admin.partners.index') }}">Cancel</a>
        </div>
    </div>
</div>
