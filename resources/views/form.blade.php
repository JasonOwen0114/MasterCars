<!DOCTYPE html>
<html>
<head>
    <title>Compare Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3 class="mb-4">Bandingkan Mobil</h3>

    <form method="POST" action="{{ route('compare.result') }}">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <label>Mobil 1</label>
                <select name="mobil1" class="form-select" required>
                    <option value="">Pilih Mobil</option>
                    @foreach($mobils as $m)
                        <option value="{{ $m->id }}">
                            {{ $m->merk }} - {{ $m->nama_mobil }} ({{ $m->tahun }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label>Mobil 2</label>
                <select name="mobil2" class="form-select" required>
                    <option value="">Pilih Mobil</option>
                    @foreach($mobils as $m)
                        <option value="{{ $m->id }}">
                            {{ $m->merk }} - {{ $m->nama_mobil }} ({{ $m->tahun }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <button class="btn btn-dark mt-4">Bandingkan</button>
    </form>
</div>

</body>
</html>