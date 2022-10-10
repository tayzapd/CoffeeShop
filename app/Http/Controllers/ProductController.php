<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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


    public function Products(Request $request)
    {
        return Product::with(['user:id,name','category:id,name'])->get();
    }

    public function Create(Request $request)
    {
        $request->validate([
            'category_id' => "required",
            'user_id'=> "required",
            "price"=>"required|max:5",
            'name'=>'required|string|max:225|min:3',
            'image'=> 'required|mimes:jpeg,png,jpg'
        ]);
        $imageName = uniqid().time().'.'.$request->image->extension();

        // Public Folder
        $request->image->move(public_path('images'), $imageName);

        $db = new Product;
        $db->category_id = $request->category_id;
        $db->user_id = Auth::id();
        $db->name = $request->name;
        $db->price = $request->price;
        $db->image = "images/".$imageName;
        if($db->save()){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    public function Edit(Request $request)
    {
        $request->validate([
            'category_id' => "required",
            'product_id' => "required",
            'user_id'=> "required",
            "price"=>"required|max:5",
            'name'=>'required|string|max:225|min:3',
        ]);


        $db = Product::find($request->product_id);
        if($db->user_id == Auth::id()){
            $db->category_id = $request->category_id;
            $db->name = $request->name;
            $db->price = $request->price;
            if($db->update()){
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
            'product_id' => "required",
            'user_id'=> "required",
        ]);

        $db = Product::find($request->product_id);
        if($db->user_id == Auth::id()){
            if($db->delete()){
                return json_encode(true);
            }else {
                return json_encode(false);
            }
        }else {
            return json_encode(false);
        }
    }
}
