<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // البيانات المرجعية
            ExpenseCategorySeeder::class,
            BankSeeder::class,
            InstitutionSeeder::class,
            AlternativeSeeder::class,
            AlternativeProviderSeeder::class,
            DecisionTreeSeeder::class,

            // مستخدم تجريبي بملف مالي كامل
            DemoUserSeeder::class,
        ]);
    }
}
