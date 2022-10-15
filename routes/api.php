<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrderController;
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


// check manager ? 
Route::post("check-manager",[ManagerController::class,"check"])->middleware('auth:sanctum');

//  home 
Route::post("/home-data",[HomeController::class,"index"]);
Route::controller(HomeController::class)->middleware('auth:sanctum')->group(function(){
    
    // orders 
    Route::post("/order","order");
    Route::post("/orders","orders");
    Route::post("/orders/cancel","cancelOrder");

    // category 
    Route::prefix('category')->group(function(){
        Route::post("/report","categoryReport");
        Route::post("/feedback","categoryFeedback");
    });

    // product 
    Route::post("/products","products");
    Route::prefix('product')->group(function(){
        Route::post("report","productReport");
        Route::post("feedback","productFeedback");
    });
});


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
    // category controller
    Route::controller(CategoryController::class)->prefix('category')->group(function(){
    
        Route::post('get','Categories');
        Route::post('edit','Edit');
        Route::post('delete','Delete');
        Route::post('create','Create');
        
    });
    // Product Controller
    Route::controller(ProductController::class)->prefix('product')->group(function(){
    
        Route::post('get','Products');
        Route::post('edit','Edit');
        Route::post('delete','Delete');
        Route::post('create','Create');
        
    });
    // Reports Controller
    Route::controller(ReportController::class)->prefix('report')->group(function(){
    
        Route::post('get','Reports');
        Route::post('remove','Remove');
        Route::post('/product/create','productCreate');
        Route::post('/category/create','categoryCreate');
        Route::post('/user/create','userCreate');
        
    });
    // Feedback Controller
    Route::controller(FeedBackController::class)->prefix('feedback')->group(function(){
        Route::post('get','Feedbacks');
        Route::post('remove','Remove');
    });

    // Order Controller 
    Route::controller(OrderController::class)->prefix('order')->group(function(){
    
        Route::post('get','Orders');
        Route::post('edit','Edit');
        Route::post('delete','Delete');
        Route::post('create','Create');
        
    });
});




