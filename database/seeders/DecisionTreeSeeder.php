<?php

namespace Database\Seeders;

use App\Models\DecisionTree;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DecisionTreeSeeder extends Seeder
{
    /**
     * شجرة القرار المالي العقلاني: نسخة نشطة بتعريف json بسيط.
     */
    public function run(): void
    {
        $definition = [
            'root' => 'purpose',
            'nodes' => [
                'purpose' => [
                    'key' => 'purpose',
                    'type' => 'question',
                    'prompt_ar' => 'ما الغرض من التمويل؟',
                    'options' => [
                        ['value' => 'emergency', 'label_ar' => 'طارئ', 'next' => 'emergency_fund'],
                        ['value' => 'marriage', 'label_ar' => 'زواج', 'next' => 'affordability'],
                        ['value' => 'car', 'label_ar' => 'سيارة', 'next' => 'affordability'],
                        ['value' => 'debt_consolidation', 'label_ar' => 'تجميع ديون', 'next' => 'affordability'],
                        ['value' => 'business', 'label_ar' => 'عمل حر', 'next' => 'affordability'],
                        ['value' => 'education', 'label_ar' => 'تعليم', 'next' => 'affordability'],
                        ['value' => 'other', 'label_ar' => 'أخرى', 'next' => 'affordability'],
                    ],
                ],
                'emergency_fund' => [
                    'key' => 'emergency_fund',
                    'type' => 'question',
                    'prompt_ar' => 'هل لديك صندوق طوارئ يكفي 3 أشهر من المصروفات؟',
                    'options' => [
                        ['value' => 'yes', 'label_ar' => 'نعم', 'next' => 'outcome_avoid'],
                        ['value' => 'no', 'label_ar' => 'لا', 'next' => 'affordability'],
                    ],
                ],
                'affordability' => [
                    'key' => 'affordability',
                    'type' => 'rule',
                    'prompt_ar' => 'تقييم القدرة على السداد وفق نسبة الالتزام للدخل (DTI).',
                    'rules' => [
                        ['when' => 'dti_ratio > 45', 'then' => 'outcome_avoid'],
                        ['when' => 'disposable_income_halalas <= 0', 'then' => 'outcome_avoid'],
                        ['when' => 'default', 'then' => 'outcome_rationalize'],
                    ],
                ],
                'outcome_avoid' => [
                    'key' => 'outcome_avoid',
                    'type' => 'outcome',
                    'verdict' => 'avoid_borrowing',
                    'message_ar' => 'يُنصح بتجنّب الاقتراض والاعتماد على البدائل المتاحة.',
                ],
                'outcome_rationalize' => [
                    'key' => 'outcome_rationalize',
                    'type' => 'outcome',
                    'verdict' => 'rationalize_borrowing',
                    'message_ar' => 'إن كان الاقتراض حتمياً فقارن العروض واختر الأقل كلفةً إجمالية.',
                ],
            ],
        ];

        DecisionTree::updateOrCreate(
            ['version' => '1.0.0'],
            [
                'name' => 'شجرة القرار المالي العقلاني',
                'is_active' => true,
                'definition' => $definition,
                'published_at' => Carbon::now(),
            ]
        );
    }
}
