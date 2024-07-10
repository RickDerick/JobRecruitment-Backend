<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Vacancy\VacancyController;

Route::group(['prefix' => 'jobvacancy'], function (){
    Route::get('/all', [VacancyController::class,'getAllJobVacancies']);
});
