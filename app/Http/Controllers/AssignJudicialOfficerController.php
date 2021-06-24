<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use Illuminate\Http\Request;

class AssignJudicialOfficerController extends Controller
{
    public function __invoke(Request $request)
    {
        $case = LegalCase::query()->findOrFail($request->id);

        $case->update(['judicial_officer_id' => $request->officer]);
    }
}
