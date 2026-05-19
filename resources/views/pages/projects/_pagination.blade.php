@if ($projects->total() > 0)
    <div class="pt-10 sm:pt-12" data-projects-pagination>
        {{ $projects->onEachSide(2)->links('components.pagination', \App\Support\ProjectPagination::publicLinkData()) }}
    </div>
@endif
