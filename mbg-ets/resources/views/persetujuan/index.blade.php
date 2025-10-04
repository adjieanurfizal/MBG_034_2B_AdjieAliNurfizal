<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Permintaan Menunggu Persetujuan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Pemohon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Tgl Masak</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Menu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permintaanMenunggu as $permintaan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $permintaan->pemohon->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($permintaan->tgl_masak)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $permintaan->menu_makan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('persetujuan.show', $permintaan->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center">Tidak ada permintaan yang menunggu persetujuan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>