<?php

namespace App\Http\Controllers\Api;

use App\Models\SystemEvent;
use App\Models\User;
use App\Models\LegalCase;
use App\Models\PublicSector;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseRequest;
use App\Http\Resources\LegalCaseResource;
use App\Http\Resources\PublicSectorResource;

class CasesController extends Controller
{
    public function prerequisites()
    {
        $investigators = User::query()->where('role', 'investigator')->get();
        $judiciaryOfficers = User::query()->where('role', 'judiciary-officer')->get();
        $publicSectors = PublicSector::all();

        return response()->json([
            'role' => auth()->user()->role,
            'investigators' => UserResource::collection($investigators),
            'judiciary_officers' => UserResource::collection($judiciaryOfficers),
            'public_sectors' => PublicSectorResource::collection($publicSectors)
        ]);
    }

    public function index()
    {
        $cases = LegalCase::all();

        if (auth()->user()->role == 'judiciary-admin') {
            $cases = LegalCase::query()->published()->get();
        }

        if (auth()->user()->role == 'investigator') {
            $cases = LegalCase::query()->where('investigator_id', auth()->id())->get();
        }

        if (auth()->user()->role == 'judiciary-officer') {
            $cases = LegalCase::query()->where('judicial_officer_id', auth()->id())->get();
        }

        return response(LegalCaseResource::collection($cases));
    }

    public function store(StoreCaseRequest $request)
    {
        $case = LegalCase::create(array_merge($request->only('title', 'description', 'status'), [
            'public_sector_id' => $request->get('public_sector'),
            'investigator_id' => $request->get('investigator'),
            'judicial_officer_id' => $request->get('judicial_officer'),
            'is_published' => $request->get('published')
        ]));

        //attach system events
        $events = SystemEvent::query()->where('public_sector_id', $case->public_sector_id)->pluck('id');
        $case->systemEvents()->sync($events);
    }

    public function show( int $id)
    {
        $case = LegalCase::query()->with('systemEvents')->findOrFail($id);

        return response(new LegalCaseResource($case));
    }

    public function update(StoreCaseRequest $request, int $id)
    {
        $case = LegalCase::findOrFail($id);

        $case->update(array_merge($request->only('title', 'description', 'status'), [
            'public_sector_id' => $request->get('public_sector'),
            'investigator_id' => $request->get('investigator'),
            'judicial_officer_id' => $request->get('judicial_officer'),
            'is_published' => $request->get('published')
        ]));

        //attach system events
        $events = SystemEvent::query()->where('public_sector_id', $case->public_sector_id)->pluck('id');
        $case->systemEvents()->sync($events);
    }
}
