@extends('admin.layouts.laporan')

@section('title', 'Laporan Kinerja Staff')

@section('content')

<h3 class="fw-bold mb-4">
    Laporan Kinerja Staff
</h3>



<form method="GET" class="row g-3 mb-4">

   
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



  
    <div class="col-md-2">

        <input type="number"
               name="tahun"
               class="form-control"
               value="{{ $tahun }}"
               placeholder="Tahun">

    </div>



   
    <div class="col-md-3">

        <select name="sort" class="form-select">

            <option value="desc"
                {{ $sort == 'desc' ? 'selected' : '' }}>
                Inspeksi Terbanyak
            </option>

            <option value="asc"
                {{ $sort == 'asc' ? 'selected' : '' }}>
                Inspeksi Tersedikit
            </option>

        </select>

    </div>



  
    <div class="col-md-auto">

        <button class="btn btn-dark">
            Filter
        </button>

    </div>

</form>




<div class="card shadow-sm">

    <div class="card-header fw-bold">
        Data Kinerja Staff
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="table-dark">

                <tr>

                    <th width="80">No</th>
                    <th>Nama Staff</th>
                    <th>Total Inspeksi</th>
        

                </tr>

            </thead>

            <tbody>

                @forelse($data as $index => $d)

                <tr>

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $d->nama }}
                    </td>

                    <td>
                        {{ $d->total_inspeksi }}
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



        <div class="d-flex justify-content-center mt-5">

            <div style="width:700px; height:350px;">

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

            labels: {!! json_encode($data->pluck('nama')) !!},

            datasets: [{

                label: 'Total Inspeksi',

                data: {!! json_encode($data->pluck('total_inspeksi')) !!}

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    display: true

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