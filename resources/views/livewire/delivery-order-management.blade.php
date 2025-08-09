<div class="p-4" x-data="{ openAdd: false, openEdit: false, openDelete: false, deleteId: null }">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Manajemen Surat Jalan</h2>
        <button @click="openAdd = true" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Tambah Surat Jalan</button>
    </div>

    <!-- Search -->
    <div class="mb-4">
        <input type="text" wire:model.debounce.500ms="search" placeholder="Cari kode/destinasi..." class="border rounded px-3 py-2 w-full max-w-xs" />
    </div>

    <!-- Tabel Surat Jalan -->
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tujuan</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Lat</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Long</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr>
                        <td class="px-4 py-2">{{ $order->unique_code }}</td>
                        <td class="px-4 py-2">{{ $order->destination }}</td>
                        <td class="px-4 py-2">{{ $order->latitude }}</td>
                        <td class="px-4 py-2">{{ $order->longitude }}</td>
                        <td class="px-4 py-2">{{ $order->description }}</td>
                        <td class="px-4 py-2">
                            <button @click="$wire.startEdit('{{ $order->id }}'); openEdit = true" class="text-blue-600 hover:underline mr-2">Edit</button>
                            <button @click="deleteId = '{{ $order->id }}'; openDelete = true" class="text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">{{ $orders->links() }}</div>
    </div>

    <!-- Modal Tambah Surat Jalan -->
    <div x-show="openAdd" x-cloak @delivery-order-added.window="openAdd = false" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Tambah Surat Jalan</h3>
            <form wire:submit.prevent="createDeliveryOrder">
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Tujuan</label>
                    <input type="text" wire:model.defer="destination" class="w-full border rounded px-3 py-2" />
                    @error('destination')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Latitude</label>
                    <input type="text" wire:model.defer="latitude" class="w-full border rounded px-3 py-2" />
                    @error('latitude')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Longitude</label>
                    <input type="text" wire:model.defer="longitude" class="w-full border rounded px-3 py-2" />
                    @error('longitude')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Deskripsi</label>
                    <textarea wire:model.defer="description" class="w-full border rounded px-3 py-2"></textarea>
                    @error('description')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" @click="openAdd = false" class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Surat Jalan -->
    <div x-show="openEdit" x-cloak @delivery-order-updated.window="openEdit = false" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Edit Surat Jalan</h3>
            <form wire:submit.prevent="updateDeliveryOrder">
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Tujuan</label>
                    <input type="text" wire:model.defer="destination" class="w-full border rounded px-3 py-2" />
                    @error('destination')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Latitude</label>
                    <input type="text" wire:model.defer="latitude" class="w-full border rounded px-3 py-2" />
                    @error('latitude')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Longitude</label>
                    <input type="text" wire:model.defer="longitude" class="w-full border rounded px-3 py-2" />
                    @error('longitude')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Deskripsi</label>
                    <textarea wire:model.defer="description" class="w-full border rounded px-3 py-2"></textarea>
                    @error('description')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" @click="openEdit = false" class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus Surat Jalan -->
    <div x-show="openDelete" x-cloak @delivery-order-deleted.window="openDelete = false" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4 text-red-600">Hapus Surat Jalan</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus surat jalan ini?</p>
            <div class="flex justify-end mt-4">
                <button type="button" @click="openDelete = false" class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</button>
                <button type="button" @click="$wire.deleteDeliveryOrder(deleteId); openDelete = false" class="bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
            </div>
        </div>
    </div>
</div>
