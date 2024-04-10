<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobs = [
            [
                'code' => 'DEV001',
                'description' => 'Software Developer',
                'fullTitle' => 'Full Stack Software Developer',
                'shortTitle' => 'Dev',
                'budget' => 80000,
                'status' => 'Open',
                'grade' => 'Mid-Level',
                'reportsTo' => 'CTO',
                'payFrequency' => 'Bi-Weekly',
            ],
            [
                'code' => 'MKT002',
                'description' => 'Marketing Manager',
                'fullTitle' => 'Digital Marketing Manager',
                'shortTitle' => 'Marketing',
                'budget' => 60000,
                'status' => 'Open',
                'grade' => 'Senior',
                'reportsTo' => 'CEO',
                'payFrequency' => 'Monthly',
            ],
            // Add more sample data as needed
        ];

        DB::table('jobs')->insert($jobs);
    }
}
