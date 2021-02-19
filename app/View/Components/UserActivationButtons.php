<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserActivationButtons extends Component {

    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function render()
    {
        return view('components.user-activation-buttons');
    }
}
