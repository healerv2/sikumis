<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    //
    public function edit()
    {
        $user = auth()->user();
        return view('mobile.home.settings', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if ($request->ajax === 'toggle_notifikasi') {
            $user->notifikasi = (bool) $request->notifikasi;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Pengaturan notifikasi berhasil diperbarui'
            ]);
        }

        if ($request->ajax === 'vitamin') {
            $request->validate([
                'jam' => 'required',
                'interval' => 'required|integer',
            ]);

            $user->update([
                'jam' => $request->jam,
                'interval' => $request->interval,
            ]);

            return redirect()->back()->with('success', 'Pengaturan vitamin berhasil disimpan.');
        }

        return redirect()->back();
    }





    // public function update(Request $request)
    // {
    //     $user = auth()->user();

    //     $data = [];

    //     // Cek apakah masing-masing kolom dikirim, baru dimasukkan
    //     if ($request->has('notifikasi')) {
    //         $data['notifikasi'] = $request->boolean('notifikasi');
    //     }

    //     if ($request->filled('jam')) {
    //         $data['jam'] = $request->jam;
    //     }

    //     if ($request->filled('interval')) {
    //         $data['interval'] = $request->interval;
    //     }

    //     if ($request->filled('timezone')) {
    //         $data['timezone'] = $request->timezone;
    //     }

    //     // Hapus ini jika tidak ingin ubah nama
    //     if ($request->filled('name')) {
    //         $data['name'] = $request->name;
    //     }

    //     $user->update($data);

    //     return redirect()->route('mobile.settings.edit')->with('success', 'Pengaturan berhasil diperbarui.');
    // }


    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nik' => 'required|string|max:20',
            'usia' => 'required|integer|min:0|max:120',
            'phone' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:255',
            //'foto' => 'nullable|image|max:2048', // max 2MB
        ]);

        // Update foto jika diunggah
        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::exists($user->foto)) {
                Storage::delete($user->foto);
            }
            $validated['foto'] = $request->file('foto')->store('user_foto', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Data profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
