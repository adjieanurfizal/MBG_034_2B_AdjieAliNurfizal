<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;

class BahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semuaBahanBaku = BahanBaku::all();
        return view('bahan_baku.index', ['bahan_baku' => $semuaBahanBaku]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bahan_baku.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:120',
            'kategori' => 'required|string|max:60',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:tanggal_masuk',
        ]);

        // Status awal adalah 'tersedia'
        $validated['status'] = 'tersedia';

        BahanBaku::create($validated);

        return redirect()->route('bahan-baku.index')->with('success', 'Bahan baku berhasil ditambahkan!');
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
    public function edit(BahanBaku $bahanBaku)
    {
        return view('bahan_baku.edit', ['bahan' => $bahanBaku]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BahanBaku $bahanBaku)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:120',
            'kategori' => 'required|string|max:60',
            'jumlah' => 'required|integer|min:0', // Aturan: stok tidak boleh < 0
            'satuan' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:tanggal_masuk',
        ]);
        
        // Cek jika jumlah jadi 0, status jadi 'habis'
        if ($validated['jumlah'] == 0) {
            $validated['status'] = 'habis';
        } else {
            // Jika tidak, biarkan status dihitung oleh accessor, tapi kita set 'tersedia' sebagai default
            $validated['status'] = 'tersedia';
        }


        $bahanBaku->update($validated);

        return redirect()->route('bahan-baku.index')->with('success', 'Stok bahan baku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BahanBaku $bahanBaku)
    {
        // Aturan: Hanya boleh hapus jika statusnya 'kadaluarsa'
        // Kita panggil accessor statusnya
        if ($bahanBaku->status == 'kadaluarsa') {
            $bahanBaku->delete();
            return redirect()->route('bahan-baku.index')->with('success', 'Bahan baku kadaluarsa berhasil dihapus.');
        }

        return redirect()->route('bahan-baku.index')->with('error', 'Hanya bahan baku yang sudah kadaluarsa yang boleh dihapus!');
    }
}
