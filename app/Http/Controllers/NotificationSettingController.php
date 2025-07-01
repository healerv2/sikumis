<?php

namespace App\Http\Controllers;

use App\Events\NotificationUpdated;
use App\Notifications\VitaminReminder;
use App\Models\NotificationSetting;
use App\Models\User;
use App\Models\Suplemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationSettingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('level', 2)->with(['notificationSetting', 'suplemen'])->get();

            return datatables()->of($users)
                ->addIndexColumn()
                ->addColumn('suplemen', function ($row) {
                    return $row->suplemen->pluck('nama')->implode(', ');
                })
                ->addColumn('interval', fn($row) => $row->notificationSetting->interval ?? '-')
                ->addColumn('jam', fn($row) => $row->notificationSetting->waktu_notifikasi ?? '-')
                ->addColumn('status', function ($row) {
                    $status = $row->notificationSetting->status ?? false;
                    return $status
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-secondary">Nonaktif</span>';
                })
                ->addColumn('aksi', function ($row) {
                    return '<button class="btn btn-sm btn-primary edit-setting" data-id="' . $row->id . '">Atur</button>';
                })
                ->rawColumns(['status', 'aksi'])
                ->make(true);
        }

        $suplemen = Suplemen::where('status', 'digunakan')->get();
        return view('notifikasi.setting', compact('suplemen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            //'waktu_notifikasi' => 'required|date_format:H:i',
            'interval' => 'required|in:15_menit,30_menit,45_menit,1_jam,2_jam,6_jam,12_jam,1_hari,2_hari,mingguan',
            'status' => 'required|boolean',
            'suplemen_id' => 'required|array|min:1',
            'suplemen_id.*' => 'exists:suplemens,id',
        ]);

        DB::beginTransaction();
        try {
            NotificationSetting::updateOrCreate(
                ['user_id' => $request->user_id],
                [
                    'waktu_notifikasi' => $request->waktu_notifikasi,
                    'interval' => $request->interval,
                    'status' => $request->status,
                    'last_notified_at' => now(),
                ]
            );

            $user = User::findOrFail($request->user_id);
            $user->suplemen()->sync($request->suplemen_id);

            DB::commit();

            // Kirim notifikasi via Pusher
            event(new NotificationUpdated(
                $user->id,
                'Pengaturan Notifikasi Diperbarui',
                'Hai ' . $user->name . ', jadwal pengingat suplemen kamu telah diperbarui.'
            ));

            return response()->json(['status' => 200, 'message' => 'Pengaturan berhasil disimpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $user = User::with(['notificationSetting', 'suplemen'])->findOrFail($id);
        return response()->json($user);
    }
}
