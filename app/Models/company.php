<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;

    public function jobGrades()
    {
        return $this->hasMany(JobGrade::class, 'company_id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'company_id');
    }

    public function jobQualifications()
    {
        return $this->hasMany(JobQualification::class, 'company_id');
    }

    public function jobResponsibilities()
    {
        return $this->hasMany(JobResponsibility::class, 'company_id');
    }

    public function jobAttributes()
    {
        return $this->hasMany(JobAttributes::class, 'company_id');
    }

    public function jobCategories()
    {
        return $this->hasMany(JobCategory::class, 'company_id');
    }

    public function specializations()
    {
        return $this->hasMany(specialization::class, 'company_id');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, 'company_id');
    }

    public function academicCodes()
    {
        return $this->hasMany(AcademicCode::class, 'company_id');
    }

    public function professionalCodes()
    {
        return $this->hasMany(ProfessionalCode::class, 'company_id');
    }

    public function qualificationGrades()
    {
        return $this->hasMany(QualificationGrades::class, 'company_id');
    }

    public function attachmentDocTypes()
    {
        return $this->hasMany(AttachmentDocType::class, 'company_id');
    }

    public function associatedGrades()
    {
        return $this->hasMany(AssociatedGrade::class, 'company_id');
    }

    public function employeeContracts()
    {
        return $this->hasMany(EmployeeContract::class, 'company_id');
    }

}
