<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UsersRepository;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->usersRepository = $usersRepository;
    }

    public function viewAllUsers()
    {
        $sortBy = request()->query('sortBy') ?? 'id';
        $sortDirection = request()->query('sortDirection') ?? 'asc';
        $query = request()->query('query');

        $users = $query ?
            $this->usersRepository->searchUsers($query, $sortBy, $sortDirection) :
            $this->usersRepository->allUsers($sortBy, $sortDirection);

        return view('cms.users')
            ->with('currentSortBy', $sortBy)
            ->with('currentSortDirection', $sortDirection)
            ->with('query', $query)
            ->with('users', $users);
    }

    public function activateUserAndViewAllUsers(Request $request)
    {
        $id = $request->route('id');
        $this->usersRepository->updateUser($id, [
            "active" => $request->query('active') == 'true'
        ]);

        return redirect('/cms/users');
    }

}

