<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Feedback;
class FeedBackController extends Controller
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
    
    public function Feedbacks(){
        return Feedback::with(['user:id,name','feedbackable.user:id,name,email'])->get();
    }

}
