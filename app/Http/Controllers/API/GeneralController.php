<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\GeneralRepository;

class GeneralController extends Controller
{

    private $generalRepository;

    public function __construct(GeneralRepository $generalRepository)
    {
        $this->generalRepository = $generalRepository;
    }

    public function getGeneralInformation()
    {
        return response()->json($this->generalRepository->getGeneralInformation());
    }

    public function patchGeneralInformation()
    {
        return response()->json($this->generalRepository->updateGeneralInformation(request()->json()));
    }

}
