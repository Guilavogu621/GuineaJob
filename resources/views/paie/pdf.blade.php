<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bulletin de Paie - {{ $fiche->employe->user->full_name }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; font-size: 12px; }
        .header { border-bottom: 3px solid #0F6E56; padding-bottom: 20px; margin-bottom: 30px; }
        .logo-box { background: #0F6E56; color: white; padding: 10px; display: inline-block; font-weight: bold; border-radius: 5px; }
        .title { text-align: right; color: #BA7517; font-size: 24px; font-weight: bold; margin-top: -40px; text-transform: uppercase; }
        
        .info-section { margin-bottom: 30px; }
        .info-box { width: 45%; display: inline-block; vertical-align: top; }
        .label { font-weight: bold; color: #666; font-size: 10px; text-transform: uppercase; }
        .value { font-size: 13px; font-weight: bold; margin-bottom: 10px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background: #f4f4f4; padding: 10px; text-align: left; border-bottom: 2px solid #ddd; font-size: 10px; text-transform: uppercase; }
        td { padding: 12px 10px; border-bottom: 1px solid #eee; }
        .text-right { text-align: right; }
        
        .net-box { background: #0F6E56; color: white; padding: 20px; text-align: right; border-radius: 10px; margin-top: 20px; }
        .net-label { font-size: 12px; opacity: 0.8; }
        .net-value { font-size: 28px; font-weight: bold; }

        .footer { position: fixed; bottom: 0; width: 100%; border-top: 1px solid #eee; padding-top: 20px; font-size: 9px; color: #999; text-align: center; }
        .qr-code { position: absolute; bottom: 50px; left: 0; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-box">GUINÉAJOB</div>
        <div class="title">Bulletin de Paie</div>
        <div style="text-align: right; font-size: 14px; font-weight: bold;">{{ $fiche->mois->translatedFormat('F Y') }}</div>
    </div>

    <div class="info-section">
        <div class="info-box">
            <div class="label">Employeur</div>
            <div class="value">{{ $fiche->employe->entreprise->raison_sociale }}</div>
            <div class="label">Adresse</div>
            <div class="value">{{ $fiche->employe->entreprise->adresse ?? 'Conakry, Guinée' }}</div>
        </div>
        <div class="info-box" style="margin-left: 8%;">
            <div class="label">Salarié</div>
            <div class="value">{{ $fiche->employe->user->full_name }}</div>
            <div class="label">Matricule / Poste</div>
            <div class="value">{{ $fiche->employe->numero_matricule }} / {{ $fiche->employe->poste }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Désignation</th>
                <th class="text-right">Base</th>
                <th class="text-right">Taux</th>
                <th class="text-right">Retenu</th>
                <th class="text-right">Gain</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Salaire de base ({{ $fiche->contrat->type_contrat }})</td>
                <td class="text-right">{{ number_format($fiche->salaire_brut, 0, ',', ' ') }}</td>
                <td class="text-right">100%</td>
                <td class="text-right"></td>
                <td class="text-right font-bold">{{ number_format($fiche->salaire_brut, 0, ',', ' ') }}</td>
            </tr>
            <tr>
                <td>Cotisation Sociale (CNSS)</td>
                <td class="text-right">{{ number_format($fiche->salaire_brut, 0, ',', ' ') }}</td>
                <td class="text-right">5.00%</td>
                <td class="text-right" style="color: #d32f2f;">{{ number_format($fiche->cnss, 0, ',', ' ') }}</td>
                <td></td>
            </tr>
            <tr>
                <td>Contribution AGUIPE</td>
                <td class="text-right">{{ number_format($fiche->salaire_brut, 0, ',', ' ') }}</td>
                <td class="text-right">1.00%</td>
                <td class="text-right" style="color: #d32f2f;">{{ number_format($fiche->aguipe, 0, ',', ' ') }}</td>
                <td></td>
            </tr>
            @if($fiche->autres_deductions > 0)
            <tr>
                <td>Autres retenues (Avances/Divers)</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right" style="color: #d32f2f;">{{ number_format($fiche->autres_deductions, 0, ',', ' ') }}</td>
                <td></td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="net-box">
        <div class="net-label">NET À PAYER (GNF)</div>
        <div class="net-value">{{ number_format($fiche->salaire_net, 0, ',', ' ') }}</div>
    </div>

    <div class="qr-code">
        <img src="data:image/svg+xml;base64, {!! base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(80)->generate(route('login'))) !!} ">
        <div style="font-size: 8px; margin-top: 5px; color: #999;">Document authentifié par GuinéaJob<br>Scannez pour vérifier</div>
    </div>

    <div class="footer">
        GuinéaJob — La plateforme de référence pour la gestion des contrats de travail en République de Guinée.<br>
        Document généré le {{ now()->format('d/m/Y H:i') }} — Page 1/1
    </div>
</body>
</html>
