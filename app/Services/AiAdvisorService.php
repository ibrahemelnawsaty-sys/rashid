<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * المستشار الذكي: يشرح مخرجات محرك القواعد بلغة عربية بسيطة.
 * العمود الفقري حتمي (يعمل دون أي مفتاح API)؛ وعند توفّر ANTHROPIC_API_KEY
 * يرتقي إلى Claude API مع حراسة صارمة (يشرح ولا يخترع أرقاماً خارج بيانات المستخدم).
 */
class AiAdvisorService
{
    private const SYSTEM_RULES = <<<'TXT'
أنت «رشيد»، مستشار مالي عربي هادئ وموثوق. مهمتك شرح الوضع المالي للمستخدم وخياراته بلغة بسيطة ومطمئنة.
قواعد صارمة: (1) لا تخترع أي رقم؛ استخدم فقط الأرقام الواردة في «سياق المستخدم». (2) لا تقدّم وعوداً بعوائد مضمونة. (3) شجّع تجنّب القروض غير الضرورية والبدائل بصفر فوائد. (4) القرار للمستخدم دائماً. (5) أجب بإيجاز (2-4 جمل) وبالعربية الفصحى.
البدائل الخمسة: الجمعيات المالية الرقمية، التمويل الحكومي التنموي المدعوم، التراكم الاستثماري، الحماية التأمينية، التكافل المجتمعي «فُرجت».
TXT;

    /** يعالج رسالة المستخدم ويعيد رسالة المستشار (ويحفظ الاثنتين). */
    public function chat(User $user, Conversation $conversation, string $message): ConversationMessage
    {
        $conversation->messages()->create([
            'role' => 'user', 'content' => $message,
            'tokens_input' => 0, 'tokens_output' => 0, 'cached' => false,
        ]);
        $conversation->forceFill(['last_message_at' => Carbon::now()])->save();

        $reply = $this->generateReply($user, $conversation, $message);

        $assistant = $conversation->messages()->create([
            'role' => 'assistant', 'content' => $reply['content'],
            'tokens_input' => $reply['in'] ?? 0, 'tokens_output' => $reply['out'] ?? 0, 'cached' => $reply['cached'] ?? false,
        ]);

        $conversation->forceFill([
            'last_message_at' => Carbon::now(),
            'model_used' => $reply['model'] ?? $conversation->model_used,
        ])->save();

        return $assistant;
    }

    /** يختار مصدر الرد: Claude عند توفّر المفتاح، وإلا المحرك الحتمي. */
    private function generateReply(User $user, Conversation $conversation, string $message): array
    {
        $facts = $this->facts($user);

        $key = config('rashid.ai_key');
        if (! empty($key)) {
            try {
                return $this->viaClaude($key, $facts['text'], $conversation);
            } catch (\Throwable $e) {
                // فشل الاتصال بـ Claude ⟶ نرجع للمحرك الحتمي بصمت.
            }
        }

        return [
            'content' => $this->deterministicReply($facts, $message),
            'model' => 'rule-engine',
        ];
    }

    /** طبقة Claude API (اختيارية) مع تخزين مؤقت لطبقة القواعد الثابتة. */
    private function viaClaude(string $key, string $userContext, Conversation $conversation): array
    {
        $history = $conversation->messages()
            ->whereIn('role', ['user', 'assistant'])
            ->orderBy('id')
            ->get()
            ->map(fn ($m) => ['role' => $m->role, 'content' => $m->content])
            ->values()
            ->all();

        $model = config('rashid.ai_model');

        $response = Http::withHeaders([
            'x-api-key' => $key,
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json',
        ])->timeout(30)->post('https://api.anthropic.com/v1/messages', [
            'model' => $model,
            'max_tokens' => 600,
            'system' => [
                ['type' => 'text', 'text' => self::SYSTEM_RULES, 'cache_control' => ['type' => 'ephemeral']],
                ['type' => 'text', 'text' => "سياق المستخدم (لا تتجاوزه):\n".$userContext],
            ],
            'messages' => $history,
        ]);

        $response->throw();
        $data = $response->json();

        $text = $data['content'][0]['text'] ?? '';
        if ($text === '') {
            throw new \RuntimeException('empty completion');
        }

        return [
            'content' => trim($text),
            'model' => $model,
            'in' => $data['usage']['input_tokens'] ?? 0,
            'out' => $data['usage']['output_tokens'] ?? 0,
            'cached' => (bool) ($data['usage']['cache_read_input_tokens'] ?? 0),
        ];
    }

