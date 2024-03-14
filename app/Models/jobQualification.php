<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobQualification extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = ['jobsNo', 'lineNo'];
    public $incrementing= false;

    public function job()
    {
        return $this->belongsTo(Job::class, 'jobsNo', 'code');
    }

    public function qualificationGrades()
    {
        return $this->belongsTo(QualificationGrades::class, 'minQualification', 'code');
    }

    public function academicCode()
    {
        return $this->belongsTo(AcademicCode::class, 'qualificationCode', 'code');
    }
}
