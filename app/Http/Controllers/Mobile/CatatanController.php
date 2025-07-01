<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CatatanController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();

        $catatanHariIni = $user->catatanHarian()
            ->whereDate('tanggal', today())
            ->first();

        return view('mobile.home.catatan', compact('catatanHariIni'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string|max:1000',
            'status_minum' => 'required|boolean',
        ]);

        $user->catatanHarian()->updateOrCreate(
            ['tanggal' => $validated['tanggal']],
            [
                'catatan' => $validated['catatan'] ?? null,
                'status_minum' => $validated['status_minum'],
            ]
        );

        return redirect()->back()->with('success', 'Catatan berhasil disimpan.');
    }

    // public function store(Request $request)
    // {
    //     $user = auth()->user();

    //     $validated = $request->validate([
    //         'tanggal' => 'required|date',
    //         'catatan' => 'nullable|string|max:1000',
    //         'status_minum' => 'required|boolean',
    //     ]);

    //     $user->catatanHarian()->create([
    //         'tanggal' => $validated['tanggal'],
    //         'catatan' => $validated['catatan'] ?? null,
    //         'status_minum' => $validated['status_minum'],
    //     ]);

    //     return redirect()->back()->with('success', 'Catatan berhasil disimpan.');
    // }
}
