<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::controller(AuthController::class)->group(function(){
    Route::post('/login',"login");
    Route::post('/register',"register");
});



Route::post("check-manager",[ManagerController::class,"check"]);


// Manager Controller Route Group 
Route::middleware('auth:sanctum')->controller(RoleController::class)->prefix("manager")->group(function(){
    // Roles Show Method 
    Route::post("roles","show");
    // role Create,Edit,Delete Routes 
    Route::prefix("role")->group(function(){
        Route::post("create","create");
        Route::post("edit","edit");
        Route::post("delete","delete");

        // Manager,Coustumer,Waiter Getter 
        Route::prefix('get')->group(function(){
            Route::post('all',"Users");
            Route::post('managers',"getManagers");
            Route::post('waiters',"getWaiters");
            Route::post('coustumers',"getCoustumers");
        });
        
        // Manager,Customer,Waiter Adder
        Route::prefix('add')->group(function(){
            Route::post('manager',"addManager");
            Route::post('waiter',"addWaiter");
            Route::post('customer',"addCustomer");
        });

        // Manager,Customer,Waiter Adder
        Route::prefix('delete')->group(function(){
            Route::post('manager',"delManager");
            Route::post('waiter',"delWaiter");
            Route::post('customer',"delCustomer");
        });
    });

    Route::controller(CategoryController::class)->prefix('category')->group(function(){
    
        Route::post('get','Categories');
        Route::post('edit','Edit');
        Route::post('delete','Delete');
        Route::post('create','Create');
        
    });

    Route::controller(ProductController::class)->prefix('product')->group(function(){
    
        Route::post('get','Products');
        Route::post('edit','Edit');
        Route::post('delete','Delete');
        Route::post('create','Create');
        
    });

    Route::controller(ReportController::class)->prefix('report')->group(function(){
    
        Route::post('get','Reports');
        Route::post('delete','Delete');
        Route::post('create','Create');
        
    });
});




