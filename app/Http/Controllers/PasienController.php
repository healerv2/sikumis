<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PasienController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::where('level', 2); // Hanya data pasien

            if ($request->filled('nama')) {
                $query->where('name', 'like', '%' . $request->nama . '%');
            }

            if ($request->filled('nik')) {
                $query->where('nik', 'like', '%' . $request->nik . '%');
            }

            if ($request->filled('usia')) {
                $query->where('usia', $request->usia);
            }

            if ($request->filled('alamat')) {
                $query->where('alamat', 'like', '%' . $request->alamat . '%');
            }

            if ($request->filled('status_users')) {
                $query->where('status_users', $request->status_users);
            }

            if ($request->filled('kategori_risiko')) {
                $query->where('kategori_risiko', $request->kategori_risiko);
            }

            return datatables()
                ->of($query->orderByDesc('id'))
                ->addIndexColumn()
                ->addColumn(
                    'kategori_risiko',
                    fn($row) =>
                    $row->kategori_risiko
                        ? ucfirst($row->kategori_risiko)
                        : '<span class="text-muted">-</span>'
                )
                ->addColumn(
                    'status',
                    fn($row) =>
                    $row->status_users
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-secondary">Nonaktif</span>'
                )
                ->rawColumns(['status', 'kategori_risiko']) // pastikan ini untuk badge/rich HTML
                ->make(true);
        }

        return view('pasien.index');
    }
}
