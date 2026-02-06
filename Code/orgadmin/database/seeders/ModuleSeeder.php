<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [
                'name' => 'Payroll System',
                'slug' => 'payroll',
                'description' => 'Complete payroll management with tax calculation and payslips.',
                'version' => '1.0.0',
                'is_active' => true,
            ],
            [
                'name' => 'CRM (Customer Relations)',
                'slug' => 'crm',
                'description' => 'Manage leads, customers, and sales pipelines.',
                'version' => '1.2.1',
                'is_active' => true,
            ],
            [
                'name' => 'Inventory Management',
                'slug' => 'inventory',
                'description' => 'Track stock levels, orders, and suppliers.',
                'version' => '2.0.0',
                'is_active' => true,
            ],
        ];

        foreach ($modules as $module) {
            \App\Models\Module::firstOrCreate(
                ['slug' => $module['slug']],
                $module
            );
        }
    }
}
