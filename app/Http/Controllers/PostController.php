<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\SUpport\Facades\Session; //treba importat za Session (in flash session)
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\User;

class PostController extends Controller
{
    //
    public function index() {

        // $posts = Post::all();
        // $posts = DB::table('posts')->paginate(1); NEVEM ZAKAJ NE DELA

        $posts = Post::paginate(10);

        //$posts = auth()->user()->posts;  //lekcija 205
        // $posts = auth()->user()->posts()->paginate(2); //lekcija 208 pagination

        return view('admin.posts.index', ['posts'=>$posts]);
    }


    public function show(Post $post) {

        //Post::findOrFail($id);      poglej 193 pri 2:36

        return view('blog-post', ['post'=>$post]);
    }

    public function create() {
        $this->authorize('create', Post::class);

        return view('admin.posts.create');
    }

    public function store() {

        auth()->user();     // je isto kot Auth::user(); lekcija 194
        // dd(request()->all());

        $this->authorize('create', Post::class);

        $inputs = request()->validate([
            'title'=>'required|min:8|max:255',
            'post_image'=> 'file',
            'body'=>'required'
        ]);

        if(request('post_image')) {
            $inputs['post_image'] = request('post_image')->store('images');
        }

        auth()->user()->posts()->create($inputs);

        // return back();
        return redirect()->route('post.index');
        Session::flash('post-created-message', 'Post with title "' . $input['title'] . '" was created');
        // session()->flash('post-created-message', 'Post was created')

    }

    public function edit(Post $post) {
        // $posts = Post::findOrFail($post); ni potrebe ker laravel z $post v oklepajih naredi

        // if(auth()->user()->can('view', $post)) {    }
        $this->authorize('view', $post);  //  rajši v webu z middlewareom LEKCIJA 206

        return view('admin.posts.edit', ['post'=>$post]);
    }

    public function update(Post $post) {
        $inputs = request()->validate([
            'title'=>'required|min:8|max:255',
            'post_image'=> 'file',
            'body'=>'required'
        ]);

        if(request('post_image')) {
            $inputs['post_image'] = request('post_image')->store('images');
            $post->post_image = $inputs['post_image'];
        }

        $post->title = $inputs['title'];
        $post->body = $inputs['body'];


        $this->authorize('update', $post); //lekcija 206

        // auth()->user()->posts()->save($post);
        $post->save(); // user se ne updatea
        // $post->update([
        //     $post->title = $inputs['title'];
        //     $post->body = $inputs['body'];
        // ]);



        session()->flash('post-updated-message', 'Post was updated');
        return redirect()->route('post.index');
    }


    public function destroy(Post $post, Request $request) {

        // if(auth()->user()->id !== $post->user->id) { blabla} boljše uporabit middleware LEKCIJA 205   oz. to tik spodaj
        $this->authorize('delete', $post);
        $post->delete();

        Session::flash('message', 'Post was deleted');
        // $request->session()->flash('message', 'Post was deleted')  ali pa tako sem dodal $request zgoraj

        return back();

    }
}
