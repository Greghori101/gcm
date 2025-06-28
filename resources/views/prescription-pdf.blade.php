<!DOCTYPE html>
<html lang="fr" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>Ordonnance #{{ $record->nb ?? '-' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            padding: 30px;
            direction: rtl;
        }
        .title {
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .section {
            margin-bottom: 15px;
        }
        .flex-between {
            display: flex;
            justify-content: space-between;
        }
        .left {
            text-align: left;
            direction: ltr;
        }
        .rtl {
            text-align: right;
        }
        .med-line {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #999;
            padding: 4px 0;
        }
    </style>
</head>

<body>

    <div class="flex-between">
        {{-- Doctor Info --}}
        <div class="section w-1/2 rtl">
            <div class="font-bold text-base">الدكتور مراد حمزة</div>
            <div>اختصاصي في الأمراض النفسية و العقلية</div>
            <div>و العلاج النفسي</div>
            <div>تخطيط الدماغ الكهربائي</div>
            <div class="mt-2">Cité des 800 logts N°523, BATNA</div>
            <div>Tel: {{ $record->doctor->user->phone_number[0] ?? '-' }}</div>
            <div>Email: {{ $record->doctor->user->email ?? '-' }}</div>
            <div>N° ordre: {{ $record->doctor->national_order_number ?? '-' }}</div>
        </div>

        {{-- Patient + Date Info --}}
        <div class="section w-1/2 left">
            <div>
                Batna, le
                {{ $record->date ? \Carbon\Carbon::parse($record->date)->format('d/m/Y') : '-' }}
            </div>
            <div>
                Âge:
                {{ optional(optional($record->patient)->user)?->birthdate
                    ? \Carbon\Carbon::parse($record->patient->user->birthdate)->age . ' ans'
                    : '-' }}
            </div>
            <div>
                Sexe:
                {{ ucfirst($record->patient->user->gender ?? '-') }}
            </div>
            <div>QSP 3 MOIS</div>
        </div>
    </div>

    {{-- Prescription Title --}}
    <div class="title">ORDONNANCE</div>

    {{-- Patient Name --}}
    <div class="section rtl">
        <div>
            Nom:
            <span class="uppercase font-bold">{{ $record->patient->user->lastname ?? '-' }}</span>
        </div>
        <div>
            Prénom:
            <span class="capitalize">{{ $record->patient->user->firstname ?? '-' }}</span>
        </div>
    </div>

    {{-- Medication Lines --}}
    <div class="section">
        @foreach($record->prescriptionMedicines ?? [] as $pm)
            <div class="med-line">
                <div>
                    {{ $pm->medicine->name ?? '-' }}
                    {{ $pm->medicine->dosage ?? '' }}
                    {{ $pm->medicine->form ?? '' }}
                </div>
                <div class="left">
                    {{ $pm->posology ?? '-' }}
                    {{ ($pm->is_qsp ?? false) ? 'QSP ' . ($pm->pivot->periodicity ?? '3 MOIS') : '' }}
                </div>
            </div>
        @endforeach
    </div>

    {{-- Signature --}}
    <div class="section left mt-10">
        <div class="font-bold">Dr. {{ $record->doctor->user->lastname ?? '-' }}</div>
        <div class="mt-6">__________________________</div>
    </div>

    {{-- Pharmacy Stamp --}}
    <div class="section left mt-10 text-xs">
        <div class="font-bold uppercase">PHARMACIE MAARIF</div>
        <div>Batna</div>
        <div>
            Tél: {{ $record->doctor->user->phone_number[0] ?? '-' }}
        </div>
    </div>

</body>
</html>
