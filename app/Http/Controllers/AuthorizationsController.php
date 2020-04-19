<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Redirect;
use Socialite;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthorizationsController extends Controller
{
    public function redirect($type)
    {
        return Socialite::with($type)->redirect();
    }

    public function callback($type)
    {
        try {
            $oauthUser = Socialite::with($type)->user();
        } catch (\Exception $e) {
            throw new AuthenticationException('参数错误，未获取用户信息');
        }

        $user = null;

        switch ($type) {
            case 'github':
                $openId = $oauthUser->getId();
                $user = User::where('openid', $openId)->where('type', $type)->first();
                break;

        }

        if ($user) {
            auth('web')->login($user);
        } else {
            $user = User::create([
                'name'   => $oauthUser->getNickname(),
                'avatar' => $oauthUser->getAvatar(),
                'openid' => $oauthUser->getId(),
                'type'   => $type,
            ]);
            auth('web')->login($user);
        }

        return Redirect::intended();
    }
}
