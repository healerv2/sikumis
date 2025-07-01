<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Suplemen;
use App\Models\NotificationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $suplemens = Suplemen::where('status', 'digunakan')->get();
        $setting = $user->notificationSetting;
        $selectedSuplemen = $user->suplemen()->pluck('suplemens.id')->toArray();

        return view('mobile.home.jadwal', compact('user', 'suplemens', 'setting', 'selectedSuplemen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'waktu_notifikasi' => 'required|date_format:H:i',
            'interval' => 'required|in:15_menit,30_menit,45_menit,1_jam,2_jam,6_jam,12_jam,1_hari,2_hari,mingguan',
            'status' => 'required|boolean',
        ]);

        $user = Auth::user();

        DB::beginTransaction();
        try {
            NotificationSetting::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'waktu_notifikasi' => $request->waktu_notifikasi,
                    'interval' => $request->interval,
                    'status' => $request->status,
                    'last_notified_at' => now(),
                ]
            );

            DB::commit();

            return back()->with('success', 'Pengaturan jadwal berhasil disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan pengaturan: ' . $th->getMessage());
        }
    }
}
