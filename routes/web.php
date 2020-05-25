<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('{any}', 'HomeController@index')->where('any', '.*'); //Does the same thing as Route::view('home') in BlogSPA. This is just much easier than writing 3 lines. Visitn BlogSPA for more details.
