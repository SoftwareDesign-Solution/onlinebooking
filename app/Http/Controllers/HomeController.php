<?php

namespace App\Http\Controllers;

use App\Http\Repositories\RoomsRepository;

class HomeController extends Controller
{
    private $roomsRepository;

    public function __construct(RoomsRepository $roomsRepository)
    {
        $this->roomsRepository = $roomsRepository;
    }

    public function index()
    {
        return view('home');
    }
}
