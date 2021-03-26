<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class FollowController extends Controller
{
    //
    public function follow(Request $request)
    {
        $followedUserId = $request->followedUserId;
        $followingUserId = $request->followingUserId;

        $followedUser = User::find($followedUserId);
        $followedUser->followedUsers()->attach($followingUserId);

        return 'success';
    }

    public function unfollow(Request $request)
    {
        $followedUserId = $request->followedUserId;
        $followingUserId = $request->followingUserId;

        $followedUser = User::find($followedUserId);
        $followedUser->followedUsers()->detach($followingUserId);

        return 'success';
    }
}
