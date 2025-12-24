<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'الباطنه',
            'النسا',
            'الاطفال',
            'الانف و الاذن',
            'الاسنان',
            'الجراحه',
            'الرمد',
            'عظام',
            'علاج طبيعي',
            'معمل',
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['name' => $dept]);
        }
    }
}
