<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class ManagerController extends Controller
{
    public function check(Request $request)
    {
        # code...
        $check = User::where("id",$request->user_id)->with('roles:id,name')->first();
        $manager = NULL;
        foreach($check->roles as $item){
            if($item->name == "Manager"){
                $manager = true;
            }else {
                
            }
        }
        if($manager == true){
            return json_encode(true);
        }else {
            return json_encode(false);

        }
    }
}
