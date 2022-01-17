<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends ApiResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //echo "Hola mundo Laravel";
        // $posts = Post::all();
        $posts = Post::
        join('post_images','post_images.post_id','=','posts.id')->
        join('categories','categories.id','=','posts.category_id')->
        select('posts.title','posts.id','categories.title as category','posts.content', 'post_images.image')->
        orderBy('posts.created_at','desc')->paginate(10);
        // return response()->json([
        //     'title'=>'Hola mundo Laravel',
        //     'content'=>'Contenido'
        // ]);
        return $this->successResponse($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->image;
        $post->images;
        $post->category;
        return $this->successResponse($post);
        //return response()->json(array('data'=>$post,'code'=>200,'msj'=>''), 200);
    }

    public function url_clean(String $url_clean)
    {
        $post = Post::where('url_clean',$url_clean)->firstOrFail();
        $post->image;
        $post->category;
        return $this->successResponse($post);
        //return response()->json(array('data'=>$post,'code'=>200,'msj'=>''), 200);
    }

    public function category(Category $category)
    {

        $posts = Post::
            join('post_images','post_images.post_id','=','posts.id')->
            join('categories','categories.id','=','posts.category_id')->
            select('posts.title','posts.id','categories.title as category','posts.content', 'post_images.image')->
            orderBy('posts.created_at','desc')->
            where('categories.id', $category->id)->paginate(10);
            return $this->successResponse(["posts"=>$posts,"category"=>$category]);
        // return $this->successResponse(["posts"=>$category->post()->paginate(10),
        //     "category"=>$category]);
        //return response()->json(array('data'=>$post,'code'=>200,'msj'=>''), 200);
    }

}
