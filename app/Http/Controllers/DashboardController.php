<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{


public function index(Request $request)
{
    $query = Mobil::where('status', 'tersedia');
    if (auth()->check()) {
        $query->where('user_id', '!=', auth()->id());
    }
    if ($request->merk) {
        $query->where('merk', $request->merk);
    }
    if ($request->model) {
        $query->where('nama_mobil', $request->model);
    }
    if ($request->tahun_min) {
        $query->where('tahun', '>=', $request->tahun_min);
    }
    if ($request->tahun_max) {
        $query->where('tahun', '<=', $request->tahun_max);
    }
    if ($request->harga_min) {
    $query->where('harga', '>=', $request->harga_min);
    }
    if ($request->harga_max) {
        $query->where('harga', '<=', $request->harga_max);
    }
if ($request->kursi) {
    $query->where('kapasitas_kursi', $request->kursi);
}
if ($request->sort) {
    switch ($request->sort) {
        case 'harga_terendah':
            $query->orderBy('harga', 'asc');
            break;

        case 'harga_tertinggi':
            $query->orderBy('harga', 'desc');
            break;

        case 'tahun_terbaru':
            $query->orderBy('tahun', 'desc');
            break;

        case 'tahun_terlama':
            $query->orderBy('tahun', 'asc');
            break;

        default:
            $query->latest();
            break;
    }
} else {
    $query->latest();
}
$mobils = $query->paginate(9)->withQueryString();
    $merks = DB::table('data_mobil')->select('merk')->distinct()->pluck('merk');
    if ($request->ajax()) {
        return view('partials.mobil-card', compact('mobils'))->render();
    }

    return view('dashboard', compact('mobils', 'merks'));
}

    public function getModelByMerk($merk)
    {
        return DB::table('data_mobil')
            ->where('merk', $merk)
            ->pluck('model');
    }

    public function compareForm()
{
    $mobils = Mobil::where('status', 'tersedia')->get();

    return view('form', compact('mobils'));
}

public function compareResult(Request $request)
{
    $ids = explode(',', $request->ids);

    $mobils = \App\Models\Mobil::with([
        'inspeksi.eksterior',
        'inspeksi.interior',
        'inspeksi.mesin',
        'inspeksi.kelengkapan'
    ])->whereIn('id', $ids)->get();

   return view('result', compact('mobils'));
}
}