<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Suplemen;
use App\Models\CatatanHarian;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        // $filterUsia = $request->input('usia');
        // $filterWilayah = $request->input('wilayah');
        // $filterSuplemen = $request->input('suplemen');

        // // Base query user level 2
        // $userQuery = User::query()->where('level', 2);

        // // Filter usia
        // if ($filterUsia) {
        //     if ($filterUsia === '20') {
        //         $userQuery->where('usia', '<', 20);
        //     } elseif ($filterUsia === '20-30') {
        //         $userQuery->whereBetween('usia', [20, 30]);
        //     } elseif ($filterUsia === '31-40') {
        //         $userQuery->whereBetween('usia', [31, 40]);
        //     } elseif ($filterUsia === '41') {
        //         $userQuery->where('usia', '>', 40);
        //     }
        // }

        // // Filter wilayah
        // if ($filterWilayah) {
        //     $userQuery->where('alamat', 'like', "%$filterWilayah%");
        // }

        // // Filter berdasarkan suplemen
        // if ($filterSuplemen) {
        //     $userQuery->whereHas('suplemen', function ($q) use ($filterSuplemen) {
        //         $q->where('suplemen_id', $filterSuplemen);
        //     });
        // }

        // // Clone untuk reusability
        // $filteredUsers = clone $userQuery;

        // // Ambil ID user hasil filter
        // $userIds = $filteredUsers->pluck('id');

        // // Hitung total user aktif
        // $totalUserAktif = (clone $userQuery)->where('status_users', 1)->count();

        // // Hitung total catatan, patuh, tidak patuh
        // $totalCatatan = CatatanHarian::whereIn('user_id', $userIds)->count();
        // $totalPatuh = CatatanHarian::whereIn('user_id', $userIds)->where('status_minum', 1)->count();
        // $totalTidakPatuh = CatatanHarian::whereIn('user_id', $userIds)->where('status_minum', 0)->count();

        // // Hitung tingkat kepatuhan (%)
        // $tingkatKepatuhan = $totalCatatan > 0 ? round(($totalPatuh / $totalCatatan) * 100, 2) : 0;

        // // Dropdown options
        // $suplemenList = Suplemen::pluck('nama', 'id');
        // $wilayahList = User::where('level', 2)->pluck('alamat')->unique()->filter()->values();

        $filterUsia = $request->input('usia');
        $filterWilayah = $request->input('wilayah');
        $filterSuplemen = $request->input('suplemen');

        $usersQuery = User::where('level', 2);

        if ($filterUsia) {
            if ($filterUsia == '20') {
                $usersQuery->where('usia', '<', 20);
            } elseif ($filterUsia == '20-30') {
                $usersQuery->whereBetween('usia', [20, 30]);
            } elseif ($filterUsia == '31-40') {
                $usersQuery->whereBetween('usia', [31, 40]);
            } elseif ($filterUsia == '41') {
                $usersQuery->where('usia', '>', 40);
            }
        }

        if ($filterWilayah) {
            $usersQuery->where('alamat', 'like', "%$filterWilayah%");
        }

        if ($filterSuplemen) {
            $usersQuery->whereHas('suplemen', function ($query) use ($filterSuplemen) {
                $query->where('suplemen_id', $filterSuplemen);
            });
        }

        $userIds = $usersQuery->pluck('id'); // ID user yang difilter

        $totalUserAktif = User::whereIn('id', $userIds)->where('status_users', 1)->count();
        $totalCatatan = CatatanHarian::whereIn('user_id', $userIds)->count();
        $totalPatuh = CatatanHarian::whereIn('user_id', $userIds)->where('status_minum', 1)->count();
        $totalTidakPatuh = CatatanHarian::whereIn('user_id', $userIds)->where('status_minum', 0)->count();

        $tingkatKepatuhan = $totalCatatan > 0
            ? round(($totalPatuh / $totalCatatan) * 100, 2)
            : 0;

        // Grafik mingguan (7 hari terakhir)
        $grafikLabels = [];
        $grafikData = [];
        $periode = CarbonPeriod::create(now()->subDays(6), now());

        foreach ($periode as $tanggal) {
            $grafikLabels[] = $tanggal->format('d M');
            $jumlahCatatan = CatatanHarian::whereIn('user_id', $userIds)
                ->whereDate('tanggal', $tanggal)
                ->count();
            $jumlahPatuh = CatatanHarian::whereIn('user_id', $userIds)
                ->whereDate('tanggal', $tanggal)
                ->where('status_minum', 1)
                ->count();
            $persentase = $jumlahCatatan > 0 ? round(($jumlahPatuh / $jumlahCatatan) * 100, 2) : 0;
            $grafikData[] = $persentase;
        }

        // Filter list
        $suplemenList = Suplemen::pluck('nama', 'id');
        $wilayahList = User::where('level', 2)->pluck('alamat')->unique();



        if (auth()->user()->level == 1) {
            return view('admin.dashboard', compact(
                'totalUserAktif',
                'totalCatatan',
                'totalPatuh',
                'totalTidakPatuh',
                'tingkatKepatuhan',
                'suplemenList',
                'wilayahList',
                'filterUsia',
                'filterWilayah',
                'filterSuplemen',
                'grafikLabels',
                'grafikData'
            ));
        } else {
            $user = auth()->user()->load('notificationSetting', 'suplemen');
            $catatanHariIni = $user->catatanHarian()
                ->whereDate('tanggal', today())
                ->first();
            $posts = Post::with('user')->latest()->get();
            $waktu = $user->notificationSetting?->waktu_notifikasi ?? '08:00';

            $jadwalHariIni = $user->suplemen->map(function ($item) use ($waktu) {
                return [
                    'nama' => $item->nama,
                    'jam' => \Carbon\Carbon::parse($waktu)->format('H:i'),
                ];
            });

            //dd($user->toArray());
            //return view('mobile.home.index');
            return view('mobile.home.index', compact('catatanHariIni', 'posts', 'jadwalHariIni'));
        }
    }
}
