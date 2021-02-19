<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{

    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->middleware('auth');
        $this->usersRepository = $usersRepository;
    }

    public function getUsers(Request $request)
    {
        if ($request->query('query') && strlen($request->query('query')) > 0) {
            $sortBy = $request->query('sortBy') ?? 'id';
            $sortDirection = $request->query('sortDirection') ?? 'asc';

            return response()->json($this->usersRepository->searchUsers($request->query('query'), $sortBy, $sortDirection));
        }

        $sortBy = $request->query('sortBy') ?? 'id';
        $sortDirection = $request->query('sortDirection') ?? 'asc';

        return response()->json($this->usersRepository->allUsers($sortBy, $sortDirection));
    }

    public function getCurrentUser()
    {
        return response()->json(Auth::user());
    }

    public function patchCurrentUser()
    {
        $body = json_decode(request()->getContent());
        try {
            return $this->usersRepository->updateUser(Auth::user()->id, $body);
        } catch (ValidationException $exception) {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $exception->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function getUser($id)
    {
        return response()->json($this->usersRepository->user($id));
    }

    public function patchUser($id)
    {
        $body = json_decode(request()->getContent());

        try {
            return $this->usersRepository->updateUser($id, $body);
        } catch (ValidationException $exception) {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $exception->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function deleteCurrentUser()
    {
        $this->usersRepository->deleteUser(Auth::user()->id);
    }

}
