<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobAttributes extends Model
{
    use HasFactory;
    protected $primaryKey = ['code', 'jobID'];
    public $incrementing= false;


    public function job(){
        return $this->belongsTo(job::class,'code', 'jobId');

    }

    public function skill()
    {
        return $this->hasOne(Skill::class, 'code', 'code');
    }


}
