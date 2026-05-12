<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Opportunite;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FavorisController extends Controller
{
    /**
     * Récupérer les favoris de l'utilisateur connecté
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user() ?? auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        $favoris = Favori::where('user_id', $user->id)
            ->with('opportunite')
            ->get()
            ->pluck('opportunite');

        return response()->json(['data' => $favoris], 200);
    }

    /**
     * Ajouter/Retirer une opportunité des favoris (toggle)
     */
    public function toggle(Request $request, Opportunite $opportunite): JsonResponse
    {
        $user = $request->user() ?? auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        $favori = Favori::where('user_id', $user->id)
            ->where('opportunite_id', $opportunite->id)
            ->first();

        if ($favori) {
            // Retirer des favoris
            $favori->delete();
            return response()->json(['message' => 'Retiré des favoris', 'favorited' => false], 200);
        } else {
            // Ajouter aux favoris
            Favori::create([
                'user_id' => $user->id,
                'opportunite_id' => $opportunite->id,
            ]);
            return response()->json(['message' => 'Ajouté aux favoris', 'favorited' => true], 200);
        }
    }

    /**
     * Vérifier si une opportunité est en favoris
     */
    public function check(Request $request, Opportunite $opportunite): JsonResponse
    {
        $user = $request->user() ?? auth()->user();
        
        if (!$user) {
            return response()->json(['favorited' => false], 200);
        }

        $favorited = Favori::where('user_id', $user->id)
            ->where('opportunite_id', $opportunite->id)
            ->exists();

        return response()->json(['favorited' => $favorited], 200);
    }
}
