<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\FAQItem;
use App\Models\History;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('About/Index', [
            'teamMembers' => TeamMember::all(),
            'faq' => FAQItem::all(),
            'histories' => History::orderBy('date', 'ASC')->get()
        ]);
    }
}
