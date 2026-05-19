<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\ProjectPagination;
use Illuminate\Http\Request;

class ProjectsSearchController
{
    public function __invoke(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', 'all');
        $category = (string) $request->query('category', 'all');

        $projects = Project::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('client_name', 'like', "%{$search}%");
                });
            })
            ->when(in_array($status, ['finished', 'under_construction'], true), fn ($q) => $q->where('status', $status))
            ->when($category !== 'all', fn ($q) => $q->where('category', $category))
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->paginate(ProjectPagination::publicPerPage())
            ->withQueryString();

        $filtersActive = $search !== '' || $status !== 'all' || $category !== 'all';

        return response()->json([
            'total' => $projects->total(),
            'grid_html' => view('pages.projects._grid', [
                'projects' => $projects,
                'filtersActive' => $filtersActive,
            ])->render(),
            'pagination_html' => view('pages.projects._pagination', ['projects' => $projects])->render(),
        ]);
    }
}

