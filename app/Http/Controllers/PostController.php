<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::with('user')->latest()->get();

            return datatables()
                ->of($posts)
                ->addIndexColumn()
                ->addColumn('deskripsi', function ($row) {
                    return strip_tags(Str::limit($row->deskripsi, 100));
                })
                ->addColumn('lampiran', function ($row) {
                    if (!$row->lampiran) return '-';
                    $ext = pathinfo($row->lampiran, PATHINFO_EXTENSION);
                    if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                        return '<img src="' . asset("storage/{$row->lampiran}") . '" width="50">';
                    } elseif ($ext === 'pdf') {
                        return '<a href="' . asset("storage/{$row->lampiran}") . '" target="_blank">PDF</a>';
                    } elseif ($ext === 'mp4') {
                        return '<video src="' . asset("storage/{$row->lampiran}") . '" width="80" controls></video>';
                    }
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <button class="btn btn-info btn-sm edit-post" data-id="' . $row->id . '"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm delete-post" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>
                        <button class="btn btn-secondary btn-sm view-post" data-id="' . $row->id . '"><i class="fa fa-eye"></i></button>
                    ';
                })
                ->rawColumns(['lampiran', 'aksi'])
                ->make(true);
        }

        return view('posts.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:20480' // max 20MB
        ]);

        try {
            if (Auth::user()->level != 1) {
                return response()->json([
                    'message' => 'Hanya user level 1 yang dapat membuat postingan.'
                ], 403);
            }

            $post = new Post();
            $post->user_id = Auth::id();
            $post->judul = $request->judul;
            $post->deskripsi = $request->deskripsi;

            if ($request->hasFile('lampiran')) {
                $file = $request->file('lampiran');
                $filename = time() . '-' . $file->getClientOriginalName();
                $path = $file->storeAs('lampiran', $filename, 'public');
                $post->lampiran = $path;
            }

            $post->save();

            return response()->json([
                'status' => 200,
                'message' => 'Post berhasil disimpan.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal menyimpan post.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }


    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:20480'
        ]);

        try {
            $post = Post::findOrFail($id);
            $post->judul = $request->judul;
            $post->deskripsi = $request->deskripsi;

            if ($request->hasFile('lampiran')) {
                // hapus file lama jika ada
                if ($post->lampiran && Storage::disk('public')->exists($post->lampiran)) {
                    Storage::disk('public')->delete($post->lampiran);
                }

                $file = $request->file('lampiran');
                $filename = time() . '-' . $file->getClientOriginalName();
                $path = $file->storeAs('lampiran', $filename, 'public');
                $post->lampiran = $path;
            }

            $post->save();

            return response()->json([
                'status' => 200,
                'message' => 'Post berhasil diperbarui.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal memperbarui post.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->lampiran && Storage::disk('public')->exists($post->lampiran)) {
                Storage::disk('public')->delete($post->lampiran);
            }

            $post->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Post berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal menghapus post.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
