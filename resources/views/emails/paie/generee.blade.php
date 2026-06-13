<x-mail::message>
# Bonjour {{ $fiche->employe->user->prenom }},

Votre fiche de paie pour le mois de **{{ $fiche->mois->translatedFormat('F Y') }}** a été générée par votre employeur (**{{ $fiche->employe->entreprise->raison_sociale }}**).

**Détails de la paie :**
- **Salaire Brut :** {{ number_format($fiche->salaire_brut, 0, ',', ' ') }} GNF
- **Salaire Net :** {{ number_format($fiche->salaire_net, 0, ',', ' ') }} GNF

Vous pouvez consulter et télécharger votre bulletin détaillé au format PDF en cliquant sur le bouton ci-dessous :

<x-mail::button :url="route('employee.paie.index')">
Accéder à mes bulletins
</x-mail::button>

Ce document est authentifié par GuinéaJob et contient un QR Code de sécurité.

Merci,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
