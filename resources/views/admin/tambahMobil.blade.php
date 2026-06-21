<!DOCTYPE html>
<html>
<head>
    <title>Tambah Mobil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <style>
        body{
            background:#f8f9fa;
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <span class="navbar-brand">
            Admin Dashboard
        </span>

        <div class="d-flex align-items-center gap-2 flex-wrap">

            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
                Dashboard
            </a>

            <a href="{{ route('admin.tambahMobil') }}" class="btn btn-info btn-sm">
                + Tambah Mobil
            </a>

            <a href="{{ route('admin.staff.create') }}" class="btn btn-success btn-sm">
                + Add Staff
            </a>

            <a href="{{ route('admin.booking') }}" class="btn btn-warning btn-sm">
                Assign Delivery
            </a>

            <a href="{{ route('admin.reinspeksi') }}" class="btn btn-primary btn-sm">
                Re-Inspeksi
            </a>

            <a href="{{ route('admin.laporan') }}" class="btn btn-primary btn-sm">
                Laporan
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light btn-sm">
                    Logout
                </button>
            </form>

        </div>
    </div>
</nav>

<div class="container mt-4">

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">

                <h5 class="mb-3">Tambah Merk + Model (Sekaligus)</h5>

                <form action="{{ route('admin.merk.store') }}" method="POST">
                    @csrf

                    <label class="form-label">Merk Mobil</label>
                    <input type="text"
                           name="merk"
                           class="form-control mb-3"
                           placeholder="Contoh: Toyota"
                           required>

                    <label class="form-label">Model Mobil</label>
                    <input type="text"
                           name="model"
                           class="form-control mb-3"
                           placeholder="Contoh: Avanza"
                           required>

                    <button class="btn btn-primary w-100">
                        Simpan Merk & Model
                    </button>

                </form>

            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3 shadow-sm">

                <h5 class="mb-3">Tambah Model Mobil</h5>

                <form action="{{ route('admin.model.store') }}" method="POST">
                    @csrf

                    <label class="form-label">Merk Mobil</label>
                    <select id="merk" name="merk" class="form-select mb-3" required>
                        <option value="">Pilih Merk</option>
                        @foreach($merks as $merk)
                            <option value="{{ $merk }}">{{ $merk }}</option>
                        @endforeach
                    </select>
                    <label class="form-label">Model Mobil</label>
                    <input type="text"
                           id="model"
                           name="model"
                           class="form-control mb-3"
                           placeholder="Masukkan model"
                           disabled
                           required>

                    <button class="btn btn-success w-100">
                        Simpan Model
                    </button>

                </form>

            </div>
        </div>

<div class="row mt-4">

    <div class="col-md-6">
        <div class="card p-3 shadow-sm">

            <h5 class="mb-3 text-danger">Hapus Model Mobil</h5>

            <form action="{{ route('admin.model.delete') }}" method="POST">
                @csrf
                @method('DELETE')

                <label class="form-label">Pilih Merk</label>
                <select id="merkDelete" class="form-select mb-2" required>
                    <option value="">Pilih Merk</option>
                    @foreach($merks as $merk)
                        <option value="{{ $merk }}">{{ $merk }}</option>
                    @endforeach
                </select>

                <label class="form-label">Pilih Model</label>
                <select name="model"
                        id="modelDelete"
                        class="form-select mb-3"
                        disabled
                        required>
                    <option value="">Pilih Model</option>
                </select>

                <input type="hidden" name="merk" id="merkHidden">

                <button class="btn btn-danger w-100">
                    Hapus Model
                </button>

            </form>

        </div>
    </div>

</div>

    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<script>

    new TomSelect("#merk", {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });


    const merk = document.getElementById('merk');
    const model = document.getElementById('model');

    merk.addEventListener('change', function () {
        if (this.value) {
            model.disabled = false;
        } else {
            model.disabled = true;
            model.value = '';
        }
    });
</script>
<script>
const merkDelete = document.getElementById('merkDelete');
const modelDelete = document.getElementById('modelDelete');
const merkHidden = document.getElementById('merkHidden');

merkDelete.addEventListener('change', function () {

    let merk = this.value;
    merkHidden.value = merk;

    modelDelete.disabled = true;
    modelDelete.innerHTML = `<option>Loading...</option>`;

    fetch(`/admin/models/${merk}`)
        .then(res => res.json())
        .then(data => {

            modelDelete.innerHTML = `<option value="">Pilih Model</option>`;

            data.forEach(m => {
                modelDelete.innerHTML += `
                    <option value="${m}">${m}</option>
                `;
            });

            modelDelete.disabled = false;
        });
});
</script>

</body>
</html>