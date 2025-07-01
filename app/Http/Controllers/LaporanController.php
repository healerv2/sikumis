<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CatatanHarian;
use App\Models\User;
use App\Models\Suplemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {

        $listNama = User::where('level', 2)
            ->pluck('name')
            ->unique()
            ->sort()
            ->values();
        $filterTanggal = $request->input('tanggal') ?? today()->toDateString();
        $filterInterval = $request->input('interval', 'harian');

        $data = CatatanHarian::with('user')
            ->when($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai'), function ($query) use ($request) {
                $query->whereBetween('tanggal', [
                    $request->tanggal_mulai,
                    $request->tanggal_selesai
                ]);
            })
            ->when($request->input('periode') === 'harian' && $request->filled('tanggal_mulai') && !$request->filled('tanggal_selesai'), function ($query) use ($request) {
                $query->whereDate('tanggal', $request->tanggal_mulai);
            })
            ->when($request->input('periode') === 'mingguan', function ($q) {
                $q->whereBetween('tanggal', [now()->subDays(7), now()]);
            })
            ->when($request->input('periode') === 'bulanan', function ($q) {
                $q->whereMonth('tanggal', now()->month);
            })
            ->when($request->filled('nama'), function ($query) use ($request) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->nama . '%');
                });
            })
            ->when($request->filled('usia'), function ($query) use ($request) {
                $usia = $request->usia;
                $query->whereHas('user', function ($q) use ($usia) {
                    if ($usia == '20') {
                        $q->where('usia', '<', 20);
                    } elseif ($usia == '20-30') {
                        $q->whereBetween('usia', [20, 30]);
                    } elseif ($usia == '31-40') {
                        $q->whereBetween('usia', [31, 40]);
                    } elseif ($usia == '41') {
                        $q->where('usia', '>', 40);
                    }
                });
            })
            ->get();

        $statistik = [
            'umur' => $data->groupBy(fn($item) => $item->user->usia)->map->count(),
            'wilayah' => $data->groupBy(fn($item) => $item->user->alamat)->map->count(),
            'suplemen' => Suplemen::withCount('users')->get()->pluck('users_count', 'nama'),
        ];

        return view('laporan.index', compact('data', 'statistik', 'filterTanggal', 'filterInterval', 'listNama'));
    }

    // public function exportExcel(Request $request)
    // {
    //     return Excel::download(new LaporanExport($request), time() . "-" . 'laporan.xlsx');
    // }

    public function exportExcel(Request $request)
    {
        $query = CatatanHarian::with('user');

        if ($request->filled('nama')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter tanggal range
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [
                $request->tanggal_mulai,
                $request->tanggal_selesai
            ]);
        }

        // Filter periode default
        if ($request->periode === 'mingguan') {
            $query->whereBetween('tanggal', [now()->subDays(7), now()]);
        } elseif ($request->periode === 'bulanan') {
            $query->whereMonth('tanggal', now()->month);
        }

        // Filter usia
        if ($request->filled('usia')) {
            $usia = $request->usia;
            $query->whereHas('user', function ($q) use ($usia) {
                if ($usia == '20') {
                    $q->where('usia', '<', 20);
                } elseif ($usia == '20-30') {
                    $q->whereBetween('usia', [20, 30]);
                } elseif ($usia == '31-40') {
                    $q->whereBetween('usia', [31, 40]);
                } elseif ($usia == '41') {
                    $q->where('usia', '>', 40);
                }
            });
        }

        $data = $query->get();

        return Excel::download(new LaporanExport($request), time() . "-" . 'laporan.xlsx');
    }
}
