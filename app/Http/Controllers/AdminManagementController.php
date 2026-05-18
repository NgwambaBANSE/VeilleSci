<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminManagementController extends Controller
{
    /**
     * Afficher la liste des administrateurs
     */
    public function index()
    {
        $admins = User::where('is_admin', true)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Afficher le formulaire d'ajout d'administrateur
     */
    public function create()
    {
        // Lister tous les utilisateurs non-admins
        $users = User::where('is_admin', false)
            ->orderBy('name')
            ->get();

        return view('admin.admins.create', compact('users'));
    }

    /**
     * Ajouter un utilisateur comme administrateur
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|not_in:' . Auth::id(),
        ], [
            'user_id.required' => 'Sélectionnez un utilisateur',
            'user_id.exists' => 'Utilisateur introuvable',
            'user_id.not_in' => 'Vous ne pouvez pas modifier votre propre statut',
        ]);

        $user = User::findOrFail($request->user_id);

        // Vérifier que l'utilisateur n'est pas déjà admin
        if ($user->is_admin) {
            return back()->with('error', "$user->name est déjà administrateur");
        }

        try {
            $user->update(['is_admin' => true]);

            Log::info('Admin added', [
                'admin_id' => Auth::id(),
                'admin_name' => Auth::user()->name,
                'new_admin_id' => $user->id,
                'new_admin_name' => $user->name,
            ]);

            return redirect()->route('admin.admins.index')
                ->with('success', "$user->name a été promu administrateur");
        } catch (\Exception $e) {
            Log::error('Error adding admin', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erreur lors de la promotion de l\'utilisateur');
        }
    }

    /**
     * Afficher les détails d'un administrateur
     */
    public function show(User $admin)
    {
        // Vérifier que c'est un admin
        if (!$admin->is_admin) {
            abort(404);
        }

        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Retirer les droits d'administrateur
     */
    public function destroy(Request $request, User $admin)
    {
        $request->validate([
            'confirm' => 'required|accepted',
        ]);

        // Empêcher de se retirer soi-même les droits
        if ($admin->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas retirer vos propres droits d\'administrateur');
        }

        // Vérifier que c'est un admin
        if (!$admin->is_admin) {
            return back()->with('error', "$admin->name n'est pas administrateur");
        }

        try {
            $userName = $admin->name;
            $admin->update(['is_admin' => false]);

            Log::warning('Admin removed', [
                'removed_by_id' => Auth::id(),
                'removed_by_name' => Auth::user()->name,
                'admin_id' => $admin->id,
                'admin_name' => $userName,
            ]);

            return redirect()->route('admin.admins.index')
                ->with('success', "$userName n'est plus administrateur");
        } catch (\Exception $e) {
            Log::error('Error removing admin', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erreur lors de la suppression des droits d\'administrateur');
        }
    }

    /**
     * Rechercher des utilisateurs non-admin pour AJAX
     */
    public function search(Request $request)
    {
        $search = $request->get('q', '');

        $users = User::where('is_admin', false)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json($users);
    }
}
