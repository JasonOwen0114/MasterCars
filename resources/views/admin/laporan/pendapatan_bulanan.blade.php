@extends('admin.layouts.laporan')

@section('content')

<div class="container py-4">

    <h3 class="mb-4 fw-bold">
        Laporan Pendapatan Bulanan
    </h3>



    {{-- FILTER --}}
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




    <div class="card shadow-sm">

        <div class="card-header fw-bold">
            Data Pendapatan
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>Bulan</th>
                        <th>Komisi</th>
                        <th>Jasa Inspeksi</th>
                        <th>Total Pendapatan</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($data as $d)

                    <tr>

                        <td>

                            {{ Carbon\Carbon::create()->month($d->bulan)->translatedFormat('F') }}

                        </td>

                        <td>

                            Rp {{ number_format($d->komisi) }}

                        </td>

                        <td>

                            Rp {{ number_format($d->jasa) }}

                        </td>

                        <td class="fw-bold text-success">

                            Rp {{ number_format($d->total) }}

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>




            {{-- CHART --}}
            <div class="d-flex justify-content-center mt-5">

                <div style="width: 850px; height: 400px;">

                    <canvas id="chartPendapatan"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>




<script>

document.addEventListener('DOMContentLoaded', function(){

    const ctx = document.getElementById('chartPendapatan');

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: {!! json_encode(
                collect($data)->map(function($d){

                    return Carbon\Carbon::create()
                        ->month($d->bulan)
                        ->translatedFormat('F');

                })
            ) !!},

            datasets: [

                {

                    label: 'Komisi',

                    data: {!! json_encode(
                        collect($data)->pluck('komisi')
                    ) !!},

                    tension: 0.3

                },

                {

                    label: 'Jasa Inspeksi',

                    data: {!! json_encode(
                        collect($data)->pluck('jasa')
                    ) !!},

                    tension: 0.3

                },

                {

                    label: 'Total Pendapatan',

                    data: {!! json_encode(
                        collect($data)->pluck('total')
                    ) !!},

                    tension: 0.3

                }

            ]

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