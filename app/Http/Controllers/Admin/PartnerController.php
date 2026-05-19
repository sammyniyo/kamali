<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $q = request('q');
        $partners = Partner::query()
            ->when($q, fn ($qq) => $qq->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                    ->orWhere('note', 'like', "%{$q}%");
            }))
            ->orderBy('sort_order')
            ->get();

        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        $nextSortOrder = (int) (Partner::query()->max('sort_order') ?? 0) + 1;

        return view('admin.partners.create', compact('nextSortOrder'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedPartner($request);

        $data['sort_order'] = (int) (Partner::query()->max('sort_order') ?? 0) + 1;
        $data['is_visible'] = (bool) $request->boolean('is_visible', true);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners/logos', 'public');
        }

        $partner = Partner::create($data);

        return redirect()->route('admin.partners.edit', $partner)->with('status', 'Partner created.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $this->validatedPartner($request);

        $data['is_visible'] = (bool) $request->boolean('is_visible');
        unset($data['sort_order']);

        if ($request->boolean('logo_remove') && $partner->logo) {
            Storage::disk('public')->delete($partner->logo);
            $data['logo'] = null;
        }

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $request->file('logo')->store('partners/logos', 'public');
        }

        $partner->update($data);

        return redirect()->route('admin.partners.edit', $partner)->with('status', 'Partner updated.');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('status', 'Partner deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedPartner(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'logo_remove' => ['nullable', 'boolean'],
        ]);

        unset($data['logo'], $data['logo_remove']);

        return $data;
    }
}
