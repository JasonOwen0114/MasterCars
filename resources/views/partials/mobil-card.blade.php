@foreach($mobils as $mobil)

<div class="col-md-4">
    <div class="position-relative">

        <div class="position-absolute top-0 end-0 m-2"
             style="z-index: 10;">
             
            <input type="checkbox"
                   class="compare-checkbox form-check-input"
                   value="{{ $mobil->id }}"
                   onclick="event.stopPropagation();">

        </div>

        <a href="{{ route('mobil.detail', $mobil->id) }}"
           class="text-decoration-none text-dark">

            <div class="card car-card shadow-sm h-100">
                @php
                use Illuminate\Support\Str;
                @endphp
                <img
                    src="{{ $mobil->foto_thumbnail
                            ? (Str::startsWith($mobil->foto_thumbnail, 'http')
                                ? $mobil->foto_thumbnail
                                : asset('storage/'.$mobil->foto_thumbnail))
                            : asset('images/no-image.png') }}"
                    class="w-100"
                    alt="{{ $mobil->merk }} {{ $mobil->nama_mobil }}"
                >

                <div class="card-body">
                    <h6 class="fw-bold mb-1">
                        {{ $mobil->merk }} {{ $mobil->nama_mobil }}
                    </h6>

                    <p class="text-muted mb-1">
                        {{ ucfirst($mobil->tipe) }} • {{ $mobil->tahun }}
                    </p>

                    <p class="fw-bold text-primary mb-0">
                        Rp {{ number_format($mobil->harga,0,',','.') }}
                    </p>
                </div>

            </div>
        </a>

    </div>
</div>

@endforeach