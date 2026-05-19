@php
    /** @var \App\Models\Project|null $project */
    $project = $project ?? null;
    $isEdit = (bool) $project;
@endphp

<div x-show="submitError" x-cloak class="mb-6 rounded-2xl border border-red-500/35 bg-red-500/10 px-5 py-4 text-sm text-dark" role="alert">
    <span x-text="submitError"></span>
</div>

<div class="grid gap-6 lg:grid-cols-12">
    <div class="lg:col-span-6">
        <div class="rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="grid gap-5">
                <div>
                    <label class="label text-dark/50" for="title">Title</label>
                    <input id="title" name="title" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('title', $project?->title) }}" required />
                </div>

                <div>
                    <label class="label text-dark/50" for="slug">Slug</label>
                    <input id="slug" name="slug" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('slug', $project?->slug) }}" />
                    <div class="mt-2 text-xs text-dark/50">Leave blank to auto-generate from title.</div>
                </div>

                <div>
                    <label class="label text-dark/50" for="description">Description</label>
                    <textarea id="description" name="description" rows="6" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3">{{ old('description', $project?->description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-6 rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="font-display text-2xl">Images</div>
            <p class="mt-2 text-sm text-dark/60">
                Each image up to 6 MB. Upload cover and gallery in one save — if the total is very large, add gallery images in a second save.
                Duplicate files (same image as cover or twice in gallery) are blocked.
            </p>
            <div class="mt-5 grid gap-6">
                <div>
                    <label class="label text-dark/50" for="cover_image">Cover image</label>
                    <input id="cover_image" name="cover_image" type="file" accept="image/*" class="mt-2 block w-full text-sm" />
                    @if ($isEdit && $project?->cover_image)
                        <div class="mt-4 flex items-center gap-4">
                            <img class="h-20 w-28 rounded-xl border border-dark/10 object-cover" src="{{ \App\Support\KamaliMedia::projectCover($project->cover_image, (int) $project->id) }}" alt="Cover" />
                            <label class="inline-flex items-center gap-2 text-sm text-dark/70">
                                <input type="checkbox" name="cover_remove" value="1" class="h-4 w-4 rounded border-dark/20" />
                                Remove cover
                            </label>
                        </div>
                    @endif
                </div>

                <div>
                    <label class="label text-dark/50" for="gallery">Gallery images</label>
                    <input id="gallery" name="gallery[]" type="file" accept="image/*" multiple class="mt-2 block w-full text-sm" />

                    @if ($isEdit && is_array($project?->gallery) && count($project->gallery))
                        <div class="mt-5 grid grid-cols-2 gap-4 md:grid-cols-4">
                            @foreach ($project->gallery as $path)
                                <div class="rounded-2xl border border-dark/10 bg-cream p-3">
                                    <img class="h-24 w-full rounded-xl object-cover" src="{{ asset('storage/' . $path) }}" alt="Gallery" />
                                    <label class="mt-3 inline-flex items-center gap-2 text-xs text-dark/70">
                                        <input type="checkbox" name="gallery_remove[]" value="{{ $path }}" class="h-4 w-4 rounded border-dark/20" />
                                        Remove
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-3">
        <div class="rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="font-display text-2xl">Details</div>
            <div class="mt-5 grid gap-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="label text-dark/50" for="year">Year</label>
                        <input id="year" name="year" type="number" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('year', $project?->year) }}" />
                    </div>
                    <div>
                        <label class="label text-dark/50" for="surface_area">Surface (m²)</label>
                        <input id="surface_area" name="surface_area" type="number" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('surface_area', $project?->surface_area) }}" />
                    </div>
                </div>

                <div>
                    <label class="label text-dark/50" for="location">Location</label>
                    <input id="location" name="location" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('location', $project?->location) }}" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="label text-dark/50" for="category">Category</label>
                        <select id="category" name="category" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" required>
                            @foreach (['residential' => 'Residential', 'commercial' => 'Commercial', 'civic' => 'Civic'] as $k => $label)
                                <option value="{{ $k }}" @selected(old('category', $project?->category) === $k)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label text-dark/50" for="status">Status</label>
                        <select id="status" name="status" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" required>
                            <option value="finished" @selected(old('status', $project?->status) === 'finished')>Finished</option>
                            <option value="under_construction" @selected(old('status', $project?->status) === 'under_construction')>Under construction</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="inline-flex items-center gap-3 text-sm text-dark/70">
                        <input type="checkbox" name="featured" value="1" class="h-4 w-4 rounded border-dark/20" @checked(old('featured', $project?->featured)) />
                        Featured
                    </label>
                    @if ($isEdit)
                        <p class="mt-3 text-xs leading-relaxed text-dark/55">
                            List order: <strong class="text-dark/80">#{{ $project->sort_order }}</strong> (set when the project was created).
                        </p>
                    @else
                        <p class="mt-3 text-xs leading-relaxed text-dark/55">
                            List order is assigned automatically. This project will be added as
                            <strong class="text-dark/80">#{{ $nextSortOrder ?? 1 }}</strong> in the admin list.
                        </p>
                    @endif
                </div>

                <div>
                    <label class="label text-dark/50" for="architect_name">Architect</label>
                    <input id="architect_name" name="architect_name" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('architect_name', $project?->architect_name) }}" />
                </div>

                <div>
                    <label class="label text-dark/50" for="client_name">Client</label>
                    <input id="client_name" name="client_name" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('client_name', $project?->client_name) }}" />
                </div>
            </div>
        </div>

        <div x-show="uploading" x-cloak class="mt-6 rounded-2xl border border-gold/35 bg-gold/10 px-5 py-4">
            <div class="flex items-center justify-between gap-3 text-sm font-medium text-dark">
                <span>Uploading…</span>
                <span x-text="uploadProgress + '%'"></span>
            </div>
            <div class="mt-2 h-2 overflow-hidden rounded-full bg-dark/10">
                <div class="h-full rounded-full bg-gold transition-[width] duration-150" :style="'width:' + uploadProgress + '%'"></div>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
            <button class="btn btn-gold w-full shrink-0 justify-center sm:flex-1" type="submit" :disabled="uploading" :class="uploading && 'opacity-70 pointer-events-none'">
                <span x-show="!uploading">{{ $isEdit ? 'Save changes' : 'Create project' }} →</span>
                <span x-show="uploading" x-cloak>Please wait…</span>
            </button>
            <a class="btn btn-dark-outline w-full shrink-0 justify-center sm:flex-1" href="{{ route('admin.projects.index') }}">Cancel</a>
        </div>
    </div>

    <aside class="lg:col-span-3 lg:sticky lg:top-28 lg:self-start">
        <div class="rounded-2xl border border-dark/10 bg-white/80 p-6 shadow-[0_2px_28px_rgba(26,26,24,0.06)] backdrop-blur">
            <div class="label text-dark/50">Live preview</div>
            <div class="mt-3 font-display text-xl leading-snug text-dark" x-text="preview.title || 'Untitled project'"></div>
            <div class="mt-2 text-xs text-dark/50">
                Slug: <span class="font-mono text-dark/70" x-text="previewSlug"></span>
            </div>

            <div class="mt-5 space-y-2 border-t border-dark/10 pt-5 text-sm text-dark/75">
                <div class="flex flex-wrap gap-x-2 gap-y-1">
                    <span class="label text-dark/45">Category</span>
                    <span class="font-medium text-dark" x-text="preview.categoryLabel || '—'"></span>
                </div>
                <div class="flex flex-wrap gap-x-2 gap-y-1">
                    <span class="label text-dark/45">Status</span>
                    <span class="font-medium text-dark" x-text="preview.statusLabel || '—'"></span>
                </div>
                <div class="flex flex-wrap gap-x-2 gap-y-1">
                    <span class="label text-dark/45">Location</span>
                    <span class="font-medium text-dark" x-text="preview.location || '—'"></span>
                </div>
                <div class="flex flex-wrap gap-x-2 gap-y-1">
                    <span class="label text-dark/45">Year</span>
                    <span class="font-medium text-dark" x-text="preview.year || '—'"></span>
                </div>
                <div class="flex flex-wrap gap-x-2 gap-y-1">
                    <span class="label text-dark/45">Surface</span>
                    <span class="font-medium text-dark" x-text="surfaceLine()"></span>
                </div>
                <div class="flex flex-wrap gap-x-2 gap-y-1">
                    <span class="label text-dark/45">Featured</span>
                    <span class="font-medium text-dark" x-text="preview.featured ? 'Yes' : 'No'"></span>
                </div>
                <div class="flex flex-wrap gap-x-2 gap-y-1">
                    <span class="label text-dark/45">Architect</span>
                    <span class="font-medium text-dark" x-text="preview.architect_name || '—'"></span>
                </div>
                <div class="flex flex-wrap gap-x-2 gap-y-1">
                    <span class="label text-dark/45">Client</span>
                    <span class="font-medium text-dark" x-text="preview.client_name || '—'"></span>
                </div>
            </div>

            <div class="mt-5 border-t border-dark/10 pt-5">
                <div class="label text-dark/45">Description</div>
                <p class="mt-2 max-h-40 overflow-y-auto text-sm leading-relaxed text-dark/70" x-text="descriptionPreview()"></p>
            </div>

            <div class="mt-5 border-t border-dark/10 pt-5">
                <div class="label text-dark/45">Images to upload</div>
                <div class="mt-3 space-y-3">
                    <template x-if="coverPreviewUrl">
                        <div>
                            <div class="text-xs text-dark/50">Cover</div>
                            <img :src="coverPreviewUrl" class="mt-1 max-h-32 w-full rounded-xl border border-dark/10 object-cover" alt="" />
                        </div>
                    </template>
                    <div x-show="!coverPreviewUrl">
                        <div class="text-xs text-dark/50">Cover</div>
                        <img
                            src="{{ \App\Support\KamaliMedia::projectCover($project?->cover_image, (int) ($project?->id ?? 0)) }}"
                            class="mt-1 max-h-32 w-full rounded-xl border border-dark/10 object-cover opacity-90"
                            alt=""
                        />
                        <p class="mt-1 text-xs text-dark/50">Current or placeholder until you pick a new file.</p>
                    </div>
                    <template x-if="galleryPreviewUrls.length">
                        <div>
                            <div class="text-xs text-dark/50">New gallery (<span x-text="galleryPreviewUrls.length"></span>)</div>
                            <div class="mt-2 grid grid-cols-3 gap-2">
                                <template x-for="row in galleryPreviewUrls" :key="row.url">
                                    <div class="overflow-hidden rounded-lg border border-dark/10">
                                        <img :src="row.url" class="h-16 w-full object-cover" alt="" />
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </aside>
</div>
