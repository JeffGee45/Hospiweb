<!DOCTYPE html>
<html>
<head>
    <title>Rapport des Consultations par Médecin</title>
    <style>
        body { font-family: sans-serif; }
        h1 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Rapport des Consultations par Médecin</h1>
    <p>Date du rapport : {{ date('d/m/Y') }}</p>
    <table>
        <thead>
            <tr>
                <th>Médecin</th>
                <th>Nombre de Consultations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $medecin)
                <tr>
                    <td>Dr. {{ $medecin->prenom }} {{ $medecin->nom }}</td>
                    <td>{{ $medecin->consultations_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
