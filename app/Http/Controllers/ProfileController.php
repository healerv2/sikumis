<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;


class ProfileController
{
    //
    public function profil()
    {
        $profil = User::whereId(Auth::id())->first();

        return view('profile.index', compact('profil'));
    }

    public function update(Request $request, string $id)
    {
        try {

            $profile = User::find($id);
            $profile->name          = $request->name;
            $profile->email         = $request->email;
            $profile->phone         = $request->phone;

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $nama = 'foto-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('/img'), $nama);

                $profile->foto = $nama;
            }

            if ($request->has('password') && $request->password != "") {
                if (Hash::check($request->old_password, $profile->password)) {
                    if ($request->password == $request->password_confirmation) {
                        $profile->password = bcrypt($request->password);
                    } else {
                        return back()->with('error', 'Konfirmasi password tidak sesuai ');
                    }
                } else {
                    return back()->with('error', 'Password lama tidak sesuai ');
                }
            }
            $profile->updated_at      =  Carbon::now();

            $profile->save();

            return back()->with('message', 'Profile ' . $request->name . ' updated successfully');
        } catch (\Throwable $th) {
            //return redirect()->back()->with('error', 'Terjadi kesalahan sistem. code 500');

            return redirect()->back()->with(
                'error',
                json_encode($th->getMessage(), true)
            );
        }
    }
}
