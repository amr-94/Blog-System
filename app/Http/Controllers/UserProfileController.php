<?php

namespace App\Http\Controllers;

use App\Models\message;
use App\Models\User;
use App\Notifications\message as NotificationsMessage;
use App\services\openwithermap;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    //
    // public function __construct()
    // {
    //     $admin = User::select('type')->get();
    //           if ($admin !== 'admin'){
    //         $this->middleware('admin')->except('show');

    //        }
    // }
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }




    public function index($id)
    {
        $owm = new openwithermap('021fe76da71f6fe433e49f5a86b621f3');
        $response =  $owm->currentweather('cairo');

        $user = User::where('name', $id)->first();
        // $user = Auth::user();

        return view('user.userprofile', [
            'user' => $user,
            'weather' => $response['weather'][0]['description'],
            'temp' => $response['main']['temp'],
            'wind' => $response['wind']['speed']
        ]);
    }



    public function edit()
    {
        $user = Auth::user();
        return view('user.useredite', compact('user'));
    }




    public function update(Request $request)
    {
        $request->validate([
            'name' => ['string', 'required'],
            'email' => ['email', 'required']
        ]);
        if ($request->hasfile('user_image')) {
            $filename = time() . '.' . $request->user_image->extension();
            $request->user_image->move(public_path('files/user'), $filename);
            $request->merge([
                'image' => $filename
            ]);
        }
        $user = User::where('id', '=', Auth::user()->id)->first();
        $user->update($request->all());
        return redirect(route('user.profile', $user->name));
    }





    public function allusers()
    {
        $allusers = User::all();
        return view('user.allusers', compact('allusers'));
    }




    public function deleteuser($id)
    {
        $user = User::find($id);
        $user->destroy($id);
        return redirect(route('all.users'));
    }

    public function sendmessage(Request $request)
    {
        $message = message::create([
            'title' => $request->title,
            'content' => $request->content,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $request->to_user_id
        ]);
        $tomessage = User::find($request->to_user_id);
        // $messagetitle = message::where('id',1);
        $tomessage->notify(new NotificationsMessage($tomessage, Auth::user()));

        return redirect(route('user.profile', $tomessage->name));
    }
    public function message()
    {
        $user = Auth::user();
        $message = $user->tomessages;
        return view('user.allmessage', [
            'message' => $message
        ]);
    }
    public function destroymessage($id)
    {
        $user = Auth::user();
        $message = $user->tomessages->find($id);
        $message->destroy($id);
        // return redirect(route('user.message'));
        return response()->json(['success' => 'message deleted .']);
    }
}