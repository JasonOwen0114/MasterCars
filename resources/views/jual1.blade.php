<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jual Mobil - MasterCars</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-card {
            border-radius: 16px;
        }

        .btn-next {
            padding: 10px 50px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-black px-4">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/">
        <img src="{{ asset('images/logo.png') }}" alt="MasterCars" height="36">
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

        <form action="{{ route('jual1') }}" method="POST">
            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Merk mobil</label>
                    <select class="form-select" id="merk" name="merk" placeholder="Cari merk..." required>
                        <option value="">Pilih merk</option>
                        @foreach ($merks as $merk)
                            <option value="{{ $merk }}">{{ $merk }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Model mobil</label>
                    <select class="form-select" id="model" name="model" placeholder="Cari model..." disabled required>
                        <option value="">Pilih model</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tahun pembuatan</label>
                    <input type="number" name="tahun" class="form-control" placeholder="Contoh: 2020" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kilometer</label>
                    <input type="number" name="kilometer" class="form-control" placeholder="Contoh: 50000" min="0" required>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Transmisi</label>
                    <select name="transmisi" class="form-select" required>
                        <option value="">Pilih transmisi</option>
                        <option value="Manual">Manual</option>
                        <option value="Automatic">Automatic</option>
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Warna</label>
                    <input type="text" name="warna" class="form-control" placeholder="Contoh: Hitam" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tipe Mesin</label>
                    <select name="tipe_mesin" class="form-select" required>
                        <option value="">Pilih tipe mesin</option>
                        <option value="Bensin">Bensin</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Electric">Electric</option>
                    </select>
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
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<script>
    const merkSelect = new TomSelect("#merk", {
        create: false,
        sortField: { field: "text", direction: "asc" }
    });

    const modelSelect = new TomSelect("#model", {
        create: false,
        sortField: { field: "text", direction: "asc" }
    });

    document.getElementById('merk').addEventListener('change', function () {

        let merk = this.value;

        modelSelect.clear();
        modelSelect.clearOptions();
        modelSelect.addOption({value: "", text: "Loading..."});
        modelSelect.refreshOptions(false);
        modelSelect.disable();

        fetch(`/jual/models/${merk}`)
            .then(response => response.json())
            .then(data => {

                modelSelect.clearOptions();

                data.forEach(model => {
                    modelSelect.addOption({
                        value: model,
                        text: model
                    });
                });

                modelSelect.enable();
                modelSelect.refreshOptions(false);
            })
            .catch(() => {
                modelSelect.clearOptions();
                modelSelect.addOption({value: "", text: "Error load data"});
            });
    });
</script>

</body>
</html>
