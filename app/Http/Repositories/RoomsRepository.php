<?php

namespace App\Http\Repositories;

use App\Models\Room;
use Illuminate\Http\Response;

class RoomsRepository
{

    public function allRooms()
    {
        return Room::all();
    }

    public function room(int $id)
    {
        $room = Room::find($id);
        if ($room == null) {
            abort(Response::HTTP_NOT_FOUND);
        }
        return $room;
    }

}
