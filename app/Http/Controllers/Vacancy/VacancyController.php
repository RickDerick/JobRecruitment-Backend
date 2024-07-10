<?php

namespace App\Http\Controllers\Vacancy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\ApiResponder;
use  App\Models\job;

class VacancyController extends Controller
{
    use ApiResponder;

    public function getAllJobVacancies()
{
    try {
        $alljobVacancies = job::all();
return $this->success($alljobVacancies);
    } catch (\Exception $exception) {
        return $this->error($exception->getMessage());
    }
}
}
