<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Opportunite;
use Illuminate\Http\Request;

class OpportuniteController extends Controller
{
    // GET /api/v1/opportunites
    public function index(Request $request)
    {
        $query = Opportunite::query()
            ->where('active', true)
            ->where('date_limite', '>=', now());

        if ($request->filled('categorie') && $request->categorie !== 'Toutes') {
            $query->where('categorie', $request->categorie);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('titre',       'like', "%$s%")
                  ->orWhere('domaine',      'like', "%$s%")
                  ->orWhere('pays',         'like', "%$s%")
                  ->orWhere('description',  'like', "%$s%");
            });
        }

        $opportunites = $query->orderBy('date_limite', 'asc')->get();

        return response()->json([
            'success' => true,
            'data'    => $opportunites,
            'total'   => $opportunites->count(),
        ]);
    }

    // GET /api/v1/opportunites/{id}
    public function show($id)
    {
        $opportunite = Opportunite::findOrFail($id);
        return response()->json(['success' => true, 'data' => $opportunite]);
    }

    // GET /api/v1/statistiques
    public function statistiques()
    {
        $base = Opportunite::where('active', true)->where('date_limite', '>=', now());

        return response()->json([
            'success' => true,
            'data'    => [
                'total'        => (clone $base)->count(),
                'publications' => (clone $base)->where('categorie', 'Publications')->count(),
                'conferences'  => (clone $base)->where('categorie', 'Conférences')->count(),
                'formations'   => (clone $base)->where('categorie', 'Formations')->count(),
                'stages'       => (clone $base)->where('categorie', 'Stages')->count(),
                'bourses'      => (clone $base)->where('categorie', 'Bourses')->count(),
                'urgentes'     => (clone $base)->where('date_limite', '<=', now()->addDays(14))->count(),
            ],
        ]);
    }

    // POST /api/v1/opportunites
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'       => 'required|string|max:255',
            'categorie'   => 'required|in:Publications,Conférences,Formations,Stages,Bourses',
            'domaine'     => 'required|string|max:100',
            'date_limite' => 'required|date|after:today',
            'pays'        => 'required|string|max:100',
            'description' => 'required|string',
            'lien'        => 'nullable|url',
        ]);

        return response()->json([
            'success' => true,
            'data'    => Opportunite::create($validated),
        ], 201);
    }

    // PUT /api/v1/opportunites/{id}
    public function update(Request $request, $id)
    {
        $opportunite = Opportunite::findOrFail($id);
        $opportunite->update($request->validate([
            'titre'       => 'sometimes|string|max:255',
            'categorie'   => 'sometimes|in:Publications,Conférences,Formations,Stages,Bourses',
            'domaine'     => 'sometimes|string|max:100',
            'date_limite' => 'sometimes|date',
            'pays'        => 'sometimes|string|max:100',
            'description' => 'sometimes|string',
            'lien'        => 'nullable|url',
            'active'      => 'sometimes|boolean',
        ]));

        return response()->json(['success' => true, 'data' => $opportunite]);
    }

    // DELETE /api/v1/opportunites/{id}
    public function destroy($id)
    {
        Opportunite::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Opportunité supprimée.']);
    }
}