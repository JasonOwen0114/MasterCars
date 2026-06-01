<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inspeksi Ulang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-4">

    <h4 class="fw-bold mb-4">Laporan Inspeksi Ulang Saya</h4>

    @forelse($data as $r)
        <div class="card mb-3 shadow-sm">
            <div class="row g-0 align-items-center">

           
                <div class="col-md-3 p-2">
                    @if($r->mobil && $r->mobil->foto_thumbnail)
                        <img src="{{ asset('storage/'.$r->mobil->foto_thumbnail) }}"
                             class="img-fluid rounded"
                             style="height:160px; object-fit:cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center"
                             style="height:160px;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif
                </div>

          
                <div class="col-md-6">
                    <div class="card-body">

                        <h5 class="fw-bold">
                            {{ $r->mobil->merk ?? '-' }} {{ $r->mobil->nama_mobil ?? '' }}
                        </h5>

                        <p class="text-muted small mb-1">
                            Tahun: {{ $r->mobil->tahun ?? '-' }}
                        </p>

                        <p class="small mb-1">
                            Jadwal: 
                            {{ \Carbon\Carbon::parse($r->jadwal)->format('d M Y') }} 
                            - {{ substr($r->jam,0,5) }}
                        </p>

                        <p class="small mb-2">
                            Lokasi: {{ $r->alamat }}
                        </p>

                  
                        <p class="mb-0">
                            Status:
                            @if($r->status == 0)
                                <span class="badge bg-warning">Pending</span>
                            @elseif($r->status == 1)
                                <span class="badge bg-info">Menunggu Assign</span>
                            @elseif($r->status == 2)
                                <span class="badge bg-primary">Proses</span>
                            @elseif($r->status == 3)
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </p>

                    </div>
                </div>

             
                <div class="col-md-3 text-center">

                    @if($r->status == 3)
                        <a href="{{ route('reinspeksi.hasil', $r->id) }}"
                           class="btn btn-dark btn-sm mb-2">
                            Lihat Hasil
                        </a>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled>
                            Belum Tersedia
                        </button>
                    @endif

                </div>

            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Belum ada data reinspeksi
        </div>
    @endforelse

</div>

</body>
</html>