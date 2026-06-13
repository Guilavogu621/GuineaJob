<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Création des Rôles Spatie (Section 7.2 du CDC)
        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        $employerRole = Role::updateOrCreate(['name' => 'employeur']);
        $employeeRole = Role::updateOrCreate(['name' => 'employe']);
        $candidatRole = Role::updateOrCreate(['name' => 'candidat']);
        $prestataireRole = Role::updateOrCreate(['name' => 'prestataire']);

        // 2. Création de quelques Permissions de base
        Permission::updateOrCreate(['name' => 'manage users']);
        Permission::updateOrCreate(['name' => 'manage companies']);
        Permission::updateOrCreate(['name' => 'create employees']);
        Permission::updateOrCreate(['name' => 'generate contracts']);

        $adminRole->givePermissionTo(Permission::all());
        $employerRole->givePermissionTo(['create employees', 'generate contracts']);

        // 3. Administrateur principal
        $admin = User::updateOrCreate(
            ['email' => 'admin@guineajob.gn'],
            [
                'nom' => 'GUILAVOGUI',
                'prenom' => 'Kowolé',
                'password' => Hash::make('password'),
                'role' => 'admin', // Gardé pour compatibilité temporaire
                'must_change_password' => false,
            ]
        );
        $admin->assignRole($adminRole);

        // 4. Employeur de test
        $employer = User::updateOrCreate(
            ['email' => 'keplerjrguilavogui@gmail.com'],
            [
                'nom' => 'GUILAVOGUI',
                'prenom' => 'Kepler',
                'password' => Hash::make('password'),
                'role' => 'employeur', // Gardé pour compatibilité temporaire
                'must_change_password' => false,
            ]
        );
        $employer->assignRole($employerRole);

        // 5. Entreprise
        Entreprise::where('user_id', $employer->id)->delete();
        Entreprise::create([
            'user_id' => $employer->id,
            'raison_sociale' => 'KG Soft & Tech',
            'secteur' => 'Informatique & Télécoms',
            'adresse' => 'Conakry, Guinée',
            'site_web' => 'https://kg-tech.gn',
            'description' => 'Entreprise de services numériques.',
        ]);

        echo "--------------------------------------------------\n";
        echo "Système de Permissions Spatie Initialisé !\n";
        echo "Rôles créés : admin, employeur, employe, candidat, prestataire\n";
        echo "--------------------------------------------------\n";
    }
}
