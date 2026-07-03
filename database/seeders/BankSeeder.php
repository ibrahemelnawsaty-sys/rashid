<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * بنوك سعودية مرخّصة تمثيلية.
     */
    public function run(): void
    {
        $banks = [
            ['slug' => 'alrajhi',   'name_ar' => 'مصرف الراجحي',        'name_en' => 'Al Rajhi Bank',        'type' => 'islamic',   'sort_order' => 1],
            ['slug' => 'snb',       'name_ar' => 'البنك الأهلي السعودي', 'name_en' => 'Saudi National Bank',  'type' => 'commercial', 'sort_order' => 2],
            ['slug' => 'riyad',     'name_ar' => 'بنك الرياض',          'name_en' => 'Riyad Bank',           'type' => 'commercial', 'sort_order' => 3],
            ['slug' => 'alinma',    'name_ar' => 'مصرف الإنماء',        'name_en' => 'Alinma Bank',          'type' => 'islamic',   'sort_order' => 4],
            ['slug' => 'anb',       'name_ar' => 'البنك العربي الوطني',  'name_en' => 'Arab National Bank',   'type' => 'commercial', 'sort_order' => 5],
            ['slug' => 'albilad',   'name_ar' => 'بنك البلاد',          'name_en' => 'Bank Albilad',         'type' => 'islamic',   'sort_order' => 6],
            ['slug' => 'stc_bank',  'name_ar' => 'إس تي سي بنك',        'name_en' => 'STC Bank',             'type' => 'digital',   'sort_order' => 7],
            ['slug' => 'd360',      'name_ar' => 'دي 360 بنك',          'name_en' => 'D360 Bank',            'type' => 'digital',   'sort_order' => 8],
        ];

        foreach ($banks as $bank) {
            Bank::updateOrCreate(
                ['slug' => $bank['slug']],
                array_merge($bank, ['is_active' => true])
            );
        }
    }
}
