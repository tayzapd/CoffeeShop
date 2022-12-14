<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Report;
class ReportController extends Controller
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

    public function Reports()
    {
       return Report::with(['user:id,name','reportable.user:id,name'])->get();
    }

    public function Remove(Request $request)
    {
        $db = Report::find($request->report_id);
        if($db->delete()){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }
}
