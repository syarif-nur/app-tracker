<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Manajemen Role</h2>
    <div class="mb-6">
        @if($canCreate)
            <button wire:click="startAdd" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 mb-2">Tambah Role</button>
        @endif
    </div>
    <div class="overflow-x-auto bg-white rounded shadow mb-8">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Role</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Menu</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($roles as $role)
                    <tr>
                        <td class="px-4 py-2">{{ $role->name }}</td>
                        <td class="px-4 py-2">
                            @foreach($role->menus as $menu)
                                <div>
                                    <span class="font-semibold">{{ $menu->name }}</span>
                                    <span class="text-xs text-gray-500 ml-2">
                                        @foreach($permissionTypes as $perm)
                                            @if($menu->pivot && $menu->pivot[$perm])
                                                <span class="bg-green-100 text-green-700 px-1 rounded mr-1">{{ str_replace('can_', '', $perm) }}</span>
                                            @endif
                                        @endforeach
                                    </span>
                                </div>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">
                            @if($canEdit)
                                <button wire:click="startEdit('{{ $role->id }}')" class="text-blue-600 hover:underline mr-2">Edit</button>
                            @endif
                            @if($canDelete)
                                <button wire:click="deleteRole('{{ $role->id }}')" class="text-red-600 hover:underline">Hapus</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add/Edit Role Form -->
    <div class="bg-white rounded shadow-lg p-6 w-full max-w-2xl mx-auto mb-8" wire:ignore.self @if(!$editMode && !$name) style="display:none;" @endif>
        <h3 class="text-lg font-bold mb-4">{{ $editMode ? 'Edit Role' : 'Tambah Role' }}</h3>
        <form wire:submit.prevent="saveRole">
            <div class="mb-3">
                <label class="block mb-1 font-medium">Nama Role</label>
                <input type="text" wire:model.defer="name" class="w-full border rounded px-3 py-2" />
                @error('name')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="block mb-1 font-medium">Menu & Hak Akses</label>
                <div class="space-y-2">
                    @foreach($menus as $menu)
                        <div class="border rounded p-2">
                            <label class="font-semibold">
                                <input type="checkbox" wire:model="selectedMenus" value="{{ $menu->id }}" class="mr-2">
                                {{ $menu->name }}
                            </label>
                            <div class="ml-6 mt-1 flex flex-wrap gap-2">
                                @foreach($permissionTypes as $perm)
                                    <label class="inline-flex items-center text-xs">
                                        <input type="checkbox" wire:model="permissions.{{ $menu->id }}.{{ $perm }}" value="1" class="mr-1" @if(!in_array($menu->id, $selectedMenus)) disabled @endif>
                                        {{ strtoupper(str_replace('can_', '', $perm)) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="button" wire:click="startAdd" class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</button>
                @if((!$editMode && $canCreate) || ($editMode && $canEdit))
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                @else
                    <button type="button" class="bg-blue-300 text-white px-4 py-2 rounded cursor-not-allowed" disabled>Simpan</button>
                @endif
            </div>
        </form>
    </div>
</div>
