<div class="p-4 max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Tambah Bukti Serah Terima</h2>
    <form action="{{ route('upload-proof.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-4 rounded shadow">
        @csrf
        <div>
            <label class="block mb-1 font-medium">Surat Jalan</label>
            <select name="delivery_order_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Surat Jalan</option>
                @foreach($orders as $order)
                    <option value="{{ $order->id }}">{{ $order->unique_code }} - {{ $order->destination }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1 font-medium">Nama Penerima</label>
            <input type="text" name="receiver_name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">Tanggal Terima</label>
            <input type="datetime-local" name="received_at" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">Foto Bukti</label>
            <input type="file" name="photo" accept="image/*" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('upload-proof.index') }}" class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
