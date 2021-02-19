<div class="table-sort-arrows {{ $sortBy === $currentSortBy ? 'active' : 'inactive'  }}">
    <a href="?sortBy={{ $sortBy }}&sortDirection=asc" class="arrow arrow-up {{ $currentSortDirection === 'asc' ? 'active' : 'inactive'  }}"></a>
    <a href="?sortBy={{ $sortBy }}&sortDirection=desc" class="arrow arrow-down {{ $currentSortDirection === 'desc' ? 'active' : 'inactive'  }}"></a>
</div>
