<!DOCTYPE html>
<html>
<head>
    <title>Tambah Mobil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <span class="navbar-brand">
            Admin Dashboard
        </span>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('admin.tambahMobil') }}"
            class="btn btn-info btn-sm">
                + Tambah Mobil
            </a>
            
            <a href="{{ route('admin.staff.create') }}"
               class="btn btn-success btn-sm">
                + Add Staff
            </a>

            <a href="{{ route('admin.booking') }}"
               class="btn btn-warning btn-sm">
                Assign Delivery
            </a>

            <a href="{{ route('admin.reinspeksi') }}"
               class="btn btn-primary btn-sm">
                Re-Inspeksi
            </a>

            <a href="{{ route('admin.laporan') }}"
               class="btn btn-primary btn-sm">
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

                <h5 class="mb-3">Tambah Merk Mobil</h5>

                <form action="{{ route('admin.merk.store') }}" method="POST">
                    @csrf

                    <input type="text"
                           name="merk"
                           class="form-control mb-3"
                           placeholder="Contoh: Toyota"
                           required>

                    <button class="btn btn-primary w-100">
                        Add Merk
                    </button>

                </form>

            </div>
        </div>


        <div class="col-md-6">
            <div class="card p-3 shadow-sm">

                <h5 class="mb-3">Tambah Model Mobil</h5>

                <form action="{{ route('admin.model.store') }}" method="POST">
                    @csrf

                    {{-- MERK --}}
                    <label class="form-label">Merk</label>
                    <select id="merk" name="merk" class="form-select mb-3" required>
                        <option value="">Pilih Merk</option>
                        @foreach($merks as $merk)
                            <option value="{{ $merk }}">{{ $merk }}</option>
                        @endforeach
                    </select>

                    {{-- MODEL --}}
                    <label class="form-label">Model</label>
                    <input type="text"
                           id="model"
                           name="model"
                           class="form-control mb-3"
                           placeholder="Masukkan model"
                           disabled
                           required>

                    <button class="btn btn-success w-100">
                        Add Model
                    </button>

                </form>

            </div>
        </div>

    </div>

</div>

<script>
document.getElementById('merk').addEventListener('change', function () {
    let model = document.getElementById('model');

    if (this.value) {
        model.disabled = false;
    } else {
        model.disabled = true;
        model.value = '';
    }
});
</script>

</body>
</html>