<?php

namespace App\Http\Controllers\Auth;

use App\Models\Notification;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mockery\Matcher\Not;

class RegisterController extends Controller
{
    use RegistersUsers;
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+?\d+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // at least 9 characters, one digit and one non-alphanumeric character except whitespace
            'password' => ['required', 'string', 'min:9', 'regex:/\d/', 'regex:/[^a-zA-Z\d\s:]/', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->password = Hash::make($data['password']);
        $user->save();

        $notification = new Notification();
        $notification->user_id = $user->id;
        $notification->type = Notification::TYPE_VERIFY_EMAIL;
        $notification->save();

        return $user;
    }
}
