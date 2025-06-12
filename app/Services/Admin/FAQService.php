<?php
namespace App\Services\Admin;

use App\Models\FAQItem;

class FAQService
{
    public function createFAQItem(array $data): FAQItem
    {
        return FAQItem::create($data);
    }

    public function updateFAQItem(FAQItem $faqItem, array $data): bool
    {   
        return $faqItem->update($data);
    }

    public function deleteFAQItem(FAQItem $faqItem): bool
    {
        return $faqItem->delete();
    }
}