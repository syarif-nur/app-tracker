<div class="p-4" x-data="{ openAdd: false, openEdit: false, openDelete: false, deleteId: null }">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Manajemen Pengguna</h2>
        <button @click="openAdd = true" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Tambah Pengguna</button>
    </div>

    <!-- Tabel User -->
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Departemen</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->role->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $user->departemen->name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <button @click="$wire.startEdit('{{ $user->id }}'); openEdit = true" class="text-blue-600 hover:underline mr-2">Edit</button>
                            <button @click="deleteId = '{{ $user->id }}'; openDelete = true" class="text-red-600 hover:underline">Hapus</button>
                        </td>
    <!-- Edit User Modal -->
    <div x-show="openEdit" x-cloak @user-edited.window="openEdit = false" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Edit Pengguna</h3>
            <form wire:submit.prevent="updateUser">
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Nama</label>
                    <input type="text" wire:model.defer="name" class="w-full border rounded px-3 py-2" />
                    @error('name')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Email</label>
                    <input type="email" wire:model.defer="email" class="w-full border rounded px-3 py-2" />
                    @error('email')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" wire:model.defer="password" class="w-full border rounded px-3 py-2" />
                    @error('password')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Role</label>
                    <select wire:model.defer="role_id" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Departemen</label>
                    <select wire:model.defer="departemen_id" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Departemen</option>
                        @foreach($departemens as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                        @endforeach
                    </select>
                    @error('departemen_id')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" @click="openEdit = false" class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div x-show="openDelete" x-cloak @user-deleted.window="openDelete = false" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4 text-red-600">Hapus Pengguna</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus pengguna ini?</p>
            <div class="flex justify-end mt-4">
                <button type="button" @click="openDelete = false" class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</button>
                <button type="button" @click="$wire.deleteUser(deleteId); openDelete = false" class="bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
            </div>
        </div>
    </div>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah User (Livewire + Alpine.js) -->
    <div x-show="openAdd" x-cloak @user-added.window="openAdd = false" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded shadow-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">Tambah Pengguna</h3>
                <form wire:submit.prevent="createUser">
                    <div class="mb-3">
                        <label class="block mb-1 font-medium">Nama</label>
                        <input type="text" wire:model.defer="name" class="w-full border rounded px-3 py-2" />
                        @error('name')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1 font-medium">Email</label>
                        <input type="email" wire:model.defer="email" class="w-full border rounded px-3 py-2" />
                        @error('email')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1 font-medium">Password</label>
                        <input type="password" wire:model.defer="password" class="w-full border rounded px-3 py-2" />
                        @error('password')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1 font-medium">Role</label>
                        <select wire:model.defer="role_id" class="w-full border rounded px-3 py-2">
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1 font-medium">Departemen</label>
                        <select wire:model.defer="departemen_id" class="w-full border rounded px-3 py-2">
                            <option value="">Pilih Departemen</option>
                            @foreach($departemens as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                            @endforeach
                        </select>
                        @error('departemen_id')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" @click="openAdd = false" class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
