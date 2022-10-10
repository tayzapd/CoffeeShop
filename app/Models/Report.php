<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
class Report extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class,'item_id','id')->withDefault();
    }

    public function product(){
        return $this->belongsTo(Product::class,'item_id','id')->withDefault();
    }
}


// $reports = Report::with(['item','user'])->get();