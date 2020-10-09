<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
  public function index()
  {
    return Post::all();
  }
  
  public function createPosts(Request $request)
  {
    $post = new Post();
    $post->title=$request->title;
    $post->description=$request->description;
    $post->status=$request->status;
    $post->create_user_id=$request->create_user_id;
    $post->updated_user_id=$request->updated_user_id;
    $post->save();
    return response(['post'=>$post]);
  }

  public function show($id)
  {
    $post = Post::find($id);
    return $post;
  }

  public function update(Request $request, $id)
  {
    $post = Post::find($id);
    $post->update($request->only('title','description','status','created_user_id','created_user_id'));
    return $post;
  }

  public function destroy($id)
  {
    $post = Post::find($id);
    $post->delete();
  }

  public function uploadPosts($data)
  {
    //
  }
}
