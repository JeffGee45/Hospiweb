<!DOCTYPE html>
<html>
<head>
    <title>Rapport des Médicaments les Plus Prescrits</title>
    <style>
        body { font-family: sans-serif; }
        h1 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Top 20 des Médicaments les Plus Prescrits</h1>
    <p>Date du rapport : {{ date('d/m/Y') }}</p>
    <table>
        <thead>
            <tr>
                <th>Médicament</th>
                <th>Nombre de Prescriptions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $medicament)
                <tr>
                    <td>{{ $medicament->nom_medicament }}</td>
                    <td>{{ $medicament->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
