<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VuePlanning;

class PlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->boolean('_dd')) {
            return response()->json([
                'HX-Request' => $request->header('HX-Request'),
                'query'      => $request->query(),
                'note'       => 'Debug OK sans 500'
            ]);
        }

        $q = VuePlanning::query();
        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }

        //$rows = VuePlanning::orderBy('PA', 'asc')->orderBy('semaine_engagement', 'desc')->get();
        $rows = VuePlanning::orderByDesc('semaine')->limit(50)->get();

        // Si c’est un appel HTMX, on renvoie UNIQUEMENT le tbody
        if ($request->header('HX-Request')) {
            return view('planning.partials.tbody', compact('rows'));
        }

        $statuses = ['Fait', 'Reporté', 'En cours', 'Engagé'];
        return view('planning.index', compact('rows', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
