<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        // return Post::join('users', 'users.id', '=' , 'posts.user_id')->get();

        // return Post::with('user')->orderBy('created_at', 'desc')->get();
        $posts =  Post::with('user')->orderBy('created_at', 'desc')->get();

        return $posts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Post::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('user')->find($id);
        $count = Post::find($id)->users()->count();
        return response()->json([
            'post' => $post,
            'count' => $count,
        ]);
    }

    public function userPosts(Request $request)
    {
        $id = $request->id;
        $userId = $request->userId;

        $posts = Post::with('user')->where('user_id', $id)->orderBy('created_at', 'desc')->get();
        foreach($posts as $post) {

            $heartCount = $post->users()->count();

            $post->heartCount = $heartCount;

            if($post->users()->where('user_id', $userId)->exists()){
                $post->hasFavorite = true;
            } else {
                $post->hasFavorite = false;
            }
        }
        return $posts;
    }

    public function likePosts(Request $request)
    {
        $id = $request->id;
        $userId = $request->userId;

        $posts = User::find($id)->favorites()->with('user')->orderBy('created_at', 'desc')->get();

        foreach($posts as $post) {

            $heartCount = $post->users()->count();

            $post->heartCount = $heartCount;

            if($post->users()->where('user_id', $userId)->exists()){
                $post->hasFavorite = true;
            } else {
                $post->hasFavorite = false;
            }
        }
        return $posts;
    }

    public function showPosts($userId) {
        $posts =  Post::with('user')->orderBy('created_at', 'desc')->get();

        foreach($posts as $post) {

            $heartCount = $post->users()->count();

            $post->heartCount = $heartCount;

            if($post->users()->where('user_id', $userId)->exists()){
                $post->hasFavorite = true;
            } else {
                $post->hasFavorite = false;
            }
        }

        return $posts;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = [
            'title' => $request->title,
            'text' => $request->text,
        ];

        Post::where('id', $id)->update($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::where('id', $id)->delete();
    }
}
