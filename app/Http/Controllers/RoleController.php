<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function addRole()
    {
        $roles = [
            ['name' => 'adminstrator'],
            ['name' => 'author'],
            ['name' => 'contributor'],
            ['name' => 'subscriber'],
            ['name' => 'editor']
        ];

        Role::insert($roles);

        return 'Role has been Created Successfully!';
    }

    public function addUser()
    {
        $user = new User();
        $user->name = "zonny";
        $user->email = "zonny@gmail.com";
        $user->save();

        $roleids = [2, 3, 4];
        $user->roles()->attach($roleids);

        return 'record has been created successfully!';
    }

    public function getAllRolesByUser($id)
    {
        $user = User::find($id);
        $roles = $user->roles;
        return $roles;
    }

    public function getAllUsersByRole($id)
    {
        $role = Role::find($id);
        $users = $role->users;
        return $users;
    }
}
