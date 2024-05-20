<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobcategories =[
           [
            'code'=>'CHK1',
            'description'=>'Senior Management Team (SMT - Tier 1)'

           ] ,
           
           [
            'code'=>'CHK2',
            'description'=>'Assistant Officer (Tier 6)'

           ] 

           ];
           DB::table('job_categories')->insert($jobcategories);
    }
}
