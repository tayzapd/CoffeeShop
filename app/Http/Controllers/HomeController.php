<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\Product;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $prodcuts = Product::with('category:id,name','user:id,name')->find([6,9,12]);
        $images = Product::whereIn("id",[2,3,4,5,7,8,10,11])->get(['id','name','image']);
        $categories = Category::with('user:id,name')->get();
        return response()->json(["products"=>$prodcuts,"categories"=>$categories,"images"=>$images]);
    }

    public function order(Request $request)
    {
        $db = new Order;
        $db->user_id = Auth::id();
        $db->product_id = $request->product_id;
        if($db->save()){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }
    public function products(){
        $prodcuts = Product::with('category:id,name','user:id,name')->get();
        return $prodcuts;
    }

    public function orders(){
        $orders = User::with('orders.product','orders.product.category:id,name','orders.product.user:id,name')->withCount(['orders'])->find(Auth::id());
        return $orders->orders;
    }

    public function cancelOrder(Request $request){
        $order =  User::find(Auth::id())->orders()->find($request->product_id)->delete();
        if($order){
            return json_encode(true);
        }
    }


    public function Productreport(Request $request)
    {
        if(Auth::id() == $request->user_id){
            $db = new Report; 
            $db->user_id = Auth::id();
            $db->reportable_id = $request->item_id;
            $db->reportable_type = "App\Models\Product";
            $db->content = $request->content;
            if($db->save()){
                return json_encode(true);
            }else {
                return json_encode(false);
            }
        }else {
            return json_encode(false);
        }
    }

    public function Productfeedback(Request $request)
    {
        if(Auth::id() == $request->user_id){
            $db = new Feedback; 
            $db->user_id = Auth::id();
            $db->feedbackable_id = $request->item_id;
            $db->feedbackable_type = "App\Models\Product";
            $db->content = $request->content;
            if($db->save()){
                return json_encode(true);
            }else {
                return json_encode(false);
            }
        }else {
            return json_encode(false);
        }
    }

    public function Categoryreport(Request $request)
    {
        if(Auth::id() == $request->user_id){
            $db = new Report; 
            $db->user_id = Auth::id();
            $db->reportable_id = $request->item_id;
            $db->reportable_type = "App\Models\Category";
            $db->content = $request->content;
            if($db->save()){
                return json_encode(true);
            }else {
                return json_encode(false);
            }
        }else {
            return json_encode(false);
        }
    }

    public function Categoryfeedback(Request $request)
    {
        if(Auth::id() == $request->user_id){
            $db = new Feedback; 
            $db->user_id = Auth::id();
            $db->feedbackable_id = $request->item_id;
            $db->feedbackable_type = "App\Models\Category";
            $db->content = $request->content;
            if($db->save()){
                return json_encode(true);
            }else {
                return json_encode(false);
            }
        }else {
            return json_encode(false);
        }
    }

}
