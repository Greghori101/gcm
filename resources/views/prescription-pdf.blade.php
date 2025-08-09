<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Ordonnance #{{ $record->nb ?? '-' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            font-size: 14px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px;
        }

        .doctor-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .date-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
            gap: 4px;
        }

        .patient-info {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-top: 16px;
            padding: 24px;
        }

        .prescription-title {
            font-size: 1.25rem;
            text-transform: uppercase;
            text-decoration: underline;
            text-align: center;
            width: 100%;
            margin: 16px 0;
        }

        .medication-list {
            display: flex;
            flex-direction: column;
            align-items: start;
            margin-top: 16px;
            gap: 8px;
            padding: 32px;
        }

        .medication-item {
            margin-bottom: 12px;
            width: 100%;
        }

        .medication-first-line {
            display: flex;
            flex-grow: 1;
            align-items: center;
            justify-content: space-between;
        }

        .medication-second-line {
            display: flex;
            gap: 2px;
            flex-grow: 1;
            align-items: center;
            justify-content: center;
        }

        .medication-name {
            font-weight: bold;
        }

        .medication-separator {
            flex-grow: 1;
            border-top: 1px solid #000;
            margin: 0 8px;
        }

        .patient-separator {
            flex-grow: 1;
            margin: 0 8px;
            border-top: 2px dotted #000;
        }
    </style>
</head>

<body>
    <div class="header">
        {{-- Doctor Info --}}

        <div class="doctor-info" style="font-weight: bold;">
            <div>{{ __('interface.dr') }}:
                {{ $record->doctor?->user?->lastname . ' ' . $record->doctor?->user?->firstname }}
            </div>
            <div>{{ __('interface.specialty') }}: {{ $record->doctor?->specialty }}</div>
            <div> {{ $record->doctor?->address?->formatted_address }}</div>
            <div>{{ __('interface.order_number') }}: {{ $record->doctor?->national_order_number ?? '-' }}</div>
        </div>

        {{-- Date Info --}}
        <div class="date-info">
            <span style="font-weight: bold;">
                {{ __('interface.date') }}
                {{ $record->date ? \Carbon\Carbon::parse($record->date)->format('d/m/Y') : '-' }}
            </span>
            <span>
                {{ __('interface.phone_number') }}
                @php
                    $phones = $record->doctor?->user?->phone_number;
                    // Try to decode as JSON if it's a string
                    if (is_string($phones)) {
                        $decoded = json_decode($phones, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $phones = $decoded;
                        } else {
                            $phones = empty($phones) ? [] : [$phones];
                        }
                    } elseif (!is_array($phones)) {
                        $phones = empty($phones) ? [] : [$phones];
                    }
                @endphp
                @foreach ($phones as $phone)
                    <div>{{ $phone }}</div>
                @endforeach
            </span>
        </div>
    </div>
    {{-- Patient Name --}}
    <div class="patient-info">
        <span>{{ __('interface.lastname') }}: {{ $record->patient->user?->lastname }}</span>
        <span class="patient-separator"></span>

        <span>{{ __('interface.firstname') }}: {{ $record->patient->user?->firstname }}</span>
        <span class="patient-separator"></span>

        <span>{{ __('interface.age') }}: {{ $record->patient->user?->birthdate }}</span>
    </div>
    {{-- prescription title --}}
    <div class="prescription-title">
        {{ __('interface.prescription_title') }}
    </div>

    {{-- Medication Lines --}}
    <ol class="medication-list">
        @foreach ($record->prescriptionMedicines ?? [] as $pm)
            <li class="medication-item">
                <div class="medication-first-line">
                    <span class="medication-name">
                        {{ $pm->medicine->brand ?? ($pm->medicine->name ?? '-') }} {{ $pm->form ?? '-' }}
                        <span style="text-transform:lowercase">{{ $pm->dosage ?? '-' }}</span>
                    </span>
                    <span class="medication-separator"></span>
                    <span>
                        {{ $pm->is_qsp ? 'QSP 0' . $pm->quantity . ' ' . $pm->unit : '0' . $pm->quantity . ' ' . $pm->unit }}
                    </span>
                </div>
                <div class="medication-second-line">
                    <span>{{ '0' . $pm->qte . ' ' . $pm->form . ' X ' . $pm->frequency . ' / ' . $pm->periodicity }}</span>
                    <span>{{ $pm->conditions ? ' ;' . $pm->conditions : '' }}</span>
                </div>
            </li>
        @endforeach
        </ul>
</body>

</html>
