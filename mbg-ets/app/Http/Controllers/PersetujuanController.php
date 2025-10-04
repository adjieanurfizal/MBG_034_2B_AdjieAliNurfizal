<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersetujuanController extends Controller
{
    // Menampilkan semua permintaan yang statusnya 'menunggu'
    public function index()
    {
        // with('pemohon') -> Eager loading untuk mengambil data user pemohon
        $permintaanMenunggu = Permintaan::with('pemohon')->where('status', 'menunggu')->latest()->get();
        return view('persetujuan.index', ['permintaanMenunggu' => $permintaanMenunggu]);
    }

    // Menampilkan detail satu permintaan
    public function show($id)
    {
        // Eager loading untuk detail dan bahan baku sekaligus
        $permintaan = Permintaan::with('details.bahanBaku', 'pemohon')->findOrFail($id);
        return view('persetujuan.show', ['permintaan' => $permintaan]);
    }

    // Memproses aksi (Setuju / Tolak)
    public function proses(Request $request, $id)
    {
        $request->validate(['aksi' => 'required|in:disetujui,ditolak']);
        
        $permintaan = Permintaan::findOrFail($id);

        try {
            DB::transaction(function () use ($request, $permintaan) {
                if ($request->aksi == 'disetujui') {
                    // Loop setiap detail bahan baku yang diminta
                    foreach ($permintaan->details as $detail) {
                        $bahan = BahanBaku::find($detail->bahan_id);

                        // Cek ketersediaan stok
                        if ($bahan->jumlah < $detail->jumlah_diminta) {
                            // Jika stok kurang, batalkan transaksi dan beri pesan error
                            throw new \Exception("Stok untuk " . $bahan->nama . " tidak mencukupi.");
                        }

                        // Kurangi stok
                        $bahan->jumlah -= $detail->jumlah_diminta;
                        $bahan->save();
                    }
                }
                
                // Update status permintaan
                $permintaan->status = $request->aksi;
                $permintaan->save();
            });
            
            return redirect()->route('persetujuan.index')->with('success', 'Permintaan berhasil diproses!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses permintaan: ' . $e->getMessage());
        }
    }
}