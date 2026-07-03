<?php

namespace Database\Seeders;

use App\Models\FinanceCompany;
use App\Models\GovernmentProgram;
use App\Models\InsuranceCompany;
use App\Models\InvestmentApp;
use App\Models\SavingsAssociation;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    /**
     * قاعدة المؤسسات المالية: الجمعيات، البرامج الحكومية، تطبيقات الاستثمار،
     * شركات التأمين، وشركات التمويل. كل المبالغ بالهللات (الريال × 100).
     */
    public function run(): void
    {
        // ----- الجمعيات المالية الرقمية (savings_associations) -----
        $associations = [
            [
                'slug' => 'hakbah',
                'name_ar' => 'حكبة',
                'name_en' => 'Hakbah',
                'legal_mechanism' => 'سند لأمر عبر النفاذ الوطني',
                'admin_fee_halalas' => 19900, // 199 ريالاً لمرة واحدة
            ],
            [
                'slug' => 'circlys',
                'name_ar' => 'سيركليس',
                'name_en' => 'Circlys',
                'legal_mechanism' => 'سند لأمر عبر النفاذ الوطني',
                'admin_fee_halalas' => 0,
            ],
            [
                'slug' => 'money_loop',
                'name_ar' => 'موني لوب',
                'name_en' => 'Money Loop',
                'legal_mechanism' => 'سند لأمر عبر النفاذ الوطني',
                'admin_fee_halalas' => 0,
            ],
        ];

        foreach ($associations as $row) {
            SavingsAssociation::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, ['is_active' => true])
            );
        }

        // ----- البرامج الحكومية (government_programs) -----
        $programs = [
            [
                'slug' => 'sdb_cash_finance',
                'name_ar' => 'التمويل النقدي - بنك التنمية الاجتماعية',
                'authority' => 'بنك التنمية الاجتماعية (SDB)',
                'category' => 'dev_finance',
                'max_amount_halalas' => 20000000, // 200,000 ريال
                'max_tenor_months' => 40,
                'interest_free' => true,
                'details_ar' => 'تمويل نقدي بصفر فوائد من بنك التنمية الاجتماعية حتى 200 ألف ريال وسداد حتى 40 شهراً.',
            ],
            [
                'slug' => 'kanaf',
                'name_ar' => 'برنامج كنف',
                'authority' => 'بنك التنمية الاجتماعية (SDB)',
                'category' => 'dev_finance',
                'max_amount_halalas' => null,
                'max_tenor_months' => null,
                'interest_free' => true,
                'details_ar' => 'برنامج كنف لدعم الأسر والأيتام ضمن التمويل التنموي المدعوم.',
            ],
            [
                'slug' => 'sah_sukuk',
                'name_ar' => 'صكوك صح',
                'authority' => 'المركز الوطني لإدارة الدين',
                'category' => 'sukuk',
                'max_amount_halalas' => 20000000, // حد أعلى 200 ألف ريال
                'max_tenor_months' => 12,
                'interest_free' => false,
                'details_ar' => 'صكوك ادخارية حكومية بعائد يتراوح بين 4.60% و5.64%، حد أدنى 1000 ريال وأعلى 200 ألف ريال.',
            ],
            [
                'slug' => 'zood',
                'name_ar' => 'زود',
                'authority' => 'صندوق التنمية / مبادرات حكومية',
                'category' => 'savings',
                'max_amount_halalas' => null,
                'max_tenor_months' => null,
                'interest_free' => false,
                'details_ar' => 'برنامج ادخاري بحافز حكومي يصل حتى 20% لتشجيع بناء السيولة المستقبلية.',
            ],
            [
                'slug' => 'furijat',
                'name_ar' => 'منصة فُرجت',
                'authority' => 'وزارة الداخلية',
                'category' => 'relief',
                'max_amount_halalas' => null,
                'max_tenor_months' => null,
                'interest_free' => true,
                'details_ar' => 'منصة لسداد ديون الغارمين في القضايا المالية غير الجنائية عبر مظلة وزارة الداخلية وإحسان وأبشر.',
            ],
        ];

        foreach ($programs as $row) {
            GovernmentProgram::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, ['is_active' => true])
            );
        }

        // ----- تطبيقات الاستثمار (investment_apps) -----
        $apps = [
            [
                'slug' => 'malaa',
                'name_ar' => 'ملاءة',
                'type' => 'robo_advisor',
                'management_fee' => 0.350,
                'target_return' => 4.50,
                'min_amount_halalas' => 100000, // 1000 ريال
            ],
            [
                'slug' => 'abyan',
                'name_ar' => 'أبيان',
                'type' => 'robo_advisor',
                'management_fee' => null,
                'target_return' => 5.83,
                'min_amount_halalas' => 100000,
            ],
            [
                'slug' => 'tamra',
                'name_ar' => 'ثمرة',
                'type' => 'robo_advisor',
                'management_fee' => 0.400,
                'target_return' => null,
                'min_amount_halalas' => 100000,
            ],
        ];

        foreach ($apps as $row) {
            InvestmentApp::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, ['is_active' => true])
            );
        }

        // ----- شركات التأمين التعاوني (insurance_companies) -----
        $insurers = [
            [
                'slug' => 'tawuniya',
                'name_ar' => 'التعاونية',
                'name_en' => 'Tawuniya',
                'lines' => ['medical', 'protection_savings', 'motor'],
            ],
            [
                'slug' => 'bupa',
                'name_ar' => 'بوبا العربية',
                'name_en' => 'Bupa Arabia',
                'lines' => ['medical'],
            ],
            [
                'slug' => 'takaful_alrajhi',
                'name_ar' => 'تكافل الراجحي',
                'name_en' => 'Al Rajhi Takaful',
                'lines' => ['protection_savings', 'motor', 'medical'],
            ],
        ];

        foreach ($insurers as $row) {
            InsuranceCompany::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, ['is_active' => true])
            );
        }

        // ----- شركات التمويل (finance_companies) -----
        $financeCompanies = [
            ['slug' => 'emkan',           'name_ar' => 'إمكان',            'name_en' => 'Emkan Finance',              'category' => 'consumer', 'sama_licensed' => true],
            ['slug' => 'abdullatif_jameel', 'name_ar' => 'عبداللطيف جميل', 'name_en' => 'Abdul Latif Jameel Finance', 'category' => 'consumer', 'sama_licensed' => true],
            ['slug' => 'altaysir',        'name_ar' => 'التيسير',          'name_en' => 'Al Taysir Finance',          'category' => 'consumer', 'sama_licensed' => true],
            ['slug' => 'tamara',          'name_ar' => 'تمارا',            'name_en' => 'Tamara',                     'category' => 'bnpl',     'sama_licensed' => true],
        ];

        foreach ($financeCompanies as $row) {
            FinanceCompany::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, ['is_active' => true])
            );
        }
    }
}
