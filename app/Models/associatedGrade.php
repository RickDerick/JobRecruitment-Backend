<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class associatedGrade extends Model
{
    use HasFactory;
    protected $primaryKey =['qualificationCode','qualificationGrade'];
    public $incrementing = false;


    public function qualificationGrades(){
        return $this->belongsTo(qualificationGrades::class, 'qualificationGrade','code');
    }

}
