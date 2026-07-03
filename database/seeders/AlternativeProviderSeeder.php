<?php

namespace Database\Seeders;

use App\Models\Alternative;
use App\Models\AlternativeProvider;
use App\Models\GovernmentProgram;
use App\Models\InsuranceCompany;
use App\Models\InvestmentApp;
use App\Models\SavingsAssociation;
use Illuminate\Database\Seeder;

class AlternativeProviderSeeder extends Seeder
{
    /**
     * يربط كل بديل بمقدّميه (علاقة متعددة polymorphic):
     *  - circles    -> الجمعيات (Hakbah, Circlys, Money Loop)
     *  - gov         -> SDB + كنف
     *  - investing   -> صكوك صح + زود + Malaa/Abyan/Tamra
     *  - insurance   -> التعاونية/بوبا/تكافل الراجحي
     *  - relief      -> فُرجت
     */
    public function run(): void
    {
        $map = [
            'digital_savings_circles' => [
                [SavingsAssociation::class, ['hakbah', 'circlys', 'money_loop']],
            ],
            'gov_development_finance' => [
                [GovernmentProgram::class, ['sdb_cash_finance', 'kanaf']],
            ],
            'proactive_investing' => [
                [GovernmentProgram::class, ['sah_sukuk', 'zood']],
                [InvestmentApp::class, ['malaa', 'abyan', 'tamra']],
            ],
            'insurance_protection' => [
                [InsuranceCompany::class, ['tawuniya', 'bupa', 'takaful_alrajhi']],
            ],
            'community_relief' => [
                [GovernmentProgram::class, ['furijat']],
            ],
        ];

        foreach ($map as $alternativeSlug => $providerGroups) {
            $alternative = Alternative::where('slug', $alternativeSlug)->first();

            if (! $alternative) {
                continue;
            }

            $sortOrder = 0;

            foreach ($providerGroups as [$providerClass, $slugs]) {
                foreach ($slugs as $slug) {
                    $provider = $providerClass::where('slug', $slug)->first();

                    if (! $provider) {
                        continue;
                    }

                    AlternativeProvider::updateOrCreate(
                        [
                            'alternative_id' => $alternative->id,
                            'provider_type' => $provider->getMorphClass(),
                            'provider_id' => $provider->id,
                        ],
                        ['sort_order' => $sortOrder++]
                    );
                }
            }
        }
    }
}
