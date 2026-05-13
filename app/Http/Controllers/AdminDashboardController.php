<?php

namespace App\Http\Controllers;

use App\Models\Opportunite;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Afficher le tableau de bord admin
     */
    public function index()
    {
        $opportunites = Opportunite::orderBy('created_at', 'desc')->get();
        $stats = [
            'total' => Opportunite::count(),
            'actives' => Opportunite::where('active', true)->count(),
            'inactives' => Opportunite::where('active', false)->count(),
            'urgentes' => Opportunite::where('date_limite', '<=', now()->addDays(14))->where('active', true)->count(),
        ];

        return view('admin.dashboard', compact('opportunites', 'stats'));
    }

    /**
     * Formulaire de création d'opportunité
     */
    public function create()
    {
        return view('admin.create-opportunite');
    }

    /**
     * Stocker une nouvelle opportunité
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'       => 'required|string|max:255',
            'categorie'   => 'required|in:Publications,Conférences,Formations,Stages,Bourses',
            'domaine'     => 'required|string|max:100',
            'date_limite' => 'required|date|after:today',
            'pays'        => 'required|string|max:100',
            'description' => 'required|string|min:10',
            'lien'        => 'nullable|url',
            'active'      => 'boolean',
        ]);

        Opportunite::create($validated);

        return redirect('/admin')->with('success', 'Opportunité créée avec succès !');
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Opportunite $opportunite)
    {
        return view('admin.edit-opportunite', compact('opportunite'));
    }

    /**
     * Mettre à jour une opportunité
     */
    public function update(Request $request, Opportunite $opportunite)
    {
        $validated = $request->validate([
            'titre'       => 'sometimes|string|max:255',
            'categorie'   => 'sometimes|in:Publications,Conférences,Formations,Stages,Bourses',
            'domaine'     => 'sometimes|string|max:100',
            'date_limite' => 'sometimes|date',
            'pays'        => 'sometimes|string|max:100',
            'description' => 'sometimes|string|min:10',
            'lien'        => 'nullable|url',
            'active'      => 'sometimes|boolean',
        ]);

        $opportunite->update($validated);

        return redirect('/admin')->with('success', 'Opportunité mise à jour !');
    }

    /**
     * Supprimer une opportunité
     */
    public function destroy(Opportunite $opportunite)
    {
        $opportunite->delete();
        return redirect('/admin')->with('success', 'Opportunité supprimée !');
    }

    /**
     * Activer/Désactiver une opportunité
     */
    public function toggle(Opportunite $opportunite)
    {
        $opportunite->update(['active' => !$opportunite->active]);
        return response()->json(['success' => true, 'active' => $opportunite->active]);
    }
}
