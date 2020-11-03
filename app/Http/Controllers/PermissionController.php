<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Permission;

class PermissionController extends Controller
{
    //
    public function index() {
        return view('admin.permissions.index', [
            'permissions'=>Permission::all()
        ]);
    }

    public function store() {

        request()->validate([
            'name'=>['required']
        ]);

        Permission::create([
            'name'=>Str::ucfirst(request('name')),
            'slug'=>Str::of(Str::lower(request('name')))->slug('-')
        ]);

        return back();
    }

    public function edit(Permission $permission) {
        return view('admin.permissions.edit', ['permission'=>$permission]);
    }

    public function destroy(Permission $permission) {
        $permission->delete();

        return back();
    }

    public function update(Request $request, Permission $permission) {
        $PermissionName = $permission->name;
        $permission->name = Str::ucfirst(request('name'));
        $permission->slug = Str::of(request('name'))->slug('-');

        if(!empty($request->input('name'))) {
            if($permission->isDirty('name')) {
                session()->flash('permission-updated', 'Permission ' .  $PermissionName . ' was updated to ' . request('name'));
                $permission->save();
            } else {
                session()->flash('permission-updated', 'Inputed permission\'s name is already assigned');
            }
        } else {
            session()->flash('permission-updated', 'The field cannot be empty');
        }
        return back();
    }
}
