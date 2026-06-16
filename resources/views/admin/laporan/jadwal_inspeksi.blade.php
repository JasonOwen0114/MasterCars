@extends('admin.layouts.laporan')

@section('content')

<h3 class="mb-4 fw-bold">
    Laporan Jadwal Inspeksi
</h3>

<form method="GET" class="row g-3 mb-4">

   
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


  
    <div class="col-md-3">

        <select id="model"
                name="model"
                autocomplete="off">

            <option value="">Semua Model</option>

        </select>

    </div>


    <div class="col-md-2">

        <input type="number"
               name="bulan"
               value="{{ $bulan }}"
               class="form-control"
               placeholder="Bulan">

    </div>


  
    <div class="col-md-2">

        <input type="number"
               name="tahun"
               value="{{ $tahun }}"
               class="form-control"
               placeholder="Tahun">

    </div>



    <div class="col-md-2">

        <select name="sort" class="form-select">

            <option value="desc"
                {{ $sort == 'desc' ? 'selected' : '' }}>
                Terbaru
            </option>

            <option value="asc"
                {{ $sort == 'asc' ? 'selected' : '' }}>
                Terlama
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

    <div class="card-body table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="table-dark">

                <tr>
                    <th>Merk</th>
                    <th>Model</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Staff</th>
                </tr>

            </thead>

            <tbody>

                @forelse($data as $d)

                <tr>

                    <td>{{ $d->merk }}</td>
                    <td>{{ $d->model_mobil }}</td>
                    <td>{{ $d->jadwal }}</td>
                    <td>{{ $d->jam }}</td>
                    <td>{{ $d->staff }}</td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="text-center">
                        Data tidak ditemukan
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>



        <div class="d-flex justify-content-center mt-5">
            <canvas id="chart"></canvas>
        </div>

    </div>

</div>




<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>



<script>

document.addEventListener('DOMContentLoaded', function () {



    const merkSelect = new TomSelect('#merk', {

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


  

    const modelSelect = new TomSelect('#model', {

        create: false,

        persist: false,

        maxOptions: 500,

        placeholder: 'Cari model mobil...',

        allowEmptyOption: true,

        plugins: ['dropdown_input'],

        sortField: [
            {
                field: 'text',
                direction: 'asc'
            }
        ]

    });


    modelSelect.disable();



  

    async function loadModels(merk, selectedModel = '') {

        modelSelect.clear();
        modelSelect.clearOptions();

        if (!merk) {

            modelSelect.disable();

            return;
        }

        modelSelect.enable();

        modelSelect.addOption({
            value: '',
            text: 'Loading...'
        });

        modelSelect.refreshOptions(false);

        try {

            const response = await fetch(
                `/admin/models/${encodeURIComponent(merk)}`
            );

            const data = await response.json();

            modelSelect.clearOptions();

            modelSelect.addOption({
                value: '',
                text: 'Semua Model'
            });

            data.forEach(model => {

                modelSelect.addOption({
                    value: model,
                    text: model
                });

            });

            modelSelect.refreshOptions(false);

            if(selectedModel){
                modelSelect.setValue(selectedModel);
            }

        } catch (error) {

            console.error(error);

            modelSelect.clearOptions();

            modelSelect.addOption({
                value:'',
                text:'Gagal load model'
            });

            modelSelect.refreshOptions(false);

        }

    }





    document.getElementById('merk').addEventListener('change', function(){

        loadModels(this.value);

    });




    @if($merk)

        loadModels(
            `{{ $merk }}`,
            `{{ $model }}`
        );

    @endif






    const ctx = document.getElementById('chart');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: {!! json_encode(
                $data->groupBy('model_mobil')->keys()
            ) !!},

            datasets: [{

                label: 'Jumlah Jadwal',

                data: {!! json_encode(
                    $data->groupBy('model_mobil')->map->count()->values()
                ) !!}

            }]

        }

    });

});

</script>

@endsection