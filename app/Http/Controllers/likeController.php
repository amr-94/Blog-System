<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class likeController extends Controller
{
    //
    public function makelike(Request $request, $id)
    {
        $comment = comment::find($id);
        $commentlike = like::where('comment_id', $id)->first();
        if ($commentlike == null) {
            $like = like::Create([
                'user_id' => Auth::user()->id,
                'comment_id' => $request->comment_id,
                'post_id' => $request->post_id,
                'like' => ($commentlike + 1)
            ]);
        }
        if ($commentlike !== null) {
            $commentlike->update([
                'like' => ($commentlike->like + 1),
                'user_id' => Auth::user()->id
            ]);
        }

        // return response()->json(['success' => 'like added .']);
        return redirect(route('posts.show', $comment->post->id));
    }


    public function makedislike(Request $request, $id)
    {
        $comment = comment::find($id);

        $commentlike = like::where('comment_id', $id)->first();

        if ($commentlike == null) {
            $like = like::Create([
                'user_id' => Auth::user()->id,
                'comment_id' => $request->comment_id,
                'dislike' => ($comment->dislike + 1),
                'post_id' => $request->post_id,


            ]);
        }
        if ($commentlike !== null) {
            $commentlike->update([
                'dislike' => ($commentlike->dislike + 1),
                'user_id' => Auth::user()->id
            ]);
        }

        return redirect(route('posts.show', $comment->post->id));
    }
}
