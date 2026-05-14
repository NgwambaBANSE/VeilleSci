<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // GET /profil — Afficher le profil
    public function show()
    {
        $user    = Auth::user();
        $profile = $user->profile ?? new Profile();
        return view('profile.show', compact('user', 'profile'));
    }

    // GET /profil/modifier — Formulaire d'édition
    public function edit()
    {
        $user    = Auth::user();
        $profile = $user->profile ?? new Profile();
        return view('profile.edit', compact('user', 'profile'));
    }

    // PUT /profil — Sauvegarder les modifications
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'        => 'required|string|max:255',
            'titre'       => 'nullable|string|max:10',
            'institution' => 'nullable|string|max:255',
            'departement' => 'nullable|string|max:255',
            'specialite'  => 'nullable|string|max:255',
            'pays'        => 'nullable|string|max:100',
            'ville'       => 'nullable|string|max:100',
            'telephone'   => 'nullable|string|max:20',
            'biographie'  => 'nullable|string|max:2000',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'cv'          => 'nullable|file|mimes:pdf|max:5120',
            'orcid'       => 'nullable|string|max:255',
            'researchgate'=> 'nullable|string|max:255',
            'linkedin'    => 'nullable|string|max:255',
            'site_web'    => 'nullable|url|max:255',
        ]);

        // Mettre à jour le nom de l'utilisateur
        $user->update(['name' => $request->name]);

        // Données du profil
        $data = $request->only([
            'titre', 'institution', 'departement', 'specialite',
            'pays', 'ville', 'telephone', 'biographie',
            'orcid', 'researchgate', 'linkedin', 'site_web',
        ]);

        // Upload photo
        if ($request->hasFile('photo')) {
            if ($user->profile?->photo) {
                Storage::disk('public')->delete($user->profile->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Upload CV
        if ($request->hasFile('cv')) {
            if ($user->profile?->cv) {
                Storage::disk('public')->delete($user->profile->cv);
            }
            $data['cv'] = $request->file('cv')->store('cvs', 'public');
        }

        // Gérer les publications (JSON)
        $publications = [];
        if ($request->filled('pub_titres')) {
            foreach ($request->pub_titres as $i => $titre) {
                if (!empty($titre)) {
                    $publications[] = [
                        'titre'   => $titre,
                        'revue'   => $request->pub_revues[$i]  ?? '',
                        'annee'   => $request->pub_annees[$i]  ?? '',
                        'lien'    => $request->pub_liens[$i]   ?? '',
                        'type'    => $request->pub_types[$i]   ?? 'Article',
                    ];
                }
            }
        }
        $data['publications'] = $publications;

        // Créer ou mettre à jour le profil
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->route('profile.show')
            ->with('success', 'Profil mis à jour avec succès !');
    }
}