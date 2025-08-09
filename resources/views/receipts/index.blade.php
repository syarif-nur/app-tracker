<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Daftar Bukti Serah Terima</h2>
    <a href="{{ route('upload-proof.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 mb-4 inline-block">Tambah Bukti</a>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200 text-xs">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-2 py-2">Surat Jalan</th>
                    <th class="px-2 py-2">Penerima</th>
                    <th class="px-2 py-2">Foto</th>
                    <th class="px-2 py-2">Tanggal</th>
                    <th class="px-2 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($receipts as $receipt)
                    <tr>
                        <td class="px-2 py-1">{{ $receipt->deliveryOrder->unique_code ?? '-' }}</td>
                        <td class="px-2 py-1">{{ $receipt->receiver_name }}</td>
                        <td class="px-2 py-1">
                            @if($receipt->photo_path)
                                <img src="{{ asset('storage/'.$receipt->photo_path) }}" alt="Bukti" class="h-12">
                            @endif
                        </td>
                        <td class="px-2 py-1">{{ $receipt->received_at }}</td>
                        <td class="px-2 py-1">
                            <a href="{{ route('upload-proof.edit', $receipt->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                            <form action="{{ route('upload-proof.destroy', $receipt->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus bukti ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">{{ $receipts->links() }}</div>
    </div>
</div>
