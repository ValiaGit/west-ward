<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


use Illuminate\Support\Facades\Mail;


Route::get('/',function() {
    return view('welcome');
});



Route::get('/testMail',function() {
        $sent = Mail::to('shako.kakauridze@gmail.com')->send(new \App\Mail\Welcome());
        var_export($sent);
});




Route::get('/503',function() {
    return view('errors/503');
});




