<?php

namespace App\Http\Controllers;

use App\Models\DataKelompok;
use App\Models\DataKomoditi;
use App\Models\District;
use App\Models\Fish;
use App\Models\Fruit;
use App\Models\LiveStock;
use App\Models\MedicalPlant;
use App\Models\Vegetables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index(Request $request)
    {
        $page = strtoupper($request->path());
        $sector = $request->query('sector');
        $selectedCommodity = $request->input('commodity');
        $selectedDistrict = $request->input('district');
        $districts = District::all();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $sectorMap = [
            'sayur' => [Vegetables::class, 'nama_sayur', 'jumlah_panen', 'jumlah_tanam', 'prakiraan_jumlah_panen'],
            'tanaman_obat' => [MedicalPlant::class, 'nama_tanaman_obat', 'jumlah_panen'],
            'ternak' => [LiveStock::class, 'jenis_ternak', 'jumlah_panen_kg'],
            'ikan' => [Fish::class, 'jenis_ikan', 'jumlah_panen_kg'],
            'buah' => [Fruit::class, 'nama_buah', 'jumlah_panen', 'prakiraan_jumlah_panen'],
        ];

        $commodity = collect();
        $data = collect();
        $totalHarvest = 0;

        if (array_key_exists($sector, $sectorMap)) {
            [$model, $columnName, $harvestColumn, $estHarvestAmountinSeed, $estHarvestAmountinKg] = $sectorMap[$sector];

            try {
                $commodity = $model::select("$columnName as name")
                    ->distinct()
                    ->orderBy('name', 'asc')
                    ->get();

                $dataKelompok = DataKelompok::where('kecamatan', $selectedDistrict)
                                            ->pluck('nama_kelompok', 'id_kelompok');
                // dd($dataKelompok);

                $dataKelurahan = DataKelompok::where('kecamatan', $selectedDistrict)
                    ->get(['kelurahan', 'id_kelompok'])
                    ->groupBy('kelurahan');

                $dataTotal = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName) {
                    return $query->where($columnName, $selectedCommodity);
                })->get();

                if ($startDate && $endDate) {
                    $dataPerKecamatan = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName, $dataKelompok) {
                        return $query->where($columnName, $selectedCommodity)
                                    ->whereIn('id_kelompok', $dataKelompok);
                    })
                        ->whereBetween('waktu_panen', [$startDate, $endDate])
                        ->get();

                    // Data per kelurahan
                    $dataPanenPerKelurahan = $dataKelurahan->map(function ($items, $kelurahan) use ($selectedCommodity, $model, $columnName, $harvestColumn, $startDate, $endDate) {
                        $idKelompok = $items->pluck('id_kelompok')->toArray();

                        $data = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName) {
                            return $query->where($columnName, $selectedCommodity);
                        })
                        ->whereIn('id_kelompok', $idKelompok)
                        ->whereBetween('waktu_panen', [$startDate, $endDate])
                        ->get();

                        // hitung total panen per kelurahan
                        $total = $data->sum($harvestColumn ?? 'jumlah_panen');

                        // hanya return jika total > 0
                        return $total > 0 ? [
                            'kelurahan' => $kelurahan,
                            'data' => $data,
                            'total' => $total,
                        ] : null;
                    })
                    ->filter() // buang null
                    ->values(); // reset key

                    $dataBelumPanenPerKelurahan = $dataKelurahan->map(function ($items, $kelurahan) use ($selectedCommodity, $model, $columnName, $startDate, $endDate) {
                        $idKelompok = $items->pluck('id_kelompok')->toArray();

                        $data = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName) {
                            return $query->where($columnName, $selectedCommodity);
                        })
                                    ->whereIn('id_kelompok', $idKelompok)
                                    ->whereBetween('waktu_panen', [$startDate, $endDate])
                                    ->whereNull('waktu_panen')
                                    ->get();

                        // hitung total panen per kelurahan
                        $total = $data->sum($estHarvestAmountinKg ?? 'prakiraan_jumlah_panen');

                        // hanya return jika total > 0
                        return $total > 0 ? [
                            'kelurahan' => $kelurahan,
                            'data' => $data,
                            'total' => $total,
                        ] : null;
                    })
                    ->filter() // buang null
                    ->values();

                    $dataPanen7HariKedepan = $dataKelurahan->map(function ($items, $kelurahan) use ($selectedCommodity, $model, $columnName, $endDate) {
                        $idKelompok = $items->pluck('id_kelompok')->toArray();
                        $startRange = Carbon::parse($endDate);
                        $endRange = $startRange->copy()->addDays(7);
                        $data = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName) {
                            return $query->where($columnName, $selectedCommodity);
                        })
                                    ->whereIn('id_kelompok', $idKelompok)
                                    ->whereBetween('waktu_prakiraan_panen', [$startRange, $endRange])
                                    ->get();

                        // hitung total panen per kelurahan
                        $total = $data->sum($estHarvestAmountinKg ?? 'prakiraan_jumlah_panen');

                        // hanya return jika total > 0
                        return $total > 0 ? [
                            'kelurahan' => $kelurahan,
                            'data' => $data,
                            'total' => $total,
                        ] : null;
                    })
                    ->filter() // buang null
                    ->values();
                    // dd($dataPanen7HariKedepan);
                    // dd($dataTelatPanenPerKelurahan);
                    // total Keseluruhan
                    $totalHarvestPerKec = $dataPerKecamatan->sum($harvestColumn);
                    $totalHarvest = $dataTotal->sum($harvestColumn);
                    $totalEstHarvest = $dataPerKecamatan->sum($estHarvestAmountinKg);

                    $belumPaneninSeed = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName, $dataKelompok, $startDate, $endDate) {
                        return $query->where($columnName, $selectedCommodity)
                                            ->whereBetween('waktu_prakiraan_panen', [$startDate, $endDate])
                                    ->whereIn('id_kelompok', $dataKelompok)
                                    ->whereNull('waktu_panen');
                    })->sum($estHarvestAmountinSeed);

                    $belumPaneninKg = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName, $dataKelompok, $startDate, $endDate) {
                        return $query->where($columnName, $selectedCommodity)
                                        ->whereBetween('waktu_prakiraan_panen', [$startDate, $endDate])
                                        ->whereIn('id_kelompok', $dataKelompok)
                                        ->whereNull('waktu_panen');
                    })->sum('prakiraan_jumlah_panen');
                } else {
                    $dataPerKecamatan = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName, $dataKelompok) {
                        return $query->where($columnName, $selectedCommodity)
                                    ->whereIn('id_kelompok', $dataKelompok);
                    })->get();
                    // Data per kelurahan
                    $dataPanenPerKelurahan = $dataKelurahan->map(function ($items, $kelurahan) use ($selectedCommodity, $model, $columnName, $harvestColumn, $dataKelompok) {
                        $idKelompok = $items->pluck('id_kelompok')->toArray();

                        $data = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName) {
                            return $query->where($columnName, $selectedCommodity);
                        })
                                    ->whereIn('id_kelompok', $idKelompok)
                                    ->get();

                        // hitung total panen per kelurahan
                        $total = $data->sum($harvestColumn ?? 'jumlah_panen');

                        // hanya return jika total > 0
                        return $total > 0 ? [
                            'kelurahan' => $kelurahan,
                            'data' => $data->map(function ($item) use ($columnName, $dataKelompok) {
                                return [
                                    'nama' => $item->$columnName,
                                    'id_kelompok' => $item->id_kelompok,
                                    'nama_kelompok' => $dataKelompok[$item->id_kelompok] ?? '-',
                                    'jumlah_panen' => $item->jumlah_panen ?? null,
                                    'waktu_panen' => $item->waktu_panen,
                                    'jumlah_berat_kp_kg' => $item->jumlah_berat_kp_kg,
                                    'jumlah_kepala_keluarga_kp_kk' => $item->jumlah_kepala_keluarga_kp_kk,
                                    'jumlah_orang_kp' => $item->jumlah_orang_kp,
                                    'jumlah_berat_dibagikan_stunting_kg' => $item->jumlah_berat_dibagikan_stunting_kg,
                                    'jumlah_kepala_keluarga_dibagikan_stunting' => $item->jumlah_kepala_keluarga_dibagikan_stunting,
                                    'jumlah_orang_dibagikan_stunting' => $item->jumlah_orang_dibagikan_stunting,
                                    'jumlah_berat_dibagikan_mm_kg' => $item->jumlah_berat_dibagikan_mm_kg,
                                    'jumlah_kepala_keluarga_dibagikan_mm' => $item->jumlah_kepala_keluarga_dibagikan_mm,
                                    'jumlah_orang_dibagikan_mm' => $item->jumlah_orang_dibagikan_mm,
                                    'jumlah_berat_dibagikan_lansia_kg' => $item->jumlah_berat_dibagikan_lansia_kg,
                                    'jumlah_kepala_keluarga_dibagikan_lansia' => $item->jumlah_kepala_keluarga_dibagikan_lansia,
                                    'jumlah_orang_dibagikan_lansia' => $item->jumlah_orang_dibagikan_lansia,
                                    'jumlah_berat_dibagikan_posyandu_kg' => $item->jumlah_berat_dibagikan_posyandu_kg,
                                    'jumlah_kepala_keluarga_dibagikan_posyandu' => $item->jumlah_kepala_keluarga_dibagikan_posyandu,
                                    'jumlah_orang_dibagikan_posyandu' => $item->jumlah_orang_dibagikan_posyandu,
                                    'jumlah_berat_dijual_kg' => $item->jumlah_berat_dijual_kg,
                                    'jumlah_orang_dijual' => $item->jumlah_orang_dijual,
                                    'harga_jual' => $item->harga_jual,
                                ];
                            }),
                            'total' => $total,
                        ] : null;
                    })
                    ->filter() // buang null
                    ->values(); // reset key
                    // dd($dataPanenPerKelurahan);
                    $dataBelumPanenPerKelurahan = $dataKelurahan->map(function ($items, $kelurahan) use ($selectedCommodity, $model, $columnName) {
                        $idKelompok = $items->pluck('id_kelompok')->toArray();
                        $data = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName) {
                            return $query->where($columnName, $selectedCommodity);
                        })
                                    ->whereIn('id_kelompok', $idKelompok)
                                    ->whereNull('waktu_panen')
                                    ->get();

                        // hitung total panen per kelurahan
                        $total = $data->sum($estHarvestAmountinKg ?? 'prakiraan_jumlah_panen');

                        // hanya return jika total > 0
                        return $total > 0 ? [
                            'kelurahan' => $kelurahan,
                            'data' => $data,
                            'total' => $total,
                        ] : null;
                    })
                    ->filter() // buang null
                    ->values();

                    $dataPanen7HariKedepan = $dataKelurahan->map(function ($items, $kelurahan) use ($selectedCommodity, $model, $columnName) {
                        $idKelompok = $items->pluck('id_kelompok')->toArray();
                        $startRange = Carbon::now();
                        $endRange = $startRange->copy()->addDays(7);
                        $data = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName) {
                            return $query->where($columnName, $selectedCommodity);
                        })
                                    ->whereIn('id_kelompok', $idKelompok)
                                    ->whereBetween('waktu_prakiraan_panen', [$startRange, $endRange])
                                    ->get();

                        // hitung total panen per kelurahan
                        $total = $data->sum($estHarvestAmountinKg ?? 'prakiraan_jumlah_panen');

                        // hanya return jika total > 0
                        return $total > 0 ? [
                            'kelurahan' => $kelurahan,
                            'data' => $data,
                            'total' => $total,
                        ] : null;
                    })
                    ->filter() // buang null
                    ->values();
                    $totalHarvestPerKec = $dataPerKecamatan->sum($harvestColumn);
                    $totalHarvest = $dataTotal->sum($harvestColumn);
                    $totalEstHarvest = $dataPerKecamatan->sum($estHarvestAmountinKg);
                    $belumPaneninSeed = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName, $dataKelompok) {
                        return $query->where($columnName, $selectedCommodity)
                                    ->whereIn('id_kelompok', $dataKelompok)
                                    ->whereNull('waktu_panen');
                    })->sum($estHarvestAmountinSeed);
                    $belumPaneninKg = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName, $dataKelompok) {
                        return $query->where($columnName, $selectedCommodity)
                                    ->whereIn('id_kelompok', $dataKelompok)
                                    ->whereNull('waktu_panen');
                    })->sum('prakiraan_jumlah_panen');
                }
                // $dataDetailPanen = $model::when($selectedCommodity, function($query) use ($selectedCommodity, $columnName, ))
                $dataTelatPanenPerKelurahan = $dataKelurahan->map(function ($items, $kelurahan) use ($selectedCommodity, $model, $columnName) {
                    $idKelompok = $items->pluck('id_kelompok')->toArray();
                    $now = Carbon::now();
                    $data = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName) {
                        return $query->where($columnName, $selectedCommodity);
                    })
                                ->whereIn('id_kelompok', $idKelompok)
                                ->whereNull('waktu_panen')
                                ->where('waktu_prakiraan_panen', '>', $now)
                                ->get();

                    // hitung total panen per kelurahan
                    $total = $data->sum($estHarvestAmountinKg ?? 'prakiraan_jumlah_panen');

                    // hanya return jika total > 0
                    return $total > 0 ? [
                        'kelurahan' => $kelurahan,
                        'data' => $data,
                        'total' => $total,
                    ] : null;
                })
                ->filter() // buang null
                ->values();
                $gambar = DataKomoditi::where('nama_komoditi', $selectedCommodity)
                                        ->value('gambar');
                $terlambatPanen = $model::when($selectedCommodity, function ($query) use ($selectedCommodity, $columnName, $dataKelompok) {
                    $now = Carbon::now();

                    return $query->where($columnName, $selectedCommodity)
                                ->whereIn('id_kelompok', $dataKelompok)
                                ->whereNull('waktu_panen')
                                ->where('waktu_prakiraan_panen', '>', $now);
                })->sum($estHarvestAmountinKg);
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error('Invalid query in sector map: '.$e->getMessage());
            }
        }

        return view('home.sector', compact(
            'commodity', 'districts', 'selectedCommodity',
            'totalHarvest', 'totalHarvestPerKec', 'sector', 'belumPaneninSeed',
            'dataPanenPerKelurahan', 'terlambatPanen', 'dataTotal', 'dataBelumPanenPerKelurahan',
            'dataTelatPanenPerKelurahan', 'startDate', 'endDate', 'dataPanen7HariKedepan', 'belumPaneninKg', 'gambar', 'page'
        ));
    }
}
