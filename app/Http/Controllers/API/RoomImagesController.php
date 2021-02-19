<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RoomImageRepository;
use App\Http\Repositories\RoomsRepository;
use Illuminate\Http\Response;

class RoomImagesController extends Controller
{

    private $roomRepository;
    private $roomImageRepository;

    public function __construct(RoomsRepository $roomRepository,
                                RoomImageRepository $roomImageRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->roomImageRepository = $roomImageRepository;
    }

    public function getImagesForRoom($id)
    {
        if (!$this->roomRepository->room($id)) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->roomImageRepository->allImagesForRoom($id));
    }

    public function postImageToRoom($id)
    {
        if (!request()->hasFile('file')) {
            abort(Response::HTTP_BAD_REQUEST, 'There is no file in the request.');
        }

        $this->roomImageRepository->addImageToRoom($id, request()->file('file'));

        return response()->make(null, Response::HTTP_CREATED);
    }

    public function deleteImageFromRoom($id, $filename)
    {
        $this->roomImageRepository->deleteImageFromRoom($id, $filename);

        return response()->noContent();
    }

    public function getImage($id, $filename)
    {
        return response()->file($this->roomImageRepository->image($id, $filename)->path);
    }
}
