<?php

namespace App\Http\Repositories;

use App\Models\RoomImage;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

class RoomImageRepository
{

    private $uploadDir;

    public function __construct()
    {
        $this->uploadDir = env('UPLOAD_DIR', base_path() . '/uploads') . '/room-photos/';

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function allImages()
    {
        return RoomImage::all();
    }

    public function allImagesForRoom(int $roomId)
    {
        return RoomImage::where('room_id', $roomId)->get();
    }

    public function image(int $roomId, string $filename)
    {
        $image = RoomImage::where('room_id', $roomId)
            ->where('filename', $filename)
            ->first();

        if ($image == null) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $image->path = $this->uploadDir . $image->filename;

        return $image;
    }

    public function addImageToRoom(int $roomId, UploadedFile $file)
    {
        $file->move($this->uploadDir, $file->getClientOriginalName());

        $roomImage = new RoomImage();
        $roomImage->room_id = $roomId;
        $roomImage->filename = $file->getClientOriginalName();
        $roomImage->save();
    }

    public function deleteImageFromRoom(int $roomId, string $filename)
    {
        $image = $this->image($roomId, $filename);

        RoomImage::where('room_id', $roomId)->where('filename', $filename)->delete();

        unlink($image->path);
    }

}
