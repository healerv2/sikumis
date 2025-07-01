<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data =  User::orderBy('id', 'desc')->get();
            return datatables()
                ->of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($data) {
                    return '
                   <button type="button" data-id="' . $data->id . '" class="edit-users btn btn-sm btn-info"><i class="fa fa-edit"></i></button>
                   <button type="button" data-id="' . $data->id . '" class="delete-users btn btn-sm btn-danger"> <i class="fa fa-trash"></i></button>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {

            $find = User::where('email', $request->email)->first();
            if ($find != null) {
                return response()->json([
                    'success' => 409,
                    'message' => 'User sudah tersimpan!'
                ], 409);
            }


            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->nik = $request->nik;
            $user->usia = $request->usia;
            $user->alamat = $request->alamat;
            $user->level = $request->level;
            $user->status_users = 1;
            $user->kategori_risiko = $request->kategori_risiko;
            $user->foto = 'user.jpg';
            $user->password = bcrypt('password');
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'User berhasil ditambahkan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan saat memproses menambahkan ODC.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->nik = $request->nik;
            $user->usia = $request->usia;
            $user->alamat = $request->alamat;
            $user->level = $request->level;
            $user->kategori_risiko = $request->kategori_risiko;

            if ($request->has('password') && $request->password != "") {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'User berhasil diperbarui'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal memperbarui user',
                'error' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
}
