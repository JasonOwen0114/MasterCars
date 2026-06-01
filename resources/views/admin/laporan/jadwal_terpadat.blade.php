@extends('admin.layouts.laporan')

@section('content')

<h3 class="mb-4 fw-bold">
    Laporan Jadwal Inspeksi Terpadat
</h3>



{{-- FILTER --}}
<form method="GET" class="row g-3 mb-4">

    {{-- BULAN --}}
    <div class="col-md-3">

        <select name="bulan" class="form-select">

            <option value="">
                Semua Bulan
            </option>

            @for($i=1; $i<=12; $i++)

                <option value="{{ $i }}"
                    {{ $bulan == $i ? 'selected' : '' }}>

                    {{ Carbon\Carbon::create()->month($i)->translatedFormat('F') }}

                </option>

            @endfor

        </select>

    </div>



    {{-- TAHUN --}}
    <div class="col-md-3">

        <input type="number"
               name="tahun"
               value="{{ $tahun }}"
               class="form-control"
               placeholder="Tahun">

    </div>



    {{-- SORT --}}
    <div class="col-md-3">

        <select name="sort" class="form-select">

            <option value="desc"
                {{ $sort == 'desc' ? 'selected' : '' }}>

                Jadwal Terpadat

            </option>

            <option value="asc"
                {{ $sort == 'asc' ? 'selected' : '' }}>

                Jadwal Tersedikit

            </option>

        </select>

    </div>



    {{-- BUTTON --}}
    <div class="col-md-auto">

        <button class="btn btn-dark">
            Filter
        </button>

    </div>

</form>




<div class="card shadow-sm">

    <div class="card-header fw-bold">
        Data Jadwal Inspeksi
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="table-dark">

                <tr>

                    <th width="80">No</th>
                    <th>Tanggal Jadwal</th>
                    <th>Total Jadwal</th>
           

                </tr>

            </thead>

            <tbody>

                @forelse($data as $index => $d)

                <tr>

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ Carbon\Carbon::parse($d->jadwal)->translatedFormat('d F Y') }}
                    </td>

                    <td>
                        {{ $d->total_jadwal }}
                    </td>



                </tr>

                @empty

                <tr>

                    <td colspan="4" class="text-center">
                        Data tidak ditemukan
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>




        {{-- CHART --}}
        <div class="d-flex justify-content-center mt-5">

            <div style="width:850px; height:400px;">

                <canvas id="chart"></canvas>

            </div>

        </div>

    </div>

</div>




<script>

document.addEventListener('DOMContentLoaded', function(){

    const ctx = document.getElementById('chart');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: {!! json_encode(
                $data->map(function($d){

                    return Carbon\Carbon::parse($d->jadwal)
                        ->translatedFormat('d M');

                })
            ) !!},

            datasets: [{

                label: 'Jumlah Jadwal',

                data: {!! json_encode(
                    $data->pluck('total_jadwal')
                ) !!}

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    position: 'bottom'

                }

            },

            scales: {

                y: {

                    beginAtZero: true

                }

            }

        }

    });

});

</script>

@endsection