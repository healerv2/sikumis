<?php

namespace App\Exports;

use App\Models\CatatanHarian;
use App\Models\Suplemen;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;

        $data = CatatanHarian::with('user')
            ->when(
                $request->input('periode') === 'harian',
                fn($q) =>
                $q->whereDate('tanggal', $request->input('tanggal', now()->toDateString()))
            )
            ->when(
                $request->input('periode') === 'mingguan',
                fn($q) =>
                $q->whereBetween('tanggal', [now()->subDays(7), now()])
            )
            ->when(
                $request->input('periode') === 'bulanan',
                fn($q) =>
                $q->whereMonth('tanggal', now()->month)
            )
            ->get();

        return view('laporan.excel', [
            'data' => $data
        ]);
    }
}
