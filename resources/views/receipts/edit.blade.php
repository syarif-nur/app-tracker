<div class="p-4 max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Edit Bukti Serah Terima</h2>
    <form action="{{ route('upload-proof.update', $receipt->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-4 rounded shadow">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1 font-medium">Surat Jalan</label>
            <input type="text" value="{{ $receipt->deliveryOrder->unique_code ?? '-' }}" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
        </div>
        <div>
            <label class="block mb-1 font-medium">Nama Penerima</label>
            <input type="text" name="receiver_name" value="{{ $receipt->receiver_name }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">Tanggal Terima</label>
            <input type="datetime-local" name="received_at" value="{{ old('received_at', $receipt->received_at ? date('Y-m-d\TH:i', strtotime($receipt->received_at)) : '') }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">Foto Bukti (biarkan kosong jika tidak diubah)</label>
            <input type="file" name="photo" accept="image/*" class="w-full border rounded px-3 py-2">
            @if($receipt->photo_path)
                <img src="{{ asset('storage/'.$receipt->photo_path) }}" alt="Bukti" class="h-16 mt-2">
            @endif
        </div>
        <div class="flex justify-end">
            <a href="{{ route('upload-proof.index') }}" class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
