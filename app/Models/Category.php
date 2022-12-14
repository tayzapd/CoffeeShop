<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Category extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
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
