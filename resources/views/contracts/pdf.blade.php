<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contrat de Travail - {{ $contract->numero_contrat }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; font-size: 12px; margin: 0; padding: 0; }
        .header { background-color: #0F6E56; color: white; padding: 40px; text-align: center; }
        .republique { text-transform: uppercase; letter-spacing: 5px; font-size: 8px; font-weight: bold; margin-bottom: 5px; opacity: 0.8; }
        .titre { font-size: 24px; font-weight: bold; margin: 0; }
        .numero { font-family: monospace; font-size: 10px; margin-top: 5px; opacity: 0.7; }
        
        .section { padding: 30px 50px; }
        .parties { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .partie-box { width: 50%; padding: 15px; border: 1px solid #eee; background-color: #f9f9f9; }
        .label-mini { font-size: 8px; font-weight: bold; color: #D4AF37; text-transform: uppercase; margin-bottom: 5px; }
        .nom-gras { font-size: 14px; font-weight: bold; }
        
        .article-titre { font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #D4AF37; display: inline-block; padding-bottom: 3px; margin-bottom: 15px; margin-top: 25px; }
        
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table td { padding: 10px; border: 1px solid #f0f0f0; }
        .data-label { background-color: #fafafa; font-weight: bold; font-size: 9px; text-transform: uppercase; color: #999; width: 30%; }
        
        .salaire-box { background-color: #1a1a1a; color: white; padding: 20px; border-radius: 10px; border-bottom: 4px solid #D4AF37; margin-top: 10px; }
        .salaire-montant { font-size: 22px; font-weight: bold; color: #D4AF37; }
        
        .clauses { font-style: italic; color: #555; background-color: #fcfcfc; padding: 15px; border-left: 3px solid #0F6E56; font-size: 11px; }
        
        .signatures { margin-top: 50px; width: 100%; }
        .sign-col { width: 50%; vertical-align: top; }
        .sign-box { border: 1px dashed #ccc; padding: 15px; height: 120px; position: relative; margin: 10px; }
        .sign-info { font-size: 8px; color: #777; margin-top: 5px; }
        .stamp { color: #0F6E56; font-weight: bold; font-size: 10px; border: 2px solid #0F6E56; padding: 5px; display: inline-block; transform: rotate(-5deg); margin-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="republique">République de Guinée</div>
        <h1 class="titre">CONTRAT DE TRAVAIL</h1>
        <div class="numero">N° {{ $contract->numero_contrat }} — {{ strtoupper($contract->type_contrat) }}</div>
    </div>

    <div class="section">
        <table class="parties">
            <tr>
                <td class="partie-box">
                    <div class="label-mini">L'Employeur</div>
                    <div class="nom-gras">{{ $contract->entreprise->raison_sociale }}</div>
                    <div style="font-size: 10px; color: #666;">{{ $contract->entreprise->adresse }}</div>
                </td>
                <td class="partie-box" style="background-color: white;">
                    <div class="label-mini">L'Employé</div>
                    <div class="nom-gras">{{ $contract->employe->user->full_name }}</div>
                    <div style="font-size: 10px; color: #666;">{{ $contract->employe->poste }}</div>
                    <div style="font-size: 9px; margin-top: 3px;">MATRICULE : {{ $contract->employe->numero_matricule }}</div>
                </td>
            </tr>
        </table>

        <div class="article-titre">Article 1 : Engagement & Durée</div>
        <table class="data-table">
            <tr>
                <td class="data-label">Date d'effet</td>
                <td>{{ $contract->date_debut->format('d/m/Y') }}</td>
            </tr>
            @if($contract->date_fin)
            <tr>
                <td class="data-label">Échéance du contrat</td>
                <td>{{ $contract->date_fin->format('d/m/Y') }}</td>
            </tr>
            @endif
            <tr>
                <td class="data-label">Période d'essai</td>
                <td>{{ $contract->periode_essai ?? 'Aucune' }}</td>
            </tr>
        </table>

        <div class="article-titre">Article 2 : Rémunération & Avantages</div>
        <div class="salaire-box">
            <div style="font-size: 8px; text-transform: uppercase; letter-spacing: 1px; color: #aaa;">Salaire Mensuel Brut</div>
            <div class="salaire-montant">{{ number_format($contract->salaire_mensuel_brut, 0, ',', ' ') }} <span style="font-size: 10px; color: #aaa; font-weight: normal;">GNF/Mois</span></div>
            @if($contract->avantages)
                <div style="margin-top: 10px; font-size: 9px;">
                    @foreach($contract->avantages as $avantage)
                        <span style="background: rgba(255,255,255,0.1); padding: 2px 6px; margin-right: 5px; border-radius: 3px;">{{ $avantage }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        @if($contract->clauses_specifiques)
        <div class="article-titre">Article 3 : Clauses Particulières</div>
        <div class="clauses">
            {{ $contract->clauses_specifiques }}
        </div>
        @endif

        <div class="article-titre">Signatures & Validations Électroniques</div>
        <table class="signatures">
            <tr>
                <td class="sign-col">
                    <div style="font-size: 9px; font-weight: bold; margin-bottom: 10px;">Pour l'Employeur</div>
                    <div class="sign-box">
                        @if($contract->signed_at_employer)
                            <div class="stamp">SIGNÉ NUMÉRIQUEMENT</div>
                            <div class="sign-info">
                                Date : {{ $contract->signed_at_employer->format('d/m/Y H:i') }}<br>
                                IP : {{ $contract->ip_employer }}
                            </div>
                        @else
                            <div style="color: #ccc; margin-top: 40px; text-align: center;">Signature en attente</div>
                        @endif
                    </div>
                </td>
                <td class="sign-col">
                    <div style="font-size: 9px; font-weight: bold; margin-bottom: 10px;">Pour l'Employé</div>
                    <div class="sign-box">
                        @if($contract->signed_at_employee)
                            <div class="stamp">APPROUVÉ & SIGNÉ</div>
                            <div class="sign-info">
                                Date : {{ $contract->signed_at_employee->format('d/m/Y H:i') }}<br>
                                IP : {{ $contract->ip_employee }}
                            </div>
                        @else
                            <div style="color: #ccc; margin-top: 40px; text-align: center;">Signature en attente</div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
        
        <table style="width: 100%; margin-top: 40px;">
            <tr>
                <td style="width: 80%; vertical-align: bottom; font-size: 8px; color: #aaa;">
                    Ce document a été généré par GuinéaJob.<br>La signature électronique est reconnue conformément à la loi en vigueur en République de Guinée.<br>
                    <strong>ID Contrat : {{ $contract->id }}-{{ strtoupper(substr(md5($contract->numero_contrat), 0, 8)) }}</strong>
                </td>
                <td style="width: 20%; text-align: right;">
                    <!-- QR Code de vérification généré en SVG (encodé en Base64 pour DomPDF) -->
                    <img src="data:image/svg+xml;base64,{{ base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate(url('/'))) }}" alt="QR Code" width="80" height="80">
                    <div style="font-size: 6px; color: #777; margin-top: 2px;">SCAN POUR VÉRIFIER</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
