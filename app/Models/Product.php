<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id','name','user_id','category_id','image','price','created_at','updated_at'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function reprots()
    {
       return $this->morphOne(Report::class,'reportable');
    }

    public function feedbacks()
    {
       return $this->morphOne(Feedback::class,'feedbackable');
    }
}
