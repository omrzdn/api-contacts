<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(){
        $posts = PostResource::collection(Post::get());
        $msg = ["ok"];
        return response($posts,200,$msg);
    }

    public function show($id){

        $post = new PostResource(Post::find($id));
        
        return response($post);
    }

    public function store(Request $request){


        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body'  => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);
        }

        $post = Post::Create($request->all());

        if($post){

            return response($post,201);
        }

        return response(null, 404, 'the post not save',);

    }
}
