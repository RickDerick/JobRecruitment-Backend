<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Setup\SetupController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });


Route::group(['prefix' => 'category'], function (){
    Route::get('/jobCategories', [SetupController::class,'getCategories']);
});
