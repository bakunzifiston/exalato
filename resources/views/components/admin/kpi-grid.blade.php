@props(['kpis' => []])

@php
    $tones = ['maroon', 'rust', 'orange', 'default'];
@endphp

<div {{ $attributes->class('mb-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-4') }}>
    @foreach ($kpis as $index => $kpi)
        <x-admin.stat-card
            :label="$kpi['label']"
            :value="$kpi['value']"
            :description="$kpi['description'] ?? ''"
            :tone="$tones[$index % count($tones)]"
        />
    @endforeach
</div>
