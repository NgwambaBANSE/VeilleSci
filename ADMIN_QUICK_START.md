# ⚡ QUICK START - Gestion des Administrateurs

## 5 Minutes pour Commencer

### État Actuel ✅
- ✅ 8 utilisateurs
- ✅ 1 administrateur existant: **Admin** (admin@veille.local)
- ✅ Système prêt à l'emploi

---

## 🎯 3 Étapes pour Ajouter un Admin

### 1. Se Connecter
```
http://localhost:8000/login
Utilisateur: admin@veille.local
Mot de passe: [votre mot de passe]
```

### 2. Aller au Panneau
```
http://localhost:8000/admin/admins
```

### 3. Ajouter un Utilisateur
```
Cliquer: "+ Ajouter un administrateur"
Choisir: Un utilisateur dans la liste
Cliquer: "Promouvoir en administrateur"
Prêt! ✅
```

---

## 📝 Alternative: Terminal

```bash
cd C:\laragon\www\VeilleSci
php artisan tinker

# Ajouter admin
$user = User::find(2);
$user->promoteToAdmin();

# Ou retirer
$user->demoteFromAdmin();
```

---

## 🔗 Liens Utiles

| Lien | But |
|------|-----|
| `/admin/admins` | Liste des administrateurs |
| `/admin/admins/create` | Ajouter un administrateur |
| `/admin/admins/1` | Voir les détails |

---

## ✓ C'est Fait!

Les utilisateurs promus peuvent maintenant:
- Accéder à `/admin`
- Gérer les opportunités
- Ajouter d'autres administrateurs

---

**Besoin d'aide?** → Voir `ADMIN_MANAGEMENT_GUIDE.md`
