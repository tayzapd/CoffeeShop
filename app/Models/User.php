<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Product;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function categories()
    {
        # code...
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        # code...
        return $this->hasMany(Product::class);
    }

    public function reprots()
    {
       return $this->morphOne(Report::class,'reportable');
    }

    public function feedbacks()
    {
       return $this->morphOne(Feedback::class,'feedbackable');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
