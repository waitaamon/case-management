<?php

namespace App\Http\Controllers;


use App\Models\LegalCase;

class CaseController extends Controller
{
    public function index()
    {
        $cases = LegalCase::all();

        if (auth()->user()->role == 'judiciary-admin') {
            $cases = LegalCase::query()->published()->get();
        }

        return view('legal-cases.index', compact('cases'));
    }
}
