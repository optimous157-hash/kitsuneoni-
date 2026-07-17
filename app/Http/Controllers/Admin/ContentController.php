<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use App\Models\Faq;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function sections()
    {
        $sections = PageSection::orderBy('sort_order')->get();
        return view('admin.content.sections', compact('sections'));
    }

    public function updateSection(Request $request, string $key)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        PageSection::updateOrCreate(
            ['key' => $key],
            [
                'title' => $validated['title'] ?? null,
                'content' => $validated['content'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]
        );

        return back()->with('success', 'Section updated.');
    }

    public function faqs()
    {
        $faqs = Faq::ordered()->get();
        return view('admin.content.faqs', compact('faqs'));
    }

    public function storeFaq(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:100',
        ]);

        Faq::create($validated);
        return back()->with('success', 'FAQ added.');
    }

    public function destroyFaq(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted.');
    }
}
