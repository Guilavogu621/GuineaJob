<x-mail::message>
# Bonjour {{ $user->prenom }},

Votre espace **Employeur** a été créé avec succès sur GuinéaJob par l'équipe administrative.

Voici vos identifiants de connexion provisoires :

<x-mail::panel>
**Email :** {{ $user->email }}
**Mot de passe :** {{ $password }}
</x-mail::panel>

Lors de votre première connexion, il vous sera demandé de modifier ce mot de passe pour des raisons de sécurité.

<x-mail::button :url="route('login')">
Se connecter à mon espace
</x-mail::button>

Si vous avez des questions, n'hésitez pas à contacter notre support technique.

Cordialement,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
