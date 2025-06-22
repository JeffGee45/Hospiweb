<!DOCTYPE html>
<html>

<head>
    <title>Rapport sur les Statistiques des Patients</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h1,
        h2 {
            text-align: center;
            color: #333;
        }

        .container {
            width: 80%;
            margin: auto;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .stats-table th,
        .stats-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .stats-table th {
            background-color: #f2f2f2;
        }

        .total {
            font-size: 1.2em;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Rapport sur les Statistiques des Patients</h1>
    <p>Date du rapport : {{ date('d/m/Y') }}</p>

    <div class="container">
        <h2>Total des Patients : <span class="total">{{ $data['total'] }}</span></h2>

        <h3>Répartition par Sexe</h3>
        <table class="stats-table">
            <thead>
                <tr>
                    <th>Sexe</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['par_sexe'] as $sexe => $count)
                    <tr>
                        <td>{{ ucfirst($sexe) }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Répartition par Tranche d'Âge</h3>
        <table class="stats-table">
            <thead>
                <tr>
                    <th>Tranche d'Âge</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['par_age'] as $tranche => $count)
                    <tr>
                        <td>{{ $tranche }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
