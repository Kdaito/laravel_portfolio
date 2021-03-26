<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    //
    public function editProfile(Request $request){
        $userId = $request->user_id;

        $update = ['text' => $request->text];

        User::find($userId)->update($update);
       
    }

    public function user(Request $request) {
        $id = $request->id;
        $userId = $request->userId;

        $user =  User::find($id);

        if($user->followedUsers()->where('following_user_id', $userId)->exists()){
            $user->follow = true;
        } else {
            $user->follow = false;
        }

        $user->followingUser = $user->followingUsers()->count();
        $user->followedUser = $user->followedUsers()->count();

        return $user;
    }

    public function followingUser(Request $request) {
        $id = $request->id;
        $userId = $request->userId;

        $users = User::find($id)->followingUsers()->get();
        foreach($users as $user) {
            if($user->followedUsers()->where('following_user_id', $request->userId)->exists()){
                $user->follow = true;
            } else {
                $user->follow = false;
            }
            $user->followingUser = $user->followingUsers()->count();
            $user->followedUser = $user->followedUsers()->count();
        }
        return $users;
    }

    public function followedUser(Request $request) {
        $id = $request->id;
        $userId = $request->userId;

        $users = User::find($id)->followedUsers()->get();

        foreach($users as $user){
            if($user->followedUsers()->where('following_user_id', $request->userId)->exists()){
                $user->follow = true;
            } else {
                $user->follow = false;
            }
            $user->followingUser = $user->followingUsers()->count();
            $user->followedUser = $user->followedUsers()->count();
        }

        return $users;
    }

    public function search(Request $request){
        $keyword = $request->keyword;
        $query = User::query();

        if(!empty($keyword)) {
            $users = $query->where('name', 'LIKE', "%{$keyword}%")->get();
        }

        foreach($users as $user){
            if($user->followedUsers()->where('following_user_id', $request->userId)->exists()){
                $user->follow = true;
            } else {
                $user->follow = false;
            }
            $user->followingUser = $user->followingUsers()->count();
            $user->followedUser = $user->followedUsers()->count();
        }
        return $users;
    }
}
