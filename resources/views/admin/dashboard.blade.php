<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html,
        body{
            height: 100%;
        }

        body{
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        .main-content{
            flex: 1;
        }

table{
    width: 100%;
}

.table td,
.table th{
    font-size: 13px;
    vertical-align: middle;
}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <span class="navbar-brand">
            Admin Dashboard
        </span>

        <div class="d-flex align-items-center gap-2 flex-wrap">

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

<div class="main-content">

    <div class="container-fluid mt-4 px-4">

        <h4 class="mb-3">
            Jadwal Inspeksi (Belum & Sedang Assign)
        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-striped align-middle">

      
                        <thead class="table-dark">

                            <tr>

                                <th>Merk</th>
                                <th>Model</th>
                                <th>Tahun</th>
                                <th>Transmisi</th>
                                <th>Warna</th>
                                <th>Tipe Mesin</th>
                                <th>Kontak</th>
                                <th>Alamat</th>
                                <th>Kecamatan</th>
                                <th>Jadwal</th>
                            <th>Status Approval</th>
                            <th>Note Reject</th>
                            <th>Staff</th>
                            <th>Aksi</th>

                            </tr>

                        </thead>
           
<tbody>
@foreach($jadwal as $j)

@php
    $availableStaff = app(App\Http\Controllers\AdminController::class)
        ->getAvailableStaff($j);
@endphp

<tr>

    <td>{{ $j->merk }}</td>
    <td>{{ $j->model_mobil }}</td>
    <td>{{ $j->tahun }}</td>
    <td>{{ $j->transmisi }}</td>
    <td>{{ $j->warna }}</td>
    <td>{{ $j->tipe_mesin }}</td>
    <td>{{ $j->nomor_kontak }}</td>
    <td>{{ $j->alamat }}</td>
    <td>{{ $j->kecamatan }}</td>

    <td>
        {{ $j->jadwal }} <br>
        <small class="text-muted">{{ $j->jam }}</small>
    </td>

    <form action="{{ route('admin.assign.store',$j->id) }}" method="POST">
        @csrf

        <td>
            <select name="status_approval" class="form-select approval-select" required>
                <option value="">Pilih Status</option>
                <option value="1">Approve</option>
                <option value="0">Reject</option>
            </select>
        </td>

        <td>
            <textarea name="note"
                      class="form-control note-field"
                      rows="2"
                      style="display:none"
                      placeholder="Alasan penolakan"></textarea>
        </td>

        <td>
            <select name="staff_id"
                    class="form-select staff-select"
                    disabled>
                <option value="">-- Pilih Staff --</option>

                @foreach($availableStaff as $s)
                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                @endforeach
            </select>
        </td>

        <td>
            <button type="submit" class="btn btn-success btn-sm">
                Simpan
            </button>
        </td>

    </form>

</tr>

@endforeach
</tbody>

            </table>

        </div>

    </div>

</div>

<footer class="bg-dark text-white text-center py-3 mt-auto">

    <small>
        © {{ date('Y') }} Sistem Inspeksi Mobil |
        Admin Panel
    </small>

</footer>

<script>

document.addEventListener('DOMContentLoaded', function(){

    document.querySelectorAll('.approval-select').forEach(function(select){

        select.addEventListener('change', function(){

            let row = this.closest('tr');

            let staff = row.querySelector('.staff-select');
            let note  = row.querySelector('.note-field');

            if(this.value == '1')
            {
                staff.disabled = false;
                staff.required = true;

                note.style.display = 'none';
                note.required = false;
                note.value = '';
            }
            else if(this.value == '0')
            {
                staff.disabled = true;
                staff.required = false;
                staff.value = '';

                note.style.display = 'block';
                note.required = true;
            }
            else
            {
                staff.disabled = true;
                staff.required = false;

                note.style.display = 'none';
                note.required = false;
            }

        });

    });

});

</script>

</body>
</html>

</body>
</html>