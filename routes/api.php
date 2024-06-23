<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'v1'], function (){
    Route::prefix('auth')->group(base_path('routes/modules/auth.php'));
    Route::prefix('user')->group(base_path('routes/modules/user.php'));
    Route::prefix('application')->group(base_path('routes/modules/application.php'));
    Route::prefix('attachment')->group(base_path('routes/modules/attachment.php'));
    Route::prefix('candidate')->group(base_path('routes/modules/candidate.php'));
    Route::prefix('vacancy')->group(base_path('routes/modules/vacancy.php'));
    Route::prefix('company')->group(base_path('routes/modules/company.php'));
    Route::prefix('setups')->group(base_path('routes/modules/setups.php'));


});

