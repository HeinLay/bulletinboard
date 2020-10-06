<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
  public function createPosts(Request $request)
  {
      $post = new Post();
      $post->title=$request->title;
  		$post->description=$request->description;
  		$post->status=$request->status;
      $post->create_user_id=$request->create_user_id;
      $post->updated_user_id=$request->create_user_id;

      if($post->save()){
        return ['status'=> "post has been created."];
      }
  }
}
