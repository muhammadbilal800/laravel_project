<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SignupController;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/', 'welcome', [
    "names" => [
        "Ahmer", 
        "Bilal", 
        "Ali"
    ],
    "students" => [
        "s1" => "Ahmer", 
        "s2" => "Bilal", 
        "s3" => "Ali"
    ]
])->middleware(['auth', 'verified']);

// Route::get('/data', function(){
//     return ["Ahmer", "Bilal", "Ali"];
// });


Route::middleware(['guest'])->group(function(){
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    
    Route::get('/signup',[SignupController::class,'index'])->name('signup');
    Route::post('/signup/create',[SignupController::class,'store'])->middleware('throttle:2,60');
}); 


Route::get('/blogs/{name}/{age?}', [BlogController::class, 'index'])->name('blogs')->middleware(['auth'])->where(['name' => '[a-z]+', 'age' => '[0-9]+']);

Route::post('/logout', [LogoutController::class, 'destory']);

Route::get('/myerror', function(){
    abort(500);
});

Route::get('/date', function(){
    // return Carbon::now() Date Now;
    // return Carbon::now()->setTimezone('Asia/Karachi')->format('D, d-m-y H:i:s A') Date now with Timezone and Format;
    // return Carbon::now()->addDays(1);
    return (Carbon::now()->addDays(1) > Carbon::now());
});

Route::middleware(['auth'])->group(function(){
    Route::get('/create-post', [PostController::class, 'index'])->name('create.post');
    Route::post('/create-post', [PostController::class, 'store']);
});


Route::middleware(['auth', 'verified', 'is_admin'])->prefix('admin')->group(function(){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');
});
// route model binding
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('post.read');
Route::delete('/post/{post:slug}/delete', [PostController::class, 'destroy'])->name('post.delete');
// update post
Route::get('/post/update/{post:slug}', [PostController::class, 'update'])->name('post.update')->middleware('auth');
Route::patch('/post/update/{post:slug}/now', [PostController::class, 'update_post'])->name('post.update.now')->middleware('auth');


Route::get('/forgot-password',[ForgotController::class,'index'])->middleware('guest')->name('password.request');

 Route::post('/forgot-password',[ForgotController::class,'store'])->middleware('guest')->name('password.email');

 
 Route::get('/reset-password',[ResetController::class,'index'])->name('reset.password');
 Route::get('/reset-password/{token}',[ResetController::class,'store'])->middleware('guest')->name('password.reset');
 Route::post('/reset-password',[ResetController::class,'token'])->middleware('guest')->name('password.update');