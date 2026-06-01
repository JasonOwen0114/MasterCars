<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Inspeksi - MasterCars</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-card {
            border-radius: 16px;
        }

        .btn-next {
            padding: 10px 60px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-black px-4">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/">
        <img src="{{ asset('images/logo.png') }}"
             alt="MasterCars"
             height="36">
    </a>
</nav>

<div class="container mt-5">

    <div class="text-center mb-4">
        <h2 class="fw-bold">Welcome to MasterCars</h2>
        <p class="text-muted">
            Find the perfect car for your needs at here. Shop new and used cars,
            sell your car, compare prices, and explore financing options to find your dream car.
        </p>
    </div>

    <div class="card shadow-sm p-4 form-card">

        <form action="{{ route('jual2') }}" method="POST">
        @csrf


            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Nomor kontak</label>
                    <input type="number"
                            name="nomor_kontak"
                            class="form-control"
                            placeholder="Contoh: 08123456789"
                            value="{{ old('nomor_kontak', auth()->user()->no_hp) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Alamat, Nama Jalan, No. Rumah</label>
                    <input type="text"
                            name="alamat"
                            class="form-control"
                            placeholder="Masukkan alamat lengkap"
                            value="{{ old('alamat', auth()->user()->alamat) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Pilih Jadwal Inspeksi</label>
                    <input type="date"
                        name="jadwal"
                        id="tanggal"
                        class="form-control"
                        min="{{ now()->addDay()->format('Y-m-d') }}"
                        max="{{ now()->addDays(7)->format('Y-m-d') }}">
                </div>


                <div class="col-md-6">
                    <label class="form-label">Kecamatan</label>
                    <input type="text"
                            name="kecamatan"
                            class="form-control"
                            placeholder="Masukkan kecamatan"
                            value="{{ old('kecamatan', auth()->user()->kecamatan) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jam Inspeksi</label>
                    <select name="jam" id="jam" class="form-control">
                        <option value="">Pilih tanggal terlebih dahulu</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Detail Lainnya (Cth: Blok/Unit No., Patokan)</label>
                    <input type="text" name="note" class="form-control" placeholder="Contoh: Blok A No 3 dekat minimarket">
                </div>

            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-dark btn-next">
                    Next
                </button>
            </div>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>

document.getElementById('tanggal').addEventListener('change', function(){

    let tanggal = this.value;

    fetch('/cek-slot/'+tanggal)
    .then(res => res.json())
    .then(data => {

        let jamSelect = document.getElementById('jam');
        jamSelect.innerHTML = '';

        if(data.length === 0){
            jamSelect.innerHTML = '<option>Jadwal penuh</option>';
            return;
        }

        data.forEach(function(jam){

            let option = document.createElement('option');
            option.value = jam;
            option.text = jam;

            jamSelect.appendChild(option);

        });

    });

});

</script>
</body>
</html>
