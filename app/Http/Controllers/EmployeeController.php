<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Contrôleur pour la gestion de l'espace Employé.
 * Gère le dashboard personnel et la signature des contrats.
 */
class EmployeeController extends Controller
{
    /**
     * Génère et télécharge le contrat en PDF.
     */
    public function downloadPdf(Contrat $contract)
    {
        $user = Auth::user();
        
        // SECURITÉ : Seul l'employé propriétaire du contrat peut le télécharger
        if ($contract->employe_id !== $user->employe->id) {
            abort(403, 'Action non autorisée.');
        }

        $pdf = Pdf::loadView('contracts.pdf', compact('contract'));
        
        return $pdf->download('Contrat_GuineJob_' . $contract->numero_contrat . '.pdf');
    }
    /**
     * Affiche le tableau de bord de l'employé.
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $employe = $user->employe;
        
        return view('employee.dashboard', compact('user', 'employe'));
    }

    /**
     * Affiche le contrat de travail pour consultation et signature.
     */
    public function showContract(): View|RedirectResponse
    {
        $user = Auth::user();
        $employe = $user->employe;

        if (!$employe) {
            return back()->with('error', 'Aucune fiche employé trouvée pour votre compte.');
        }

        // Récupère le contrat le plus récent (exclut les brouillons non envoyés)
        $contract = $employe->contrats()
                            ->where('statut', '!=', Contrat::STATUS_DRAFT)
                            ->latest()
                            ->first();

        return view('employee.contracts.show', compact('user', 'employe', 'contract'));
    }

    /**
     * Procède à la signature électronique finale du contrat par l'employé.
     */
    public function signContractEmployee(Request $request, Contrat $contract): RedirectResponse
    {
        // VERIFICATION EXPERT : L'employeur doit avoir signé en premier pour la validité légale
        if (!$contract->signed_at_employer) {
            return back()->with('error', 'L\'employeur doit signer le contrat avant vous.');
        }

        $contract->update([
            'statut' => Contrat::STATUS_ACTIVE, // Le contrat devient officiellement Actif
            'signed_at_employee' => now(),
            'ip_employee' => $request->ip(),
        ]);

        return back()->with('success', 'Félicitations ! Votre contrat est désormais signé et actif.');
    }
}
