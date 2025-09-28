<?php

namespace App\Http\Controllers;

use Idev\EasyAdmin\app\Http\Controllers\AuthController as BaseAuthController;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseAuthController
{
    protected $title;
    protected $generalUri;

    public function __construct()
    {
        $this->title = 'Login';
        $this->generalUri = 'login';
    }

    // Override hanya method login
    protected function login()
    {
        if (Auth::user()) {
            return redirect()->route('dashboard.index');
        }
        $data['title'] = $this->title;

        return view('frontend.login', $data);
    }
}
