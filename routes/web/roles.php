<?php

Route::get('/roles', 'RoleController@index')->name('roles.index');

Route::post('/roles', 'RoleController@store')->name('roles.store');

Route::delete('/roles/{role}/destroy', 'RoleController@destroy')->name('roles.destroy');

Route::get('/roles/{role}/edit', 'RoleController@edit')->name('roles.edit');

Route::put('/roles/{role}/update', 'RoleController@update')->name('roles.update');



Route::put('admin/roles/{role}/attach', 'RoleController@attach')->name('role.permission.attach');

Route::put('admin/roles/{role}/detach', 'RoleController@detach')->name('role.permission.detach');
