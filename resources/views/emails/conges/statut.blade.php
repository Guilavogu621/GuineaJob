<x-mail::message>
# Bonjour {{ $conge->employe->user->prenom }},

Votre employeur a rendu une décision concernant votre demande de congé du **{{ $conge->date_debut->format('d/m/Y') }}** au **{{ $conge->date_fin->format('d/m/Y') }}**.

**Statut final :**
<x-mail::panel>
## {{ $conge->statut === \App\Models\Conge::STATUS_APPROVED ? '✅ APPROUVÉE' : '❌ REFUSÉE' }}
</x-mail::panel>

@if($conge->statut === \App\Models\Conge::STATUS_REJECTED)
**Motif du refus :**
> {{ $conge->reponse_employeur }}
@endif

**Récapitulatif :**
- **Type :** {{ ucfirst(str_replace('_', ' ', $conge->type_conge)) }}
- **Durée :** {{ $conge->jours_deduits }} jours ouvrables

Vous pouvez consulter le détail sur votre tableau de bord.

<x-mail::button :url="route('employee.conges.index')">
Voir mes congés
</x-mail::button>

Merci,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
