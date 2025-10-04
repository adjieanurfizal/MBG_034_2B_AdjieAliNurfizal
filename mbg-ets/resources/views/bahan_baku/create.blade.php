<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Bahan Baku Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Form --}}
                    <form method="POST" action="{{ route('bahan-baku.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="nama" :value="__('Nama Bahan Baku')" />
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="kategori" :value="__('Kategori')" />
                            <x-text-input id="kategori" class="block mt-1 w-full" type="text" name="kategori" :value="old('kategori')" required />
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <x-input-label for="jumlah" :value="__('Jumlah')" />
                                <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" :value="old('jumlah')" required />
                                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="satuan" :value="__('Satuan (kg, liter, buah)')" />
                                <x-text-input id="satuan" class="block mt-1 w-full" type="text" name="satuan" :value="old('satuan')" required />
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <x-input-label for="tanggal_masuk" :value="__('Tanggal Masuk')" />
                                <x-text-input id="tanggal_masuk" class="block mt-1 w-full" type="date" name="tanggal_masuk" :value="old('tanggal_masuk')" required />
                                <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tanggal_kadaluarsa" :value="__('Tanggal Kadaluarsa')" />
                                <x-text-input id="tanggal_kadaluarsa" class="block mt-1 w-full" type="date" name="tanggal_kadaluarsa" :value="old('tanggal_kadaluarsa')" required />
                                <x-input-error :messages="$errors->get('tanggal_kadaluarsa')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>