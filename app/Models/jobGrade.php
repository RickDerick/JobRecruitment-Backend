<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobGrade extends Model
{
    use HasFactory;
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function jobCategory()
    {
        return $this->belongsTo(jobCategory::class, 'category', 'code');
    }
}
