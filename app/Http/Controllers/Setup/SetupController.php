<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns;
use App\Http\Controllers\Concerns\ApiResponder;
use App\Models\jobCategory;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    use ApiResponder;

    public function getCategories()
    {
        try {
            $categories = jobCategory::all();
        return $this->success($categories, 'Categories retrieved successfully');
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
