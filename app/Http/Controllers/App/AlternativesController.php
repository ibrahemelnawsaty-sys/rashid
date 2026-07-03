<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Alternative;
use Illuminate\Contracts\View\View;

/**
 * قائمة البدائل الخمسة الجوهرية بترتيب الأولوية مع مقدّميها.
 */
class AlternativesController extends Controller
{
    public function index(): View
    {
        $alternatives = Alternative::with(['providers' => function ($query) {
            $query->orderBy('sort_order');
        }, 'providers.provider'])
            ->where('is_active', true)
            ->orderBy('priority')
            ->get();

        return view('screens.alternatives-index', [
            'alternatives' => $alternatives,
        ]);
    }

    /** تفصيل بديل واحد مع مقدّميه المعتمدين. */
    public function show(string $slug): View
    {
        $alternative = Alternative::with([
            'providers' => fn ($query) => $query->orderBy('sort_order'),
            'providers.provider',
        ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('screens.alternative-show', [
            'alternative' => $alternative,
        ]);
    }
}
