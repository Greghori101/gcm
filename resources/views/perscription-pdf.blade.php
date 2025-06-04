<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ordonnance #{{ $record->nb }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .info-section {
            margin-bottom: 15px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .medicines-table {
            width: 100%;
            border-collapse: collapse;
        }
        .medicines-table th, .medicines-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Ordonnance Médicale</h2>
        <p>Numéro : <strong>{{ $record->nb }}</strong></p>
        <p>Date : <strong>{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</strong></p>
    </div>

    <div class="info-section">
        <div class="section-title">Informations du Patient</div>
        <p>Nom : <strong>{{ $record->patient->user->lastname }} {{ $record->patient->user->firstname }}</strong></p>
        <p>Date de naissance : <strong>{{ \Carbon\Carbon::parse($record->patient->user->birthdate)->format('d/m/Y') }}</strong></p>
        <p>Adresse : 
            <strong>
                {{ optional($record->patient->address)->line1 }},
                {{ optional($record->patient->address)->city }},
                {{ optional($record->patient->address)->zip_code }}
            </strong>
        </p>
    </div>

    <div class="info-section">
        <div class="section-title">But de l'ordonnance</div>
        <p>{{ $record->purpose }}</p>
    </div>

    <div class="info-section">
        <div class="section-title">Médicaments Prescrits</div>
        <table class="medicines-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Quantité</th>
                    <th>Unité</th>
                    <th>QSP</th>
                    <th>Posologie</th>
                    <th>Conditions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($record->prescriptionMedicines as $pm)
                    <tr>
                        <td>{{ $pm->medicine->name ?? '-' }}</td>
                        <td>{{ $pm->is_qsp ? 'QSP' : $pm->quantity }}</td>
                        <td>{{ $pm->unit }}</td>
                        <td>{{ $pm->is_qsp ? 'Oui' : 'Non' }}</td>
                        <td>{{ $pm->posology }}</td>
                        <td>{{ $pm->conditions }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Signature du médecin</p>
        <p>_________________________</p>
    </div>

</body>
</html>
