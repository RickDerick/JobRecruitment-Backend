<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobResponsibility extends Model
{
    use HasFactory;
    protected $primaryKey = ['jobsNo', 'lineNo'];
    public $incrementing = false;


    public function job()
    {
        return $this->belongsTo(job::class, 'jobsNo', 'code');
    }

}
