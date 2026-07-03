<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * تصنيفات المصروفات المرجعية (سكن، غذاء، أقساط، مواصلات، تعليم، صحة، أخرى).
     */
    public function run(): void
    {
        $categories = [
            ['key' => 'housing',        'name_ar' => 'سكن',      'icon' => 'home',        'sort_order' => 1],
            ['key' => 'food',           'name_ar' => 'غذاء',     'icon' => 'shopping-cart', 'sort_order' => 2],
            ['key' => 'installments',   'name_ar' => 'أقساط',    'icon' => 'credit-card', 'sort_order' => 3],
            ['key' => 'transport',      'name_ar' => 'مواصلات',  'icon' => 'car',         'sort_order' => 4],
            ['key' => 'education',      'name_ar' => 'تعليم',    'icon' => 'academic-cap', 'sort_order' => 5],
            ['key' => 'health',         'name_ar' => 'صحة',      'icon' => 'heart',       'sort_order' => 6],
            ['key' => 'other',          'name_ar' => 'أخرى',     'icon' => 'dots-horizontal', 'sort_order' => 7],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::updateOrCreate(
                ['key' => $category['key']],
                $category
            );
        }
    }
}
