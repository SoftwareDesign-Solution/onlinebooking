<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'password' => ['required', 'string', 'min:9', 'regex:/\d/', 'regex:/[^a-zA-Z\d\s:]/', 'confirmed']
        ];
    }

}
