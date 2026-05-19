@php
    /** @var \App\Models\Blog|null $blog */
    $blog = $blog ?? null;
    $isEdit = (bool) $blog;
    $publishedValue = old('published_at', $blog?->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '');
    $bodyValue = old('body', $blog?->body ?? '');
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.1.15/dist/trix.min.css" crossorigin="anonymous" />
    <style>
        trix-toolbar {
            border: 1px solid rgba(26, 26, 24, 0.1);
            border-bottom: 0;
            border-radius: 1rem 1rem 0 0;
            background: rgba(255, 255, 255, 0.95);
        }
        trix-editor {
            border: 1px solid rgba(26, 26, 24, 0.1);
            border-radius: 0 0 1rem 1rem;
            min-height: 22rem;
            padding: 1rem 1.1rem;
            background: #faf7f1;
        }
        trix-editor:focus {
            outline: 2px solid rgba(201, 168, 76, 0.35);
            outline-offset: 0;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/trix@2.1.15/dist/trix.umd.min.js" crossorigin="anonymous"></script>
@endpush

<div class="grid gap-6 lg:grid-cols-12">
    <div class="lg:col-span-8">
        <div class="rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="grid gap-5">
                <div>
                    <label class="label text-dark/50" for="title">Title</label>
                    <input id="title" name="title" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('title', $blog?->title) }}" required />
                </div>
                <div>
                    <label class="label text-dark/50" for="slug">Slug</label>
                    <input id="slug" name="slug" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('slug', $blog?->slug) }}" />
                </div>
                <div>
                    <label class="label text-dark/50" for="excerpt">Excerpt</label>
                    <textarea id="excerpt" name="excerpt" rows="3" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3">{{ old('excerpt', $blog?->excerpt) }}</textarea>
                </div>
                <div>
                    <label class="label text-dark/50" for="body">Body</label>
                    <p class="mt-1 text-xs text-dark/50">Use the editor for headings, lists, links, and emphasis. Content is sanitized when saved.</p>
                    <input id="blog_body_hidden" type="hidden" name="body" value="{{ $bodyValue }}" />
                    <trix-editor
                        class="mt-2 block w-full overflow-hidden rounded-2xl"
                        input="blog_body_hidden"
                        placeholder="Write the article…"
                    ></trix-editor>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-4">
        <div class="rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="font-display text-2xl">Cover image</div>
            <div class="mt-5 grid gap-5">
                @if ($isEdit && $blog->cover_image)
                    <div class="overflow-hidden rounded-xl border border-dark/10 bg-dark/5">
                        <img
                            src="{{ \App\Support\KamaliMedia::blogCover($blog->cover_image) }}"
                            alt=""
                            class="aspect-[16/10] w-full object-cover"
                        />
                    </div>
                @endif
                <div>
                    <label class="label text-dark/50" for="cover_image">{{ $isEdit ? 'Replace cover' : 'Cover image' }}</label>
                    <input id="cover_image" name="cover_image" type="file" accept="image/*" class="mt-2 w-full text-sm text-dark/80 file:mr-4 file:rounded-xl file:border-0 file:bg-dark file:px-4 file:py-2 file:text-sm file:text-cream" />
                    <p class="mt-2 text-xs leading-relaxed text-dark/55">Shown on the journal index and article header. JPEG or PNG, up to 6&nbsp;MB.</p>
                </div>
                @if ($isEdit && $blog->cover_image)
                    <div class="flex items-center gap-2">
                        <input id="cover_remove" name="cover_remove" type="checkbox" value="1" class="h-4 w-4 rounded border-dark/20" @checked(old('cover_remove')) />
                        <label for="cover_remove" class="text-sm text-dark/75">Remove cover image</label>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6 rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="font-display text-2xl">Publishing</div>
            <div class="mt-5 grid gap-5">
                <div>
                    <label class="label text-dark/50" for="published_at">Publish date &amp; time</label>
                    <input
                        id="published_at"
                        name="published_at"
                        type="datetime-local"
                        class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3"
                        value="{{ $publishedValue }}"
                    />
                    <p class="mt-2 text-xs leading-relaxed text-dark/55">Leave empty to keep as a draft. When set to a future time, the post stays hidden until then.</p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
            <button class="btn btn-gold w-full shrink-0" type="submit">{{ $isEdit ? 'Save changes' : 'Create post' }} →</button>
            <a class="btn btn-dark-outline w-full text-center" href="{{ route('admin.blogs.index') }}">Cancel</a>
        </div>
    </div>
</div>
