<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job extends Model
{
    use HasFactory;
    private $primaryKey = 'code';
    public $incrementing = false;


    public function jobGrade(){
        return $this->belongsTo(jobGrade::class, 'grade','code');
    }

    public function jobCategory(){
        return $this->belongsTo(jobCategory::class, 'category','code');
    }

    public function jobQualification(){
        return $this->belongsTo(jobQualification::class, 'code','jobsNo');
    }

    public function jobResponsibilities(){
        return $this->belongsTo(jobResponsibility::class, 'code','jobsNo');
    }

    public function jobAttributes(){
        return $this->belongsTo(jobAttributes::class, 'code','jobID');
    }
}
