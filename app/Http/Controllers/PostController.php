<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\comment;
use App\Models\like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }


    public function index()
    {
        //
        $search = request('search');

        $posts = Post::where('title', 'like', '%' . $search . '%')
            ->orwherehas('user', function ($q) use ($search) {
                return $q->where('name', 'like', '%' . $search . '%');
            })
            ->orwherehas('category', function ($q) use ($search) {
                return $q->where('name', 'like', '%' . $search . '%');
            })
            ->latest()->paginate(6);
        $allpost = Post::all();

        return view('posts.index', [
            'posts' => $posts,
            'allpost' => $allpost
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = category::all();
        return view('posts.create', compact('categories'));
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
        $request->validate([
            'title' => ['required', 'string']
        ]);
        if ($request->hasFile('post_img')) {
            $filename = time() . '.' . $request->post_img->extension();
            $request->post_img->move(public_path('files/posts/'), $filename);
            $request->merge([
                'post_image' => $filename
            ]);
        }

        $request->merge([
            'slug' => str::slug($request->title),
            'user_id' => Auth::user()->id,
        ]);

        $post = post::create($request->all());
        // return redirect(route('posts.index'));
        return response()->json(['success' => 'Added new records.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = post::where('id', $id)->first();
        $comment = $post->comments()->first();

        if ($comment !== null) {
            $commentlike = like::where('post_id', $post->id)->get();
            return view('posts.show', compact('post', 'comment', 'commentlike'));
        } else {
            return view('posts.show', [
                'post' => $post,
                'comment' => $comment,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = post::findorfail($id);
        $categories = category::all();
        $allpost = post::all();
        if ($post->user == Auth::user()) {
            return view('posts.edit', compact('post', 'categories', 'allpost'));
        } else {
            return redirect()->back();
        }
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
        //
        $request->validate([
            'title' => ['required', 'string'],
            // 'status' =>["unique:Post,status,$id"]
            // 'status' => ['exists:post,status']
        ]);
        // ---------------------------------------- images ----------------------------------
        if ($request->hasFile('post_img')) {
            $filename = time() . '.' . $request->post_img->extension();
            $request->post_img->move(public_path('files/posts'), $filename);
            $request->merge([
                'post_image' => $filename
            ]);
        }

        // ------------------------------- files --------------------------------------------------
        $file = [];
        if ($request->hasFile('post_files')) {
            foreach ($request->post_files as $files) {
                $filename = time() . rand(1, 100) . '.' . $files->extension();
                $files->move(public_path('files/posts/file'), $filename);
                $file[] = $filename;
            }
            $request->merge([
                'files' => $file,
            ]);
        }
        // --=-=-=======================================================
        $request->merge([
            'user_id' => Auth::user()->id,
            'slug' => str::slug($request->title)
        ]);
        $post = Post::findorfail($id);

        // ---------------------------------------- images ----------------------------------

        $prev = $post->post_image;
        if ($request->post_img) {
            File::delete(public_path('files/posts/' . $prev));
        }
        // ------------------------------- files --------------------------------------------------
        $fileprev = $post->files;
        if ($fileprev && $fileprev !== $request->post_files) {
            foreach ($fileprev as $fileprev) {
                File::delete(public_path('files/posts/file/' . $fileprev));
            }
        }

        $post->update($request->all());
        return redirect(route('posts.show', $post->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = post::findorfail($id);
        $previmg = $post->post_image;
        $prevfiles = $post->files;
        if ($prevfiles && $prevfiles !== null) {
            foreach ($prevfiles as $prevfiles) {
                File::delete(public_path('files/posts/file/' . $prevfiles));
            }
        }
        if ($previmg && $previmg !== null) {
            File::delete(public_path('files/posts/' . $previmg));
        }
        $post->destroy($id);
        return redirect(route('posts.index'));
    }
}
