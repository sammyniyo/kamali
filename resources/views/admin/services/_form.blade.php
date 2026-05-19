@php
    /** @var \App\Models\Service|null $service */
    $service = $service ?? null;
    $isEdit = (bool) $service;
@endphp

<div class="grid gap-6 lg:grid-cols-12">
    <div class="lg:col-span-8">
        <div class="rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="grid gap-5">
                <div>
                    <label class="label text-dark/50" for="title">Title</label>
                    <input id="title" name="title" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('title', $service?->title) }}" required />
                </div>
                <div>
                    <label class="label text-dark/50" for="slug">Slug</label>
                    <input id="slug" name="slug" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('slug', $service?->slug) }}" />
                </div>
                <div>
                    <label class="label text-dark/50" for="description">Description</label>
                    <textarea id="description" name="description" rows="6" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3">{{ old('description', $service?->description) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-4">
        <div class="rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="font-display text-2xl">Meta</div>
            <div class="mt-5 grid gap-5">
                <div>
                    <label class="label text-dark/50" for="icon_name">Icon name</label>
                    <input id="icon_name" name="icon_name" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('icon_name', $service?->icon_name) }}" />
                </div>
                @if ($isEdit)
                    <p class="text-xs leading-relaxed text-dark/55">
                        List order: <strong class="text-dark/80">#{{ $service->sort_order }}</strong> (set when this service was created).
                    </p>
                @else
                    <p class="text-xs leading-relaxed text-dark/55">
                        New services are appended automatically as order <strong class="text-dark/80">#{{ $nextSortOrder ?? 1 }}</strong> in the admin list.
                    </p>
                @endif
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button class="btn btn-gold w-full" type="submit">{{ $isEdit ? 'Save changes' : 'Create service' }} →</button>
            <a class="btn btn-dark-outline w-full" href="{{ route('admin.services.index') }}">Cancel</a>
        </div>
    </div>
</div>

