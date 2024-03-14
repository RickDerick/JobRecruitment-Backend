<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employeeContract extends Model
{
    use HasFactory;

    protected $table = 'employee_contracts';
    protected $primaryKey = 'No';
    public $incrementing = false;

    protected $fillable = [
        'No', 'employeeNo', 'employeeName', 'reasonForDecline', 'status', 'accepted',
    ];
}
