@extends('admin.layouts.laporan')

@section('content')

<h3 class="mb-4 fw-bold">
    Laporan Mobil per Tahun
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
               name="tahun"
               value="{{ request('tahun') }}"
               class="form-control"
               placeholder="Tahun">

    </div>


  
    <div class="col-md-2">

        <select name="sort" class="form-select">

            <option value="desc"
                {{ request('sort') == 'desc' ? 'selected' : '' }}>
                Tahun Terbaru
            </option>

            <option value="asc"
                {{ request('sort') == 'asc' ? 'selected' : '' }}>
                Tahun Terlama
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
                    <th>Tahun</th>
                    <th>Transmisi</th>
                    <th>Tipe Mesin</th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $d)

                <tr>

                    <td>{{ $d->merk }}</td>
                    <td>{{ $d->model_mobil }}</td>
                    <td>{{ $d->tahun }}</td>
                    <td>{{ $d->transmisi }}</td>
                    <td>{{ $d->tipe_mesin }}</td>

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


      
        <div class="mt-5">
            <canvas id="chart"></canvas>
        </div>

    </div>

</div>



<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>



<script>

document.addEventListener('DOMContentLoaded', function () {

    // =========================================
    // MERK SELECT
    // =========================================

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



    // =========================================
    // MODEL SELECT
    // =========================================

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



    // DEFAULT DISABLE
    modelSelect.disable();



    // =========================================
    // LOAD MODEL FUNCTION
    // =========================================

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

        } catch(error) {

            console.error(error);

            modelSelect.clearOptions();

            modelSelect.addOption({
                value:'',
                text:'Gagal load model'
            });

            modelSelect.refreshOptions(false);

        }

    }



    // =========================================
    // EVENT MERK CHANGE
    // =========================================

    merkSelect.on('change', function(value){

        loadModels(value);

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
                $data->groupBy('tahun')->keys()
            ) !!},

            datasets: [{

                label: 'Jumlah Mobil',

                data: {!! json_encode(
                    $data->groupBy('tahun')->map->count()->values()
                ) !!}

            }]

        }

    });

});

</script>

@endsection