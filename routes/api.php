<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('run-command',function (){
    \Illuminate\Support\Facades\Artisan::call('fixOrderNumber');
});

Route::post('login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    return $user->createToken($request->device_name)->plainTextToken;
})->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum','namespace' => '\App\Http\Controllers'], function() {
    Route::group(['prefix' => 'school'], function() {
        Route::get('', 'SchoolController@index');
        Route::get('{id}', 'SchoolController@show');
        Route::post('', 'SchoolController@store');
        Route::put('{id}', 'SchoolController@update');
        Route::delete('{id}', 'SchoolController@destroy');
    });

    Route::group(['prefix' => 'student'], function() {
        Route::get('', 'StudentController@index');
        Route::get('{id}', 'StudentController@show');
        Route::post('', 'StudentController@store');
        Route::put('{id}', 'StudentController@update');
        Route::delete('{id}', 'StudentController@destroy');
    });
});
