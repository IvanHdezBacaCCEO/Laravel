<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Models\PostImage;
use App\Helpers\CustomUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostPost;
use App\Http\Requests\UpdatePostPut;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $this->middleware(['auth', 'rol.admin']);
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
        // dd(storage_path('public/4iU7W5YWieCQVUyBX2gLC6xxLviVXQLFxxle9zvt.png'));
        // dd(storage_path('app'));
        // Storage::get("/public/images/1641578660.png");

        // DB::transaction(function () {
        //     DB::table('contacts')
        //         ->where(['id'=>6])
        //         ->delete();
        //     $contact = DB::select('select * from contacts where id = ?',[50]);
        //     dd($contact[0]);
        //     DB::table('contacts')
        //         ->where(['id'=>2])
        //         ->update(['name'=>'Pepito']);
        // });
        
        // DB::beginTransaction();
        // DB::table('contacts')
        // ->where(['id'=>7])
        // ->delete();
        // $contact = DB::select('select * from contacts where id = ?',[50000]);
        // // dd($contact[0]);
        // DB::rollBack();
        // // DB::commit();

        // $personas = [
        //     ['nombre'=>'usuario 1', 'edad'=>50],
        //     ['nombre'=>'usuario 2', 'edad'=>70],
        //     ['nombre'=>'usuario 3', 'edad'=>10],
        // ];
        // $collection1 = collect($personas);
        // $collection2 = new Collection($personas);
        // $collection3 = Collection::make($personas);
        // dd($collection3->sum('edad'));
        // dd($collection3->filter(function ($value, $key){
        //     return $value['edad']>17;
        // })->sum('edad'));

        // $personas = ['usuario 1','usuario 1','usuario 2','usuario 3','usuario 4'];
        // $collection = collect($personas);
        // dd((bool) $collection->intersect(['usuario 8'])->count());

        $posts = Post::with('category')->orderBy('created_at', 'desc')->paginate(10);
        //dd($posts);
        return view('dashboard.post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::pluck('id','title');
        $categories = Category::pluck('id', 'title');
        $post = new Post();
        return view("dashboard.post.create", compact('post','categories','tags'));
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
        if($request->url_clean==""){
            $urlClean_temp = $request->title;
        }else{
            $urlClean_temp = $request->url_clean;
        }
        $urlClean = CustomUrl::urlTitle(CustomUrl::convertAccentedCharacters($urlClean_temp),'-',true);
        echo "Hola mundo: " . $urlClean . "<br>";
        
        $requestData = $request->validated();
        $requestData['url_clean'] = $urlClean;

        $validator = Validator::make($requestData, StorePostPost::myRules());
        if($validator->fails()){
            return redirect('dashboard/post/create')
                ->withErrors($validator)
                ->withInput();
        }
        //dd($requestData);

        // dd(Post::create($requestData));
        $post = Post::create($requestData);
        //dd($request);
        $post->tags()->sync($request->tags_id);

        //echo "Hola mundo: ".request("title");
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
        return view('dashboard.post.show', ["post" => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // dd($post->tags);
        // $tag = Tag::find(1);
        $tags = Tag::pluck('id','title');
        // dd($tag->posts);
        $categories = Category::pluck('id', 'title');
        //dd($categories);
        // dd($post->image->image); //Obtencion de nombre de imagen a partir del post
        return view('dashboard.post.edit', compact('post','categories','tags'));
        // return view('dashboard.post.edit', [
        //     "post" => $post, 
        //     'categories' => $categories,
        //     'tags' => $tags
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostPut $request, Post $post)
    {
        // echo "Hola mundo";
        // dd($request->tags_id);
        // $post->tags()->attach(1);
        // $post->tags()->detach(1);
        $post->tags()->sync($request->tags_id);
        $post->update($request->validated());
        return back()->with('status', 'Post actualizado con exito');
    }

    public function image(Request $request, Post $post)
    {
        $request->validate(['image' => 'required|mimes:jpeg,bmp,png|max:10240']); //10Mb
        $filename = time() . '.' . $request->image->extension();
        // $request->image->move(public_path('images'), $filename);
        $path = $request->image->store('public/images');
        // dd($path);
        echo "Hola mundo " . $filename;
        PostImage::create(['image' => $path, 'post_id' => $post->id]);

        return back()->with('status', 'Imagen cargada con exito');
    }

    public function contentImage(Request $request)
    {
        $request->validate(['image' => 'required|mimes:jpeg,bmp,png|max:10240']); //10Mb
        $filename = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images_post'), $filename);
        echo "Hola mundo " . $filename;
        //dd(URL::to('/').'/images_post/'.$filename);
        return response()->json(['default'=>URL::to('/').'/images_post/'.$filename]);
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
