<?php

namespace Database\Seeders;

use App\Models\Alternative;
use Illuminate\Database\Seeder;

class AlternativeSeeder extends Seeder
{
    /**
     * البدائل الخمسة الجوهرية بترتيب الأولوية (1..5) كما في المخطط المرجعي.
     */
    public function run(): void
    {
        $alternatives = [
            [
                'slug' => 'digital_savings_circles',
                'name_ar' => 'الجمعيات المالية الرقمية (الادخار التشاركي)',
                'summary_ar' => 'سيولة فورية بدون فوائد عبر دوائر ادخارية موثّقة قانونياً (سندات لأمر عبر النفاذ الوطني) برسوم إدارية رمزية تبدأ من 199 ريالاً لمرة واحدة. الأولوية الأولى لتجنّب الاقتراض الربحي.',
                'priority' => 1,
                'icon' => 'users',
            ],
            [
                'slug' => 'gov_development_finance',
                'name_ar' => 'التمويل الحكومي التنموي المدعوم (صفر فوائد)',
                'summary_ar' => 'تمويل بنك التنمية الاجتماعية SDB بصفر فوائد: نقدي/عمل حر حتى 200 ألف ريال وسداد حتى 40 شهراً، وبرامج الأسرة وكنف والزواج والترميم وتمويل المنشآت.',
                'priority' => 2,
                'icon' => 'building-library',
            ],
            [
                'slug' => 'proactive_investing',
                'name_ar' => 'التراكم الاستثماري الاستباقي (بديل الاستدانة)',
                'summary_ar' => 'بناء سيولة مستقبلية بدل الاستدانة: صكوك صح الحكومية (عائد 4.60%–5.64%)، برامج زود، والمستشارون الآليون منخفضو الرسوم.',
                'priority' => 3,
                'icon' => 'chart-bar',
            ],
            [
                'slug' => 'insurance_protection',
                'name_ar' => 'الحماية التأمينية الوقائية (درع ضد الطوارئ)',
                'summary_ar' => 'اتّقاء الحاجة للاقتراض الطارئ عبر التأمين التعاوني وبرامج الحماية والادخار من أكثر من 28 شركة، مع المقارنة لاختيار الأنسب كلفةً وتغطيةً.',
                'priority' => 4,
                'icon' => 'shield-check',
            ],
            [
                'slug' => 'community_relief',
                'name_ar' => 'التكافل المجتمعي لمعالجة التعثّر الفعلي',
                'summary_ar' => 'للحالات القائمة من التعثّر: سداد ديون الغارمين في القضايا المالية غير الجنائية عبر منصة فُرجت (مظلة وزارة الداخلية وإحسان وأبشر).',
                'priority' => 5,
                'icon' => 'hand-heart',
            ],
        ];

        foreach ($alternatives as $row) {
            Alternative::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, ['is_active' => true])
            );
        }
    }
}
