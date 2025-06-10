<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\FAQItem;
use App\Services\FAQService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\FAQItemStoreRequest;
use App\Http\Requests\FAQItemUpdateRequest;

class FAQController extends Controller
{

    public function __construct(
        private FAQService $faqService
    ) {}

    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/FAQ', [
            'faq' => FAQItem::all()
        ]);
    }

    public function store(FAQItemStoreRequest $request): RedirectResponse 
    {
        $validated = $request->validated();
        $this->faqService->createFAQItem($validated);

        return back();
    }
    
    public function update($faqItem_id, FAQItemUpdateRequest $request): RedirectResponse 
    {
        $faqItem = FAQItem::findOrFail($faqItem_id);
        $validated = $request->validated();
        $this->faqService->updateFAQItem($faqItem, $validated);

        return back();
    }
        
    public function destroy($faqItem_id): RedirectResponse 
    {
        $faqItem = FAQItem::findOrFail($faqItem_id);
        $this->faqService->deleteFAQItem($faqItem);
        return back();
    }
}
