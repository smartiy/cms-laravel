<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){

    Route::put('admin/users/{user}/update', 'UserController@update')->name('user.profile.update');
    Route::delete('admin/users/{user}/delete', 'UserController@destroy')->name('user.destroy');

});


Route::middleware(['role:admin', 'auth'])->group(function() {

    Route::get('admin/users', 'UserController@index')->name('users.index');

    Route::put('admin/users/{user}/attach', 'UserController@attach')->name('user.role.attach');

    Route::put('admin/users/{user}/detach', 'UserController@detach')->name('user.role.detach');

});

Route::middleware(['auth', 'can:view,user'])->group(function() {
    Route::get('admin/users/{user}/profile', 'UserController@show')->name('user.profile.show');
});
