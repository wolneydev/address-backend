<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\LoginService;
 
class LoginController extends Controller
{
    protected $login_service;
    public function __construct(LoginService $login_service)
    {
        $this->login_service = $login_service;
    }

    public function login(Request $request)
    {
        return $this->login_service->login($request);
    }

    public function logout(Request $request)
    {
        return $this->login_service->logout($request);
    }

    public function logoutAll(Request $request)
    {
        return $this->login_service->logoutAll($request);
    }
}
