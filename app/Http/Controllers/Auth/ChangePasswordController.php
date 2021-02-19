<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Repositories\NotificationsRepository;
use App\Http\Repositories\UsersRepository;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{

    private $usersRepository;
    private $notificationsRepository;

    public function __construct(UsersRepository $usersRepository, NotificationsRepository $notificationsRepository)
    {
        $this->middleware('auth');
        $this->usersRepository = $usersRepository;
        $this->notificationsRepository = $notificationsRepository;
    }

    function changePassword(Request $request)
    {
        $this->validator($request->all())->validate();

        $this->usersRepository->updateUser(Auth::user()->id, [
            "password" => bcrypt(request()->get('password'))
        ]);

        $this->notificationsRepository->createNotification(Auth::user()->id, Notification::TYPE_PASSWORD_CHANGED);

        return view('auth.passwords.change')
            ->with('passwordChanged', true);
    }

    function viewChangePasswordForm()
    {
        return view('auth.passwords.change')
            ->with('passwordChanged', false);
    }

    function validator(array $data)
    {
        return Validator::make($data, [
            'old-password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail("$attribute is invalid.");
                }
            }],
            // at least 9 characters, one digit and one non-alphanumeric character except whitespace
            'password' => ['required', 'string', 'min:9', 'regex:/\d/', 'regex:/[^a-zA-Z\d\s:]/', 'confirmed'],
        ]);

    }

}
