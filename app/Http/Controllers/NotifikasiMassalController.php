<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use App\Events\SuplemenReminderSent;

class NotifikasiMassalController extends Controller
{
    public function index()
    {
        $users = User::where('level', 2)->where('status_users', 1)->get();
        return view('notifikasi.massal', compact('users'));
    }

    public function kirim(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pesan' => 'required|string',
            'url' => 'nullable|url',
            'users' => 'nullable|array',
        ]);

        $users = $request->filled('users')
            ? User::whereIn('id', $request->users)->get()
            : User::where('level', 2)->get();

        if ($users->isEmpty()) {
            return response()->json([
                'status' => 400,
                'message' => 'Tidak ada user yang ditemukan.',
            ], 400);
        }

        foreach ($users as $user) {
            broadcast(new SuplemenReminderSent(
                $user->id,
                $request->judul . ' - ' . $request->pesan
            ));
        }

        return response()->json([
            'status' => 200,
            'message' => 'Notifikasi berhasil dikirim ke ' . $users->count() . ' pengguna.'
        ]);
    }
}
