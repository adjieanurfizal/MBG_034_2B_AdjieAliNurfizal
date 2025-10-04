<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Permintaan Bahan Baku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('permintaan.store') }}">
                        @csrf
                        
                        {{-- Form Utama --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="tgl_masak" :value="__('Tanggal Masak')" />
                                <x-text-input id="tgl_masak" class="block mt-1 w-full" type="date" name="tgl_masak" :value="old('tgl_masak')" required />
                                <x-input-error :messages="$errors->get('tgl_masak')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="menu_makan" :value="__('Menu yang Akan Dibuat')" />
                                <x-text-input id="menu_makan" class="block mt-1 w-full" type="text" name="menu_makan" :value="old('menu_makan')" required />
                                <x-input-error :messages="$errors->get('menu_makan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="jumlah_porsi" :value="__('Jumlah Porsi')" />
                                <x-text-input id="jumlah_porsi" class="block mt-1 w-full" type="number" name="jumlah_porsi" :value="old('jumlah_porsi')" required />
                                <x-input-error :messages="$errors->get('jumlah_porsi')" class="mt-2" />
                            </div>
                        </div>

                        <hr class="my-6 border-gray-600">

                        {{-- Daftar Bahan Baku --}}
                        <h3 class="font-semibold mb-4">Daftar Bahan Baku yang Dibutuhkan</h3>
                        <div id="bahan-list" class="space-y-4">
                            {{-- Baris-baris bahan akan ditambahkan oleh JavaScript di sini --}}
                        </div>

                        <div class="mt-4">
                            <button type="button" id="add-bahan-btn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                + Tambah Bahan
                            </button>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Kirim Permintaan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Template untuk baris bahan baku baru (dibuat tak terlihat oleh JS) --}}
    <template id="bahan-template">
        <div class="grid grid-cols-12 gap-4 items-center bahan-row">
            <div class="col-span-6">
                <select name="bahan_id[]" class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                    <option value="">-- Pilih Bahan Baku --</option>
                    @foreach ($bahanTersedia as $bahan)
                        <option value="{{ $bahan->id }}">{{ $bahan->nama }} (Stok: {{ $bahan->jumlah }} {{ $bahan->satuan }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-4">
                <x-text-input type="number" name="jumlah_diminta[]" class="block mt-1 w-full" placeholder="Jumlah" required />
            </div>
            <div class="col-span-2">
                <button type="button" class="remove-bahan-btn px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addBtn = document.getElementById('add-bahan-btn');
            const bahanList = document.getElementById('bahan-list');
            const template = document.getElementById('bahan-template');

            // Fungsi untuk menambah baris baru
            function addBahanRow() {
                const newRow = template.content.cloneNode(true);
                bahanList.appendChild(newRow);
            }

            // Tambah baris pertama saat halaman dimuat
            addBahanRow();

            // Event listener untuk tombol "Tambah Bahan"
            addBtn.addEventListener('click', addBahanRow);

            // Event listener untuk tombol "Hapus" (menggunakan event delegation)
            bahanList.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-bahan-btn')) {
                    // Cari parent terdekat (baris) dan hapus
                    e.target.closest('.bahan-row').remove();
                }
            });
        });
    </script>
</x-app-layout>