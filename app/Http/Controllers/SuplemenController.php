<?php

namespace App\Http\Controllers;

use App\Models\Suplemen;
use Illuminate\Http\Request;

class SuplemenController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Suplemen::orderBy('id', 'desc')->get();
            return datatables()
                ->of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status == 'digunakan') {
                        return '<span class="badge bg-success">Digunakan</span>';
                    } else {
                        return '<span class="badge bg-secondary">Tidak Digunakan</span>';
                    }
                })
                ->addColumn('aksi', function ($row) {
                    return '
                    <button class="btn btn-sm btn-info edit-suplemen" data-id="' . $row->id . '"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger delete-suplemen" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>
                    ';
                })
                ->rawColumns(['status', 'aksi'])
                ->make(true);
        }

        return view('suplemen.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'status' => 'required|in:digunakan,tidak',
        ]);

        try {
            if (Suplemen::where('nama', $request->nama)->exists()) {
                return response()->json([
                    'message' => 'Suplemen dengan nama tersebut sudah ada!'
                ], 409);
            }

            $suplemen = new Suplemen();
            $suplemen->nama = $request->nama;
            $suplemen->deskripsi = $request->deskripsi;
            $suplemen->status = $request->status;
            $suplemen->save();

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $th->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        $data = Suplemen::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'status' => 'required|in:digunakan,tidak',
        ]);

        try {
            $suplemen = Suplemen::findOrFail($id);

            if (Suplemen::where('nama', $request->nama)->where('id', '!=', $id)->exists()) {
                return response()->json([
                    'message' => 'Nama suplemen sudah digunakan!'
                ], 409);
            }

            $suplemen->nama = $request->nama;
            $suplemen->deskripsi = $request->deskripsi;
            $suplemen->status = $request->status;
            $suplemen->save();

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diperbarui'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan saat memperbarui data',
                'error' => $th->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        Suplemen::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
