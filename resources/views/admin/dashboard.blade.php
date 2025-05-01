@extends('admin.layout.main')

@section('title', 'Dashboard Admin')

@section('content')

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php
            $cards = [
                ['title' => 'Data Mahasiswa', 'value' => 120, 'color' => 'bg-blue-100 text-blue-800'],
                ['title' => 'Data Dosen', 'value' => 30, 'color' => 'bg-green-100 text-green-800'],
                ['title' => 'Penjadwalan Sempro', 'value' => 15, 'color' => 'bg-yellow-100 text-yellow-800'],
                ['title' => 'Hasil', 'value' => '80%', 'color' => 'bg-red-100 text-red-800'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="rounded-2xl p-6 shadow hover:shadow-md transition duration-300 {{ $card['color'] }} bg-opacity-50">
                <h2 class="text-lg font-semibold mb-2">{{ $card['title'] }}</h2>
                <p class="text-3xl font-bold">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Statistik</h2>
        <canvas id="myChart" class="w-full h-64"></canvas>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Mahasiswa', 'Dosen', 'Sempro', 'Hasil'],
            datasets: [{
                label: 'Jumlah',
                data: [120, 30, 15, 80],
                backgroundColor: ['#3B82F6', '#10B981', '#FBBF24', '#EF4444'],
                borderRadius: 10,
                barThickness: 40,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#4B5563'
                    }
                },
                x: {
                    ticks: {
                        color: '#4B5563'
                    }
                }
            }
        }
    });
</script>
@endpush
