<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AnswersController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\likeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/',[homeController::class,'index']);



Route::group([
    // 'middleware' => ['auth']
], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::resource('posts', PostController::class);
    // ->parameters([
    //     'posts' => 'slug',
    // ]);;
    // Route::resource('posts', PostController::class,[
    //     'store' => 'postsstore'
    // ]);
    Route::resource('category', CategoryController::class);
    route::get('user/profile/{id}', [UserProfileController::class, 'index'])->name('user.profile');;
    route::get('comment/like/{id}', [likeController::class, 'makelike'])->name('comment.like');
    route::get('comment/dis/{id}', [likeController::class, 'makedislike'])->name('comment.dislike');
});


Route::group(
    [
        'middleware' => ['auth']
    ],
    function () {
        route::get('user/profile/edit/{id}', [UserProfileController::class, 'edit'])->name('user.edit');
        route::put('user/profile/update/{id}', [UserProfileController::class, 'update'])->name('user.update');
        route::get('notify', [NotificationController::class, 'index'])->name('notifay.index');
        route::get('notify/{id}', [NotificationController::class, 'read'])->name('notify.read');
        route::delete('notify/{id}', [NotificationController::class, 'destroy'])->name('notification.destroy');
        route::post('comment/', [AnswersController::class, 'store'])->name('comment.store');
        route::delete('comment/{id}', [AnswersController::class, 'destroy'])->name('comment.destroy');
        route::delete('notifications/deleteall/', [NotificationController::class, 'destroyall'])->name('notification.destroyall');
        route::post('user/sendmessage/', [UserProfileController::class, 'sendmessage'])->name('user.send');
        route::get('user/messages/', [UserProfileController::class, 'message'])->name('user.message');
        route::delete('user/messages/{id}', [UserProfileController::class, 'destroymessage'])->name('message.delete');
    }
);


Route::group(
    [
        'middleware' => ['auth', 'admin']
    ],
    function () {
        route::get('alluser/', [UserProfileController::class, 'allusers'])->name('all.users');
        route::delete('delete/user/{id}', [UserProfileController::class, 'deleteuser'])->name('deleteuser');
    }
);





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';