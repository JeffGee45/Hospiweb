<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordonnance #{{ $ordonnance->id }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 15mm;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 5px 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
            font-size: 12px;
        }
        .info-block {
            margin-bottom: 20px;
        }
        .info-block h2 {
            font-size: 14px;
            margin: 10px 0 5px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .info-item {
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            min-width: 120px;
        }
        .medicaments {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .medicaments th {
            background-color: #f5f5f5;
            text-align: left;
            padding: 5px;
            border: 1px solid #ddd;
        }
        .medicaments td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .signature {
            margin-top: 40px;
            text-align: right;
        }
        .signature-line {
            display: inline-block;
            width: 200px;
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 5px;
            text-align: center;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
            padding: 5px;
            border-top: 1px solid #ddd;
        }
        .logo {
            max-width: 150px;
            margin: 0 auto;
            display: block;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            opacity: 0.1;
            z-index: -1;
            white-space: nowrap;
            font-weight: bold;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="watermark">HOSPIWEB - COPIE NON VALABLE POUR LA SECURITE SOCIALE</div>
    
    <div class="header">
        <h1>ORDONNANCE MÉDICALE</h1>
        <p>Hôpital HOSPIWEB - {{ config('app.name') }}</p>
        <p>{{ config('app.address') }} - Tél: {{ config('app.phone') }}</p>
    </div>

    <div class="info-grid">
        <div class="info-block">
            <h2>Informations du patient</h2>
            <div class="info-item">
                <span class="info-label">Nom et prénom :</span>
                {{ $ordonnance->patient->prenom }} {{ $ordonnance->patient->nom }}
            </div>
            <div class="info-item">
                <span class="info-label">Date de naissance :</span>
                {{ $ordonnance->patient->date_naissance->format('d/m/Y') }}
                ({{ $ordonnance->patient->date_naissance->age }} ans)
            </div>
            <div class="info-item">
                <span class="info-label">Téléphone :</span>
                {{ $ordonnance->patient->telephone ?? 'Non renseigné' }}
            </div>
            <div class="info-item">
                <span class="info-label">N° Sécurité Sociale :</span>
                {{ $ordonnance->patient->numero_securite_sociale ?? 'Non renseigné' }}
            </div>
        </div>

        <div class="info-block">
            <h2>Informations médicales</h2>
            <div class="info-item">
                <span class="info-label">Date de l'ordonnance :</span>
                {{ $ordonnance->date_ordonnance->format('d/m/Y') }}
            </div>
            <div class="info-item">
                <span class="info-label">Médecin prescripteur :</span>
                Dr. {{ $ordonnance->medecin->prenom }} {{ $ordonnance->medecin->nom }}
            </div>
            @if($ordonnance->consultation)
            <div class="info-item">
                <span class="info-label">Consultation du :</span>
                {{ $ordonnance->consultation->date_consultation->format('d/m/Y H:i') }}
            </div>
            @endif
            <div class="info-item">
                <span class="info-label">N° d'ordonnance :</span>
                {{ $ordonnance->id }}
            </div>
        </div>
    </div>

    <div class="info-block">
        <h2>Médicaments prescrits</h2>
        <table class="medicaments">
            <thead>
                <tr>
                    <th>Médicament</th>
                    <th>Posologie</th>
                    <th>Durée</th>
                    <th>Instructions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ordonnance->medicaments as $medicament)
                <tr>
                    <td>{{ $medicament->nom }}</td>
                    <td>{{ $medicament->posologie }}</td>
                    <td>{{ $medicament->duree }}</td>
                    <td>{{ $medicament->instructions ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($ordonnance->commentaire)
    <div class="info-block">
        <h2>Commentaires et recommandations</h2>
        <p style="white-space: pre-line;">{{ $ordonnance->commentaire }}</p>
    </div>
    @endif

    <div class="signature">
        <div class="signature-line">
            Fait à {{ config('app.city') }}, le {{ now()->format('d/m/Y') }}
        </div>
        <div class="signature-line" style="margin-top: 40px;">
            Signature et cachet du médecin
        </div>
    </div>

    <div class="footer">
        Document généré par {{ config('app.name') }} - {{ config('app.url') }} - Le {{ now()->format('d/m/Y à H:i') }}
    </div>
</body>
</html>
