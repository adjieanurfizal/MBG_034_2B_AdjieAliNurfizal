<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Permintaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                     @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Gagal!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <h3 class="text-lg font-bold">Informasi Permintaan</h3>
                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <p><strong>Pemohon:</strong> {{ $permintaan->pemohon->name }}</p>
                        <p><strong>Tanggal Masak:</strong> {{ \Carbon\Carbon::parse($permintaan->tgl_masak)->format('d M Y') }}</p>
                        <p><strong>Menu:</strong> {{ $permintaan->menu_makan }}</p>
                        <p><strong>Jumlah Porsi:</strong> {{ $permintaan->jumlah_porsi }}</p>
                    </div>

                    <hr class="my-6 border-gray-600">

                    <h3 class="text-lg font-bold">Bahan Baku yang Diminta</h3>
                    <ul class="list-disc list-inside mt-4">
                        @foreach ($permintaan->details as $detail)
                            <li>{{ $detail->bahanBaku->nama }}: <strong>{{ $detail->jumlah_diminta }} {{ $detail->bahanBaku->satuan }}</strong></li>
                        @endforeach
                    </ul>

                    <hr class="my-6 border-gray-600">

                    <form action="{{ route('persetujuan.proses', $permintaan->id) }}" method="POST">
                        @csrf
                        <div class="flex items-center justify-end space-x-4">
                            <button type="submit" name="aksi" value="ditolak" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('Anda yakin ingin menolak permintaan ini?')">
                                Tolak
                            </button>
                            <button type="submit" name="aksi" value="disetujui" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700" onclick="return confirm('Anda yakin ingin menyetujui permintaan ini? Stok akan otomatis berkurang.')">
                                Setujui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>