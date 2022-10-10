<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
class RoleController extends Controller
{
    public function __construct(Request $request)
    {
        $user = User::where("id",$request->user_id)->with('roles:id,name')->first();
        $manager = NULL;
        if($user->roles) {
            foreach($user->roles as $item){
                if($item->name == "Manager"){
                    $manager = true;
                }else {
                    
                }
            }
        }
        if($manager == true){

        }else {
            return abort(404);

        }
    }

    public function show(Request $request)
    {
        # code...
        $db = Role::all();
        return $db;

    }

    public function create(Request $request)
    {
        # code...
        $db = new Role;
        $db->name = $request->name;
        if($db->save()){
            return json_encode(true);
        }else {
            return json_decode(false);
        }
    }


    public function delete(Request $request)
    {
        # code...
        $db = Role::find($request->role_id);
        if($db->delete()){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    public function edit(Request $request)
    {
        # code...
        $db  = Role::find($request->role_id);
        $db->name = $request->name;
        if($db->update()){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    public function getManagers()
    {
        $user = Role::where('id',1)->with("users:id,name")->first();
        return $user->users;
    }

    public function getWaiters()
    {
        $user = Role::where('id',2)->with("users:id,name")->first();
        return $user->users;
    }

    public function getCoustumers()
    {
        $user = Role::where('id',3)->with("users:id,name")->first();
        return $user->users;
    }

    public function addManager(Request $request)
    {
        $user = User::find($request->id);
        $role = Role::find(1);
        $add = $user->roles()->attach($role);
        return json_encode(true);
        
    }
    public function addWaiter(Request $request)
    {
        $user = User::find($request->id);
        $role = Role::find(2);
        $add = $user->roles()->attach($role);
        return json_encode(true);
        
    }

    public function addCustomer(Request $request)
    {
        $user = User::find($request->id);
        $role = Role::find(3);
        $add = $user->roles()->attach($role);
        return json_encode(true);
        
    }
    public function delManager(Request $request)
    {
        # code...
        $user = User::find($request->id)->roles()->detach(1);
        return json_encode(true);
    }

    public function delWaiter(Request $request)
    {
        # code...
        $user = User::find($request->id)->roles()->detach(2);
        return json_encode(true);
    }

    public function delCustomer(Request $request)
    {
        # code...
        $user = User::find($request->id)->roles()->detach(3);
        return json_encode(true);
    }
    public function Users(Request $request)
    {
        # code...
        return User::all('id','name');
    }
}
