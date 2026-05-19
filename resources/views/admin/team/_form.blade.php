@php
    /** @var \App\Models\TeamMember|null $member */
    $member = $member ?? null;
    $isEdit = (bool) $member;
@endphp

<div class="grid gap-6 lg:grid-cols-12">
    <div class="lg:col-span-8">
        <div class="rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="grid gap-5">
                <div>
                    <label class="label text-dark/50" for="name">Name</label>
                    <input id="name" name="name" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('name', $member?->name) }}" required />
                </div>
                <div>
                    <label class="label text-dark/50" for="role">Role</label>
                    <input id="role" name="role" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('role', $member?->role) }}" />
                </div>
                <div>
                    <label class="label text-dark/50" for="bio">Bio</label>
                    <textarea id="bio" name="bio" rows="6" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3">{{ old('bio', $member?->bio) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-4">
        <div class="rounded-2xl border border-dark/10 bg-white/70 backdrop-blur p-7">
            <div class="font-display text-2xl">Meta</div>
            <div class="mt-5 grid gap-5">
                <div>
                    <label class="label text-dark/50" for="linkedin_url">LinkedIn URL</label>
                    <input id="linkedin_url" name="linkedin_url" class="mt-2 w-full rounded-2xl border border-dark/10 bg-cream px-4 py-3" value="{{ old('linkedin_url', $member?->linkedin_url) }}" />
                </div>
                @if ($isEdit)
                    <p class="text-xs leading-relaxed text-dark/55">
                        List order: <strong class="text-dark/80">#{{ $member->sort_order }}</strong> (set when this profile was created).
                    </p>
                @else
                    <p class="text-xs leading-relaxed text-dark/55">
                        New members are appended automatically as order <strong class="text-dark/80">#{{ $nextSortOrder ?? 1 }}</strong> in the admin list.
                    </p>
                @endif
                <div>
                    <label class="label text-dark/50" for="photo">Photo</label>
                    <input id="photo" name="photo" type="file" accept="image/*" class="mt-2 block w-full text-sm" />
                    <p class="mt-2 text-xs text-dark/55">Optional — without a photo, the site shows a neutral avatar.</p>
                    @if ($isEdit)
                        <div class="mt-4 flex items-center gap-4">
                            <img
                                class="h-20 w-20 rounded-2xl border border-dark/10 object-cover"
                                src="{{ \App\Support\KamaliMedia::teamPhoto($member->photo) }}"
                                alt=""
                            />
                            @if ($member->photo)
                                <label class="inline-flex items-center gap-2 text-sm text-dark/70">
                                    <input type="checkbox" name="photo_remove" value="1" class="h-4 w-4 rounded border-dark/20" />
                                    Remove photo
                                </label>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button class="btn btn-gold w-full" type="submit">{{ $isEdit ? 'Save changes' : 'Create member' }} →</button>
            <a class="btn btn-dark-outline w-full" href="{{ route('admin.team.index') }}">Cancel</a>
        </div>
    </div>
</div>

