<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Permintaan Bahan Baku Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Tgl Masak</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Menu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Porsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($permintaanSaya as $permintaan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($permintaan->tgl_masak)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $permintaan->menu_makan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $permintaan->jumlah_porsi }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                             @php
                                                $status = $permintaan->status;
                                                $badgeColor = '';
                                                if ($status == 'disetujui') $badgeColor = 'bg-green-500';
                                                elseif ($status == 'menunggu') $badgeColor = 'bg-yellow-500';
                                                else $badgeColor = 'bg-red-500';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }} text-white">
                                                {{ $status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center">Anda belum pernah membuat permintaan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>