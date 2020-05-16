<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class AuthController extends BaseAuthController
{
    public function sendLoginResponse(Request $request)
    {
        auth('web')->loginUsingId(1);

        return parent::sendLoginResponse($request);
    }

    public function getLogout(Request $request){
        auth('web')->logout();
        return parent::getLogout($request);
    }
}
