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


Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');


Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['success' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');


Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
                
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('success', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');