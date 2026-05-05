<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Dashboard de l'employé
     */
    public function dashboard()
    {
        $user = Auth::user();
        $employe = $user->employe;
        
        return view('employee.dashboard', compact('user', 'employe'));
    }

    /**
     * Affichage du contrat de travail (GUIN-2)
     */
    public function showContract()
    {
        $user = Auth::user();
        $employe = $user->employe;

        if (!$employe) {
            return back()->with('error', 'Aucune fiche employé trouvée pour votre compte.');
        }

        // Récupérer le dernier contrat qui a été au moins ENVOYÉ (pas les brouillons)
        $contract = $employe->contrats()
                            ->where('statut', '!=', Contrat::STATUS_DRAFT)
                            ->latest()
                            ->first();

        return view('employee.contracts.show', compact('user', 'employe', 'contract'));
    }

    public function signContractEmployee(Request $request, Contrat $contract)
    {
        // VERIFICATION EXPERT : L'employeur doit avoir signé en premier
        if (!$contract->signed_at_employer) {
            return back()->with('error', 'L\'employeur doit signer le contrat avant vous.');
        }

        $contract->update([
            'statut' => Contrat::STATUS_ACTIVE, // Devient actif après la signature finale
            'signed_at_employee' => now(),
            'ip_employee' => $request->ip(),
        ]);

        return back()->with('success', 'Félicitations ! Vous avez signé votre contrat de travail.');
    }
}
