<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class AnswersController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->merge([
            'user_id' => Auth::user()->id
        ]);
        $comment = comment::create($request->all());
        // -------------------- notify--------------------
        $post = Post::find($request->post_id);
        $post->user->notify(new CommentNotification($post, Auth::user()));

        return redirect(route('posts.show', $post->id));
    }
    public function destroy($id)
    {
        $comment = comment::findorfail($id);
        $comment->destroy($id);
        return redirect(route('posts.show', $comment->post->id));
    }
}
