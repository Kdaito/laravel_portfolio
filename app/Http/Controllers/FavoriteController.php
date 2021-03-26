<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class FavoriteController extends Controller
{
    public function store(Request $request) {
        $postId = $request->postId;
        $userId = $request->userId;
        $post = Post::find($postId);
        
        $post->users()->attach($userId);

        $count = $post->users()->count();

        $result = true;

        return response()->json([
            'count' => $count,
            'result' => $result,
        ]);
    }

    public function destroy(Request $request) {
        $postId = $request->postId;
        $userId = $request->userId;
        $post = Post::find($postId);

        $post->users()->detach($userId);

        $count = $post->users()->count();

        $result = false;

        return response()->json([
            'count' => $count,
            'result' =>$result,
        ]);
    }

    public function hasFavorite(Request $request) {
        $post = Post::find($request->postId);
        if($post->users()->where('user_id', $request->userId)->exists()) {
            $result = true;
        } else {
            $result = false;
        }

        return response()->json(['result' => $result]);
    }

    public function show(Request $request){
        $id = $request->id;
        $userId = $request->userId;

        $users = Post::find($id)->users()->get();
        foreach($users as $user) {
            $created = explode(' ', $user->created_at);
            $user->created = $created[0];

            if($user->followedUsers()->where('following_user_id', $userId)->exists()){
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
