<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermintaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil hanya bahan baku yang stoknya ada dan belum kadaluarsa
        $bahanTersedia = BahanBaku::where('jumlah', '>', 0)
                                    ->whereDate('tanggal_kadaluarsa', '>', now())
                                    ->orderBy('nama', 'asc')
                                    ->get();

        return view('permintaan.create', ['bahanTersedia' => $bahanTersedia]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'tgl_masak' => 'required|date|after_or_equal:today',
            'menu_makan' => 'required|string|max:255',
            'jumlah_porsi' => 'required|integer|min:1',
            'bahan_id' => 'required|array', // Pastikan bahan_id adalah array
            'bahan_id.*' => 'required|exists:bahan_baku,id', // Setiap item di array harus ada di tabel bahan_baku
            'jumlah_diminta' => 'required|array',
            'jumlah_diminta.*' => 'required|integer|min:1',
        ]);

        try {
            // 2. Gunakan Transaction untuk menjaga konsistensi data
            DB::transaction(function () use ($request) {
                // 3. Simpan data utama ke tabel 'permintaan'
                $permintaan = Permintaan::create([
                    'pemohon_id' => Auth::id(),
                    'tgl_masak' => $request->tgl_masak,
                    'menu_makan' => $request->menu_makan,
                    'jumlah_porsi' => $request->jumlah_porsi,
                    'status' => 'menunggu', // Status awal
                ]);

                // 4. Loop dan simpan setiap item bahan ke 'permintaan_detail'
                foreach ($request->bahan_id as $index => $bahanId) {
                    $permintaan->details()->create([
                        'bahan_id' => $bahanId,
                        'jumlah_diminta' => $request->jumlah_diminta[$index],
                    ]);
                }
            });

            return redirect()->route('dashboard')->with('success', 'Permintaan bahan baku berhasil dibuat!');

        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan ke form dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
