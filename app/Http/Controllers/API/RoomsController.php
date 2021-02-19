<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RoomsRepository ;

class RoomsController extends Controller
{

    private $roomRepository;

    public function __construct(RoomsRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function getRooms()
    {
        return response()->json($this->roomRepository->allRooms());
    }

    public function getRoom($id)
    {
        return response()->json($this->roomRepository->room($id));
    }
}
