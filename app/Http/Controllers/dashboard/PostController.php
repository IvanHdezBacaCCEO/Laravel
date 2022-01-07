<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Post;
use App\Models\Category;
use App\Models\PostImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostPost;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('rol.admin');
        $this->middleware(['auth','rol.admin']);
        //$this->middleware('auth')->only('index');
        //$this->middleware('auth')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        //dd($posts);
        return view('dashboard.post.index',['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('id', 'title');
        return view("dashboard.post.create",['post'=> new Post, 'categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostPost $request)
    {
        // $request->validate([
        //     'title'=>'required|min:5|max:500',
        //     //'url_clean'=>'required|min:5|max:500',
        //     'content'=>'required|min:5'
        // ]);
        //echo "Hola mundo: ".$request->input('category_id','1');
        //dd($request->all());
        //dd($request);
        echo "Hola mundo: ".$request->content."<br>";
        //echo "Hola mundo: ".request("title");
        Post::create($request->validated());
        return back()->with('status', 'Post creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //$post = Post::findOrFail($id);
        //dd($post);
        // if(isset($post)){
        //     return view('dashboard.post.show', ["post"=>$post]);
        // }
        return view('dashboard.post.show', ["post"=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::pluck('id', 'title');
        //dd($categories);
        // dd($post->image->image); //Obtencion de nombre de imagen a partir del post
        return view('dashboard.post.edit', ["post" => $post, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostPost $request, Post $post)
    {
        echo "Hola mundo";
        $post->update($request->validated());
        return back()->with('status', 'Post actualizado con exito');

    }

    public function image(Request $request, Post $post)
    {
        $request->validate(['image'=>'required|mimes:jpeg,bmp,png|max:10240']);//10Mb
        $filename = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'),$filename);
        echo "Hola mundo ".$filename;
        PostImage::create(['image'=>$filename,'post_id'=>$post->id]);

        return back()->with('status','Imagen cargada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //echo "Eliminar el elemento ".$post->id;
        $post->delete();
        return back()->with('status', 'Post eliminado con exito');
    }
}
