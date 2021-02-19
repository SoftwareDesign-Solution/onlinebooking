<?php

namespace App\Http\Repositories;

use App\Models\General;
use App\ObjectAssign;

class GeneralRepository
{

    public function __construct()
    {
        if (General::all()->count() == 0) {
            $general = new General();
            $general->save();
        }
    }

    public function getGeneralInformation()
    {
        return General::all()->first();
    }

    public function updateGeneralInformation($partial) {
        $general = $this->getGeneralInformation();
        $general = ObjectAssign::assign($general, $partial);
        $general->save();
        return $general;
    }

}
