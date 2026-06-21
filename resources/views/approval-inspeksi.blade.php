@php
use Illuminate\Support\Str;

function fotoUrl($path)
{
    if(empty($path)){
        return asset('images/no-image.png');
    }

    return Str::startsWith($path, ['http://', 'https://'])
        ? $path
        : asset('storage/'.$path);
}
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Approval Inspeksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@php
    use App\Models\Mobil;

    $jumlahMenunggu = 0;
    $jumlahTersedia = 0;

    if(auth()->check()){
        $jumlahMenunggu = Mobil::where('user_id', auth()->id())
            ->where('status', 'menunggu')
            ->count();

        $jumlahTersedia = Mobil::where('user_id', auth()->id())
            ->where('status', 'tersedia')
            ->count();
    }
@endphp
@php
$approvalCount = DB::table('jadwal_inspeksi')
    ->where('user_id', auth()->id())
    ->whereNull('status_approval')
    ->orWhereNotNull('note')
    ->exists();
@endphp
<nav class="navbar navbar-expand-lg navbar-dark bg-black px-4">
    
    <a class="navbar-brand d-flex align-items-center gap-2" href="/">
        <img src="{{ asset('images/logo.png') }}"
             alt="MasterCars"
             height="36">
    </a>

    <div class="ms-auto d-flex align-items-center gap-3">

        <a href="{{ route('user.profile') }}"
           class="nav-link text-white">
            Profil
        </a>

        @auth
            @if($jumlahMenunggu > 0)
                <a href="{{ route('user.inspeksi') }}"
                   class="nav-link text-white">
                    Inspeksi
                </a>
            @endif
            @if($approvalCount)
                <a href="{{ route('user.approval') }}"
                class="nav-link text-white">
                    Approval
                </a>
            @endif
            @if($jumlahTersedia > 0)
                <a href="{{ route('user.mobilSaya') }}"
                   class="nav-link text-white fw-bold">
                    Mobil Saya
                </a>
            @endif
        @endauth

        @php
        $punyaReinspeksi = DB::table('reinspeksi')
            ->where('user_id', auth()->id())
            ->exists();
        @endphp

        @if($punyaReinspeksi)
            <a href="{{ route('laporan.reinspeksi') }}"
               class="nav-link text-white">
                Laporan Inspeksi
            </a>
        @endif

        @auth
            <a href="{{ route('jual1') }}"
               class="nav-link text-white">
                Jual
            </a>
        @else
            <a href="{{ route('login') }}"
               class="nav-link text-white">
                Jual
            </a>
        @endauth

        @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger btn-sm">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}"
               class="btn btn-light btn-sm">
                Login
            </a>
        @endauth

    </div>

</nav>
<div class="container py-4">

    <h4 class="fw-bold mb-4">
        Status Approval Inspeksi
    </h4>

    @forelse($jadwal as $item)

        <div class="card mb-3 shadow-sm">

            <div class="row g-0 align-items-center">

                <div class="col-md-3 p-2">

                    <img
                        src="{{ fotoUrl(optional($item->mobil)->foto_thumbnail) }}"
                        class="img-fluid rounded"
                        style="height:160px;width:100%;object-fit:cover;"
                        alt="Mobil">

                </div>

                <div class="col-md-7">

                    <div class="card-body">

                        <h5 class="fw-bold">
                            {{ $item->merk }}
                            {{ $item->model_mobil }}
                        </h5>

                        <p class="text-muted small mb-1">
                            {{ $item->tahun }}
                            •
                            {{ $item->transmisi }}
                            •
                            {{ $item->warna }}
                        </p>

                        <p class="small mb-1">
                            {{ $item->tipe_mesin }}
                        </p>

                        <p class="small text-muted mb-2">
                            Jadwal:
                            {{ \Carbon\Carbon::parse($item->jadwal)->format('d-m-Y') }}
                            {{ $item->jam }}
                        </p>

                        @if($item->status_approval == 1)

                            <span class="badge bg-success">
                                Approved
                            </span>

                        @elseif(!empty($item->note))

                            <span class="badge bg-danger">
                                Rejected
                            </span>

                            <div class="mt-2">

                                <strong>
                                    Alasan Penolakan:
                                </strong>

                                <br>

                                <span class="text-danger">
                                    {{ $item->note }}
                                </span>

                            </div>

                        @else

                            <span class="badge bg-warning text-dark">
                                Menunggu Approval
                            </span>

                        @endif

                    </div>

                </div>

                <div class="col-md-2 text-center">

                    @if($item->mobil)

                        <a href="{{ route('user.mobilSaya.detail',$item->mobil->id) }}"
                           class="btn btn-outline-primary btn-sm">
                            Lihat Mobil
                        </a>

                    @endif

                </div>

            </div>

        </div>

    @empty

        <div class="alert alert-info">
            Belum ada pengajuan inspeksi.
        </div>

    @endforelse

</div>

</div>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session("success") }}',
    confirmButtonText: 'OK'
});
</script>
<script>
document.querySelectorAll('.form-hapus').forEach(form => {

    form.addEventListener('submit', function(e) {

        e.preventDefault();

        Swal.fire({
            title: 'Hapus Mobil?',
            text: 'Mobil akan dihapus dari daftar Mobil Saya.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});
</script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>