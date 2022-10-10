<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
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

    public function Categories(Request $request )
    {
        # code...
        return Category::with('user:id,name')->get();
    }

    public function Create(Request $request)
    {
        # code...
        $request->validate([
            "name"=>"required|string|max:225|min:3",
        ]);

        if($request->user_id == Auth::user()->id){
            $category = new Category;
            $category->user_id = Auth::user()->id;
            $category->name = $request->name;
            if($category->save()){
                return json_encode(true);
            }else {
                return json_encode(false);
            }
        }else {
            return json_encode(false);
        }


    }

    public function Edit(Request $request)
    {
        $request->validate([
            "name"=>"required|string|max:225|min:3",
        ]);
        if($request->user_id == Auth::user()->id){
            $category = Category::find($request->id);
            $category->user_id = Auth::user()->id;
            $category->name = $request->name;
            if($category->update()){
                return json_encode(true);
            }else {
                return json_encode(false);
            }
        }else {
            return json_encode(false);
        }
    }

    public function Delete(Request $request)
    {
        $request->validate([
            "id"=>"required|max:225|min:1",
        ]);
        if($request->user_id == Auth::user()->id){
            $category = Category::find($request->id);
            if($category->delete()){
                return json_encode(true);
            }else {
                return json_encode(false);
            }
        }else {
            return json_encode(false);
        }
    }
    
}
