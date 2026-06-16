@extends('admin.layouts.laporan')

@section('content')
<style>

.preview-image{
    box-shadow: 0 2px 8px rgba(0,0,0,.15);
}

.preview-image:hover{
    transform: scale(1.05);
}

</style>
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
            <th>Foto Serah Terima</th>
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

<td class="text-center">

    @if($d->foto_serahterima)

        <img src="{{ $d->foto_serahterima }}"
             width="120"
             height="80"
             class="preview-image"
             data-bs-toggle="modal"
             data-bs-target="#imageModal"
             style="
                object-fit: cover;
                border-radius: 8px;
                cursor: pointer;
                transition: .3s;
             ">

    @else

        <span class="text-muted">
            Tidak ada foto
        </span>

    @endif

</td>

</tr>
@endforeach
</tbody>

</table>
<div class="modal fade"
     id="imageModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Foto Serah Terima
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <img id="previewImage"
                     src=""
                     class="img-fluid rounded">

            </div>

        </div>

    </div>

</div>
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
document.querySelectorAll('.preview-image').forEach(img => {

    img.addEventListener('click', function(){

        document.getElementById('previewImage').src =
            this.src;

    });

});
</script>
@endsection