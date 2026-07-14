@props([
    'id',
    'title',
    'type' => 'bar',
    'values' => [],
    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    'datasetLabel' => 'Data',
    'color' => '#9C3620',
])

@php
    $chartConfig = json_encode([
        'type' => $type,
        'labels' => $labels,
        'values' => $values,
        'datasetLabel' => $datasetLabel,
        'color' => $color,
    ], JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

<x-admin.card :title="$title">
    <canvas
        id="{{ $id }}"
        height="180"
        data-chart="{{ $chartConfig }}"
    ></canvas>
</x-admin.card>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (!window.Chart) return;

                document.querySelectorAll('[data-chart]').forEach((canvas) => {
                    const config = JSON.parse(canvas.dataset.chart);
                    const isDark = document.documentElement.classList.contains('dark');

                    new Chart(canvas, {
                        type: config.type,
                        data: {
                            labels: config.labels,
                            datasets: [{
                                label: config.datasetLabel,
                                data: config.values,
                                backgroundColor: config.color,
                                borderRadius: 6,
                            }],
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    labels: { color: isDark ? '#cbd5e1' : '#334155' },
                                },
                            },
                            scales: {
                                x: {
                                    ticks: { color: isDark ? '#94a3b8' : '#64748b' },
                                    grid: { color: isDark ? '#334155' : '#e2e8f0' },
                                },
                                y: {
                                    ticks: { color: isDark ? '#94a3b8' : '#64748b' },
                                    grid: { color: isDark ? '#334155' : '#e2e8f0' },
                                },
                            },
                        },
                    });
                });
            });
        </script>
    @endpush
@endonce
