@extends('admin.layouts.laporan')

@section('content')

<h3 class="mb-4">Laporan Penjualan Mobil</h3>

<form class="row g-3 mb-4">

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

            <option value="desc">Terbaru</option>
            <option value="asc">Terlama</option>

        </select>

    </div>

    <div class="col-md-auto">

        <button class="btn btn-dark">
            Filter
        </button>

    </div>

</form>

<table class="table table-bordered">

    <thead>
        <tr>
            <th>Mobil</th>
            <th>Merk</th>
            <th>Harga</th>
            <th>Tanggal</th>
            <th>Pembeli</th>
            <th>Penjual</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $d)
        <tr>
            <td>{{ $d->nama_mobil }}</td>
            <td>{{ $d->merk }}</td>
            <td>Rp {{ number_format($d->harga) }}</td>
            <td>{{ $d->tanggal_transaksi }}</td>
            <td>{{ $d->pembeli }}</td>
            <td>{{ $d->penjual }}</td>
        </tr>
        @endforeach
    </tbody>

</table>
<canvas id="chart"></canvas>

<script>

const ctx = document.getElementById('chart');

new Chart(ctx, {

    type:'line',

    data:{

        labels: {!! json_encode($data->pluck('tanggal_transaksi')) !!},

        datasets:[{

            label:'Harga Penjualan',

            data: {!! json_encode($data->pluck('harga')) !!}

        }]
    }

});

</script>
@endsection