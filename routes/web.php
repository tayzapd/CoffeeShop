<?php

use App\Http\Controllers\RoleController;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
Route::get('/', function () {
    return view('welcome');
});



Route::get('/{any}', function(){
    return view('welcome');
})->where('any', '.*');