    /** يجمع حقائق المستخدم المالية كسياق منظّم + نص عربي مختصر. */
    private function facts(User $user): array
    {
        $p = $user->financialProfile;
        $income = (int) ($p->monthly_income_halalas ?? 0);
        $expenses = (int) ($p->monthly_expenses_halalas ?? 0);
        $disposable = (int) ($p->disposable_income_halalas ?? 0);
        $dti = (float) ($p->dti_ratio ?? 0);
        $risk = $p->risk_band ?? 'low';

        $session = $user->decisionSessions()->with('outcome')->latest('id')->first();
        $outcome = $session?->outcome;

        $goals = $user->financialGoals()->where('status', 'active')->get();

        $sar = fn ($h) => number_format($h / 100);
        $riskText = $risk === 'low' ? 'منخفضة' : ($risk === 'medium' ? 'متوسطة' : 'مرتفعة');

        $lines = [
            "الدخل الشهري: {$sar($income)} ريال.",
            "المصروف الشهري: {$sar($expenses)} ريال.",
            "الفائض المتاح شهرياً: {$sar($disposable)} ريال.",
            "نسبة الالتزام إلى الدخل (DTI): {$dti}% (شريحة مخاطر {$riskText}).",
        ];
        if ($outcome) {
            $verdict = $outcome->verdict === 'avoid_borrowing' ? 'ينصح المحرك بتجنّب الاقتراض' : 'ينصح المحرك بترشيد الاقتراض إن كان حتمياً';
            $lines[] = "آخر تحليل قرار: {$verdict} (مبلغ {$sar((int) ($session->requested_amount_halalas ?? 0))} ريال).";
        }
        if ($goals->isNotEmpty()) {
            $g = $goals->map(fn ($x) => $x->title.' ('.$sar((int) $x->saved_amount_halalas).' من '.$sar((int) $x->target_amount_halalas).' ريال)')->implode('، ');
            $lines[] = "الأهداف النشطة: {$g}.";
        }

        return [
            'income' => $income, 'expenses' => $expenses, 'disposable' => $disposable,
            'dti' => $dti, 'risk' => $risk, 'riskText' => $riskText,
            'outcome' => $outcome, 'session' => $session, 'goals' => $goals, 'sar' => $sar,
            'text' => implode("\n", $lines),
        ];
    }

    /** رد حتمي مبني على القواعد وبيانات المستخدم (يعمل دون مفتاح API). */
    private function deterministicReply(array $f, string $message): string
    {
        $sar = $f['sar'];
        $m = mb_strtolower($message);
        $has = fn (array $kw) => (bool) array_filter($kw, fn ($k) => mb_strpos($m, $k) !== false);

        if ($has(['التزام', 'dti', 'نسبة'])) {
            return "نسبة الالتزام إلى الدخل (DTI) لديك {$f['dti']}% وهي شريحة {$f['riskText']}. تعني أنّ التزاماتك الشهرية تستهلك هذه النسبة من دخلك؛ وكلما قلّت زادت مرونتك المالية وقدرتك على الادخار بدل الاقتراض.";
        }
        if ($has(['ادخر', 'أوفّر', 'اوفر', 'توفير', 'ادّخر'])) {
            $months = $f['disposable'] > 0 ? max(1, (int) ceil(30000 / ($f['disposable'] / 100))) : 0;
            $tail = $months > 0 ? " فمثلاً لتكوين 30,000 ريال تحتاج نحو {$months} أشهر ادخاراً بدل قرض بفوائد." : '';
            return "فائضك المتاح شهرياً {$sar($f['disposable'])} ريال. بتخصيص جزء منه بانتظام تبني سيولتك بنفسك دون فوائد.{$tail}";
        }
        if ($has(['بديل', 'بدائل', 'خيار', 'أقترض', 'اقترض', 'قرض'])) {
            $extra = '';
            if ($f['outcome']) {
                $extra = $f['outcome']->verdict === 'avoid_borrowing'
                    ? ' وبحسب آخر تحليل، وضعك يسمح بتجنّب الاقتراض تماماً.'
                    : ' وإن كان الاقتراض حتمياً فقارن العروض واختر الأقل كلفةً إجمالية.';
            }
            return "أمامك خمسة بدائل بصفر فوائد قبل أي قرض: الجمعيات المالية الرقمية، التمويل الحكومي التنموي (بنك التنمية الاجتماعية)، التراكم الاستثماري (صكوك صح)، الحماية التأمينية، والتكافل المجتمعي «فُرجت».{$extra} تصفّحها من قسم البدائل لاختيار الأنسب لهدفك.";
        }
        if ($has(['طوارئ', 'طارئ'])) {
            return "صندوق الطوارئ درعك الأول ضد الاقتراض المفاجئ. القاعدة أن يغطّي 3 إلى 6 أشهر من مصروفك ({$sar($f['expenses'] * 3)} إلى {$sar($f['expenses'] * 6)} ريال). ابدأ بتخصيص جزء من فائضك الشهري له.";
        }

        // رد عام: ملخّص الوضع
        $verdict = '';
        if ($f['outcome']) {
            $verdict = $f['outcome']->verdict === 'avoid_borrowing'
                ? ' وبحسب تحليلك الأخير، لست مضطراً للاقتراض.'
                : ' وبحسب تحليلك الأخير، رشّد أي اقتراض واختر أقل كلفة.';
        }

        return "باختصار: دخلك {$sar($f['income'])} ومصروفك {$sar($f['expenses'])}، فيتبقّى لك {$sar($f['disposable'])} ريال شهرياً، ونسبة التزامك {$f['dti']}% ({$f['riskText']}).{$verdict} اسألني عن «نسبة الالتزام»، «كم أوفّر لو ادّخرت»، أو «ما البدائل المتاحة».";
    }
}
