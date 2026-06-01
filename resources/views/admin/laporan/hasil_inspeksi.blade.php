@extends('admin.layouts.laporan')

@section('content')

<h3 class="mb-4 fw-bold">
    Laporan Hasil Inspeksi
</h3>


<form method="GET" class="row g-3 mb-4">

    {{-- MERK --}}
    <div class="col-md-3">

        <select id="merk"
                name="merk"
                autocomplete="off">

            <option value="">Semua Merk</option>

            @foreach($merks as $m)

                <option value="{{ $m }}"
                    {{ $merk == $m ? 'selected' : '' }}>

                    {{ $m }}

                </option>

            @endforeach

        </select>

    </div>



    {{-- GRADE --}}
    <div class="col-md-3">

        <select id="grade"
                name="grade"
                autocomplete="off">

            <option value="">Semua Grade</option>

            <option value="A"
                {{ $grade == 'A' ? 'selected' : '' }}>
                Grade A
            </option>

            <option value="B"
                {{ $grade == 'B' ? 'selected' : '' }}>
                Grade B
            </option>

            <option value="C"
                {{ $grade == 'C' ? 'selected' : '' }}>
                Grade C
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

    <div class="card-body table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="table-dark">

                <tr>

                    <th>Mobil</th>
                    <th>Merk</th>
                    <th>Eksterior</th>
                    <th>Interior</th>
                    <th>Mesin</th>
                    <th>Kelengkapan</th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $d)

                <tr>

                    <td>{{ $d->nama_mobil }}</td>

                    <td>{{ $d->merk }}</td>

                    <td>
                        <span class="badge bg-success">
                            {{ $d->grade_eksterior }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-primary">
                            {{ $d->grade_interior }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-warning text-dark">
                            {{ $d->grade_mesin }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-dark">
                            {{ $d->grade_kelengkapan }}
                        </span>
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">
                        Data tidak ditemukan
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>



      
        <div class="mt-5">

            <canvas id="chart"></canvas>

        </div>

    </div>

</div>




<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>



<script>

document.addEventListener('DOMContentLoaded', function () {



    new TomSelect('#merk', {

        create: false,

        persist: false,

        maxOptions: 500,

        placeholder: 'Cari merk mobil...',

        allowEmptyOption: true,

        plugins: ['dropdown_input'],

        sortField: [
            {
                field: 'text',
                direction: 'asc'
            }
        ]

    });



 

    new TomSelect('#grade', {

        create: false,

        persist: false,

        placeholder: 'Pilih grade...',

        allowEmptyOption: true

    });






    const ctx = document.getElementById('chart');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: ['Eksterior', 'Interior', 'Mesin', 'Kelengkapan'],

            datasets: [{

                label: 'Jumlah Grade A',

                data: [

                    {{ $data->where('grade_eksterior', 'A')->count() }},
                    {{ $data->where('grade_interior', 'A')->count() }},
                    {{ $data->where('grade_mesin', 'A')->count() }},
                    {{ $data->where('grade_kelengkapan', 'A')->count() }}

                ]

            }]

        }

    });

});

</script>

@endsection