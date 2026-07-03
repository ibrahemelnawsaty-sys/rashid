<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Services\AiAdvisorService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * المستشار الذكي: محادثة تشرح مخرجات محرك القواعد بلغة بسيطة.
 */
class AdvisorController extends Controller
{
    public function __construct(private readonly AiAdvisorService $advisor) {}

    public function index(): View
    {
        $user = auth()->user();
        $conversation = $this->currentConversation($user);
        $messages = $conversation->messages()->orderBy('id')->get();

        return view('screens.advisor', [
            'user' => $user,
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['message' => ['required', 'string', 'max:500']]);

        $user = auth()->user();
        $conversation = $this->currentConversation($user);

        $this->advisor->chat($user, $conversation, $data['message']);

        return redirect()->route('app.advisor.index');
    }

    /** يجلب محادثة مفتوحة للمستخدم أو ينشئ واحدة. */
    private function currentConversation($user): Conversation
    {
        return $user->conversations()->where('status', 'open')->latest('id')->first()
            ?? $user->conversations()->create([
                'title' => 'محادثة مع المستشار',
                'status' => 'open',
            ]);
    }
}
