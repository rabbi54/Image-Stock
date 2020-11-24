<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function(){
    $post = Post::where('status', 1)
    ->orderBy('created_at', 'desc')
    ->paginate(10);
    return view('home', ['posts' => $post]);
});

Route::get('/home', function(){
    $post = Post::where('status', 1)
    ->orderBy('created_at', 'desc')
    ->paginate(10);
    return view('home', ['posts' => $post]);
})->name('home');

// Like method
Route::post('like', function(Request $request){

    $post = Post::find($_POST['post_id']);
    $post->like = $_POST['like_count'];
    $post->save();
})->middleware('auth');



// admin auth
Route::get('posts/pending', function(){
    // $currentTime = Carbon::now();
    $post = Post::where('status', 0) //pending posts
    ->orderBy('created_at', 'desc')
    ->paginate(10);

    return view('approve_reject_post', ['posts' => $post,]);

})->name('pending_posts')->middleware('admin');

Route::post('post/rejected', function(){
    // delete the post permanetly
    $post = Post::find($_POST['post_id']);
    $post->images()->delete();
    $post->delete();
})->middleware('admin');

Route::post('post/approved', function(){
    //change the state of the post
    $post = Post::find($_POST['post_id']);
    $post->status = 1;
    $post->save();
})->middleware('admin');



//  auth

Route::get('create/post', function(){

})->name('create_post');

Route::resource('posts', PostController::class)->only([
    'create', 'store'
]);

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Get my posts

Route::get('myposts', function(){
    $posts = Post::where('user_id', Auth::id())
    ->orderBy('created_at', 'desc')
    ->paginate(10);
    return view('mypost', ['posts' => $posts]);
})->name('my_posts')->middleware('auth');