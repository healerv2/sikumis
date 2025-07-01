<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController
{
    //
    public function index()
    {
        $settings = Settings::first();

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        try {

            $setting = Settings::first();
            $setting->nama_aplikasi    = $request->nama_aplikasi;

            if ($request->hasFile('path_logo')) {
                $file = $request->file('path_logo');
                $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('/logo'), $nama);

                $setting->path_logo = $nama;
            }

            $setting->update();

            return redirect()->route('settings.index')->with('message', 'Settings updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. code 500');
        }
    }
}
