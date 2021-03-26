<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PostComment;

class PostCommentController extends Controller
{
    public function show(Request $request){
        // $id = $request->id;
        $id = $request->id;
        return PostComment::where('post_id', $id)->with('user')->orderBy('created_at', 'desc')->get();
        // return $request->id;
        // return Post::with('user')->orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        PostComment::create($request->all());
    }
}
