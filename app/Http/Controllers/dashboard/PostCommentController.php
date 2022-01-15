<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostCommentController extends Controller
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
        $postComments = PostComment::orderBy('created_at', 'desc')->paginate(10);
        //dd($postComments);
        return view('dashboard.post-comment.index', ['postComments' => $postComments]);
    }

    public function post(Post $post)
    {
        $posts = Post::all();

        $postComments = PostComment::orderBy('created_at', 'desc')
            ->where('post_id','=',$post->id)
            ->paginate(10);
        //dd($postComments);
        return view('dashboard.post-comment.post', 
            ['postComments' => $postComments,
            'posts'=>$posts,
            'post'=>$post]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PostComment $postComment)
    {
        //$postComment = PostComment::findOrFail($id);
        //dd($postComment);
        // if(isset($postComment)){
        //     return view('dashboard.postComment.show', ["postComment"=>$postComment]);
        // }
        return view('dashboard.post-comment.show', ["postComment" => $postComment]);
    }

    public function process(PostComment $postComment){
        if ($postComment->approved=='0') {
            $postComment->approved='1';
        }else{
            $postComment->approved='0';
        }
        $postComment->save();
        return response()->json($postComment->approved);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostComment $postComment)
    {
        //echo "Eliminar el elemento ".$postComment->id;
        $postComment->delete();
        return back()->with('status', 'Comentario eliminado con exito');
    }
}
