<?php

namespace Database\Seeders;

use App\Models\AccountBalance;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Consent;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\FinancialGoal;
use App\Models\FinancialProfile;
use App\Models\Income;
use App\Models\NotificationPreference;
use App\Models\Obligation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * مستخدم فرد تجريبي «محمد» بملف مالي واقعي مطابق للشاشات.
     * كل المبالغ بالهللات (الريال × 100).
     */
    public function run(): void
    {
        $now = Carbon::now();

        // ----- المستخدم -----
        $user = User::updateOrCreate(
            ['phone' => '+966501234567'],
            [
                'name' => 'محمد',
                'email' => 'mohammed@example.com',
                'password' => Hash::make('password'),
                'role' => 'individual',
                'residency_type' => 'citizen',
                'status' => 'active',
                'locale' => 'ar',
                'phone_verified_at' => $now,
            ]
        );

        // ----- الملف المالي (مشتق ومخزّن) -----
        FinancialProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'monthly_income_halalas' => 900000,     // 9,000 ريال
                'monthly_expenses_halalas' => 555000,   // 5,550 ريال
                'total_obligations_halalas' => 3000000, // 30,000 ريال متبقٍ
                'dti_ratio' => 32.00,
                'disposable_income_halalas' => 345000,  // 3,450 ريال
                'emergency_fund_halalas' => 800000,     // 8,000 ريال
                'risk_band' => 'low',
                'computed_at' => $now,
            ]
        );

        // ----- الدخل -----
        Income::updateOrCreate(
            ['user_id' => $user->id, 'source' => 'salary'],
            [
                'amount_halalas' => 900000, // راتب 9,000 ريال
                'frequency' => 'monthly',
                'is_verified' => true,
            ]
        );

        // ----- المصروفات (تجموع 5,550 ريال) -----
        $categories = ExpenseCategory::pluck('id', 'key');

        $expenses = [
            ['key' => 'housing',   'amount_halalas' => 300000, 'is_essential' => true],  // 3,000 ريال
            ['key' => 'food',      'amount_halalas' => 150000, 'is_essential' => true],  // 1,500 ريال
            ['key' => 'transport', 'amount_halalas' => 70000,  'is_essential' => true],  //   700 ريال
            ['key' => 'health',    'amount_halalas' => 35000,  'is_essential' => false], //   350 ريال
        ];

        foreach ($expenses as $expense) {
            Expense::updateOrCreate(
                ['user_id' => $user->id, 'category_id' => $categories[$expense['key']] ?? null],
                [
                    'amount_halalas' => $expense['amount_halalas'],
                    'frequency' => 'monthly',
                    'is_essential' => $expense['is_essential'],
                    'source' => 'manual',
                ]
            );
        }

        // ----- الالتزامات (التزام واحد) -----
        Obligation::updateOrCreate(
            ['user_id' => $user->id, 'creditor_name' => 'مصرف الراجحي'],
            [
                'creditor_type' => 'bank',
                'principal_halalas' => 5000000,          // 50,000 ريال
                'remaining_halalas' => 3000000,          // 30,000 ريال
                'monthly_installment_halalas' => 288000, // 2,880 ريال (يعكس DTI 32%)
                'apr' => 0.000,
                'months_remaining' => 11,
            ]
        );

        // ----- الأهداف المالية -----
        FinancialGoal::updateOrCreate(
            ['user_id' => $user->id, 'title' => 'سيارة'],
            [
                'target_amount_halalas' => 3000000, // 30,000 ريال
                'saved_amount_halalas' => 1800000,  // 18,000 ريال
                'priority' => 1,
                'status' => 'active',
            ]
        );

        FinancialGoal::updateOrCreate(
            ['user_id' => $user->id, 'title' => 'صندوق الطوارئ'],
            [
                'target_amount_halalas' => 2000000, // 20,000 ريال
                'saved_amount_halalas' => 800000,   //  8,000 ريال
                'priority' => 2,
                'status' => 'active',
            ]
        );

        // ----- الحسابات البنكية (إدخال يدوي) وأرصدتها -----
        $alrajhi = Bank::where('slug', 'alrajhi')->first();
        $snb = Bank::where('slug', 'snb')->first();

        $rajhiAccount = BankAccount::updateOrCreate(
            ['user_id' => $user->id, 'iban_masked' => '····45'],
            [
                'bank_id' => $alrajhi?->id,
                'account_type' => 'current',
                'currency' => 'SAR',
                'is_manual' => true,
            ]
        );

        AccountBalance::updateOrCreate(
            ['bank_account_id' => $rajhiAccount->id],
            [
                'balance_halalas' => 420000, // 4,200 ريال
                'available_halalas' => 420000,
                'captured_at' => $now,
            ]
        );

        $snbAccount = BankAccount::updateOrCreate(
            ['user_id' => $user->id, 'iban_masked' => '····89'],
            [
                'bank_id' => $snb?->id,
                'account_type' => 'current',
                'currency' => 'SAR',
                'is_manual' => true,
            ]
        );

        AccountBalance::updateOrCreate(
            ['bank_account_id' => $snbAccount->id],
            [
                'balance_halalas' => 780000, // 7,800 ريال
                'available_halalas' => 780000,
                'captured_at' => $now,
            ]
        );

        // ----- تفضيلات الإشعارات الافتراضية -----
        NotificationPreference::updateOrCreate(
            ['user_id' => $user->id],
            [
                'channels' => ['sms' => true, 'push' => true, 'email' => false, 'inapp' => true],
                'topics' => ['apr_alerts' => true, 'savings_reminders' => true, 'borrow_intercept' => true],
                'quiet_hours' => ['start' => '23:00', 'end' => '07:00'],
            ]
        );

        // ----- الموافقات (PDPL) -----
        Consent::updateOrCreate(
            ['user_id' => $user->id, 'type' => 'pdpl_processing'],
            [
                'scope' => ['purpose' => 'financial_analysis'],
                'status' => 'granted',
                'granted_at' => $now,
                'ip_at_grant' => '127.0.0.1',
            ]
        );
    }
}
