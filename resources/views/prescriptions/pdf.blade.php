<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Prescription médicale' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0;
            color: #7f8c8d;
        }
        .patient-info {
            margin-bottom: 30px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .patient-info h2 {
            margin-top: 0;
            color: #2c3e50;
            font-size: 18px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
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
            color: #7f8c8d;
        }
        .prescription-details {
            margin: 30px 0;
        }
        .prescription-details h2 {
            color: #2c3e50;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .medicaments-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .medicaments-table th, .medicaments-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .medicaments-table th {
            background-color: #f2f2f2;
            color: #2c3e50;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 300px;
            margin: 40px 0 5px auto;
            display: block;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .prescription-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        .prescription-date {
            text-align: right;
        }
        .prescription-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-en_attente {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-prete {
            background-color: #d4edda;
            color: #155724;
        }
        .status-livree {
            background-color: #cce5ff;
            color: #004085;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PRESCRIPTION MÉDICALE</h1>
        <p>Hôpital HOSPIWEB</p>
        <p>123 Rue de l'Hôpital, 75000 Paris - Tél: 01 23 45 67 89</p>
    </div>

    <div class="patient-info">
        <h2>Informations du patient</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nom complet:</span> 
                <span>{{ $consultation->patient->nom_complet ?? 'Non spécifié' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Date de naissance:</span> 
                <span>{{ $consultation->patient->date_naissance ? $consultation->patient->date_naissance->format('d/m/Y') : 'Non spécifiée' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">N° dossier:</span> 
                <span>{{ $consultation->patient->numero_dossier ?? 'Non spécifié' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Âge:</span> 
                <span>{{ $consultation->patient->age ?? 'N/A' }} ans</span>
            </div>
        </div>
    </div>

    <div class="prescription-header">
        <div>
            <div><strong>Médecin prescripteur:</strong> Dr. {{ $prescription->medecin->name ?? 'Non spécifié' }}</div>
            <div><strong>Spécialité:</strong> {{ $prescription->medecin->specialite ?? 'Non spécifiée' }}</div>
        </div>
        <div class="prescription-date">
            <div><strong>Date de prescription:</strong> {{ $prescription->date_prescription->format('d/m/Y') }}</div>
            <div><strong>Date d'expiration:</strong> {{ $prescription->date_expiration->format('d/m/Y') }}</div>
            <div>
                <strong>Statut:</strong> 
                <span class="prescription-status status-{{ $prescription->statut }}">
                    {{ ucfirst(str_replace('_', ' ', $prescription->statut)) }}
                </span>
            </div>
        </div>
    </div>

    <div class="prescription-details">
        <h2>Traitement prescrit</h2>
        
        @if($prescription->medicaments->isNotEmpty())
            <table class="medicaments-table">
                <thead>
                    <tr>
                        <th>Médicament</th>
                        <th>Posologie</th>
                        <th>Durée</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescription->medicaments as $medicament)
                    <tr>
                        <td>
                            <strong>{{ $medicament->nom_medicament }}</strong><br>
                            <em>{{ $medicament->dosage }}</em>
                        </td>
                        <td>
                            {{ $medicament->frequence }}
                            @if($medicament->instructions)
                                <br><small><em>{{ $medicament->instructions }}</em></small>
                            @endif
                        </td>
                        <td>{{ $medicament->duree }}</td>
                        <td>{{ $medicament->quantite }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Aucun médicament prescrit.</p>
        @endif
    </div>

    @if($prescription->remarques)
    <div class="prescription-notes">
        <h3>Instructions supplémentaires</h3>
        <p>{!! nl2br(e($prescription->remarques)) !!}</p>
    </div>
    @endif

    <div class="signature">
        <span class="signature-line"></span>
        <div>Signature et cachet du médecin</div>
        <div><strong>Dr. {{ $prescription->medecin->name ?? '' }}</strong></div>
    </div>

    <div class="footer">
        <p>Hôpital HOSPIWEB - 123 Rue de l'Hôpital, 75000 Paris - Tél: 01 23 45 67 89</p>
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
</body>
</html>
