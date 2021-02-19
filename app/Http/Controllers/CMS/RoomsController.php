<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RoomsRepository ;
use Illuminate\Http\Request;

class RoomsController extends Controller
{

    private $roomRepository;

    public function __construct(RoomsRepository $roomRepository)
    {
        // $this->middleware('auth');
        $this->middleware('admin');
        $this->roomRepository = $roomRepository;
    }

    public function viewAllRooms()
    {
        return view('cms.rooms')
            ->with('rooms', $this->roomRepository->allRooms());
    }

    public function viewRoom()
    {
        $id = request()->route()->parameter('id');

        return view('cms.room-details')
            ->with('room', $this->roomRepository->room($id));
    }

    public function updateAndViewRoom(Request $request)
    {
        $id = request()->route()->parameter('id');
        $room = $this->roomRepository->room($id);

        $room->name = $request->input('name');
        $room->genre = $request->input('genre');
        $room->rate = $request->input('rate');
        $room->smoking = !!$request->input('smoking');
        $room->air_conditioned = !!$request->input('air_conditioned');
        $room->active = !!$request->input('active');
        $room->equipment = $request->input('equipment');
        $room->description = $request->input('description');
        $room->save();

        return view('cms.room-details')
            ->with('room', $this->roomRepository->room($id));
    }

}

