@extends('admin.layouts.laporan')

@section('content')

<h3 class="mb-4 fw-bold">
    Laporan Waktu Penjualan Mobil
</h3>




<form method="GET" class="row g-3 mb-4">


    <div class="col-md-3">

        <select id="merk"
                name="merk"
                autocomplete="off">

            <option value="">
                Semua Merk
            </option>

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

            <option value="">
                Semua Model
            </option>

        </select>

    </div>




  
    <div class="col-md-3">

        <select name="sort" class="form-select">

            <option value="asc"
                {{ $sort == 'asc' ? 'selected' : '' }}>

                Tercepat Terjual

            </option>

            <option value="desc"
                {{ $sort == 'desc' ? 'selected' : '' }}>

                Terlama Terjual

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

                    <th>Mobil</th>
                    <th>Merk</th>
                    <th>Tanggal Upload</th>
                    <th>Tanggal Terjual</th>
                    <th>Lama Terjual</th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $d)

                <tr>

                    <td>{{ $d->nama_mobil }}</td>

                    <td>{{ $d->merk }}</td>

                    <td>

                        {{ Carbon\Carbon::parse($d->created_at)
                            ->translatedFormat('d F Y') }}

                    </td>

                    <td>

                        {{ Carbon\Carbon::parse($d->tanggal_transaksi)
                            ->translatedFormat('d F Y') }}

                    </td>

                    <td>

                        <span class="badge bg-dark">

                            {{ $d->lama_hari }} Hari

                        </span>

                    </td>

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
    </div>
</div>






<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>




<script>

document.addEventListener('DOMContentLoaded', function () {

    // =========================================
    // MERK
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
    // MODEL
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




    // DEFAULT
    modelSelect.disable();




    // =========================================
    // LOAD MODEL
    // =========================================

    async function loadModels(merk, selectedModel = '') {

        modelSelect.clear();
        modelSelect.clearOptions();

        if(!merk){

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

        } catch(error){

            console.log(error);

        }

    }




    // =========================================
    // MERK CHANGE
    // =========================================

    merkSelect.on('change', function(value){

        loadModels(value);

    });

    // =========================================
    // LOAD DEFAULT
    // =========================================

    @if($merk)

        loadModels(
            `{{ $merk }}`,
            `{{ $model }}`
        );

    @endif




});

</script>

@endsection