<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use Illuminate\Http\Request;

class PublishCaseController extends Controller
{
    public function __invoke(Request $request)
    {
        $case = LegalCase::query()->findOrFail($request->id);

        $case->systemEvents()->sync($request->selected);

        $case->update(['is_published' => true]);

    }
}
