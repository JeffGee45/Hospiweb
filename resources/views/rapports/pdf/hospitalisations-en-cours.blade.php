<!DOCTYPE html>
<html>

<head>
    <title>Rapport des Hospitalisations en Cours</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Rapport des Hospitalisations en Cours</h1>
    <p>Date du rapport : {{ date('d/m/Y') }}</p>
    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Date d'admission</th>
                <th>Motif</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $hospitalisation)
                <tr>
                    <td>{{ $hospitalisation->patient->prenom }} {{ $hospitalisation->patient->nom }}</td>
                    <td>{{ $hospitalisation->date_admission->format('d/m/Y') }}</td>
                    <td>{{ $hospitalisation->motif }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Aucune hospitalisation en cours.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
