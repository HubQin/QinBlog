<?php

namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller
{
    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
//        dd($user->comments[0]->commentable);
        return view('users.show', compact('user'));
    }
}
