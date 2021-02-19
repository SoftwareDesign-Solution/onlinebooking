<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableSortArrows extends Component {

    public $sortBy;
    public $currentSortBy;
    public $currentSortDirection;

    public function __construct($sortBy)
    {
        $this->sortBy = $sortBy;

        $this->currentSortBy = request()->query('sortBy') ?? '';
        $this->currentSortDirection = request()->query('sortDirection') ?? '';
    }

    public function render()
    {
        return view('components.table-sort-arrows');
    }

}
