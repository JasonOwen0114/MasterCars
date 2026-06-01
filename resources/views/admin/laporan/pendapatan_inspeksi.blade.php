@extends('admin.layouts.laporan')

@section('content')

<div class="container py-4">

    <h3 class="fw-bold mb-4">
        Laporan Pendapatan Inspeksi
    </h3>

    
    <form method="GET" class="row g-3 mb-4">

    
        <div class="col-md-3">

            <input type="number"
                   name="tahun"
                   value="{{ $tahun }}"
                   class="form-control"
                   placeholder="Tahun">

        </div>
        <div class="col-md-auto">

            <button class="btn btn-dark">
                Filter
            </button>

        </div>

    </form>

    <div class="card shadow-sm mb-4">

        <div class="card-header fw-bold">
            Data Pendapatan Inspeksi
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered align-middle">

                <thead class="table-dark">

                    <tr>

                        @if($tipe == 'bulan')
                            <th>Bulan</th>
                        @else
                            <th>Tahun</th>
                        @endif

                        <th>Total Pendapatan</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $d)

                    <tr>

                        @if($tipe == 'bulan')

                            <td>
                                {{ Carbon\Carbon::create()->month($d->bulan)->format('F') }}
                            </td>

                        @else

                            <td>{{ $tahun }}</td>

                        @endif

                        <td>
                            Rp {{ number_format($d->total_pendapatan) }}
                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="2" class="text-center">
                            Data tidak ditemukan
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>



    <div class="card shadow-sm">

        <div class="card-header fw-bold">
            Grafik Pendapatan Inspeksi
        </div>

        <div class="card-body">

            <div style="height:350px">
                <canvas id="chart"></canvas>
            </div>

        </div>

    </div>

</div>


<script>

const ctx = document.getElementById('chart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels:

        @if($tipe == 'bulan')

            {!! json_encode(
                $data->map(function($item){
                    return Carbon\Carbon::create()->month($item->bulan)->format('F');
                })
            ) !!}

        @else

            ['{{ $tahun }}']

        @endif
        ,

        datasets: [{

            label: 'Pendapatan Inspeksi',

            data:
            {!! json_encode($data->pluck('total_pendapatan')) !!},

            tension: 0.3,
            fill: false

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false

    }

});

</script>

@endsection