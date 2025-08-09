<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Scan QR/Barcode</h2>
    <div class="mb-2 text-sm text-gray-500">
        Pastikan Anda mengizinkan akses kamera pada browser untuk scan barcode.
    </div>
    <div class="mb-4">
        <div id="reader" class="mb-4"></div>
        <input type="text" wire:model.lazy="scannedCode" placeholder="Scan atau masukkan barcode..." class="border rounded px-3 py-2 w-full max-w-md" autofocus>
        @if($error)
            <div class="text-red-600 text-sm mt-2">{{ $error }}</div>
        @endif
    </div>
    @if($scannedCode && !$error && $order)
        <div class="bg-green-100 text-green-800 rounded p-3 mt-4">
            <div><b>Barcode:</b> <span class="font-mono">{{ $order->unique_code }}</span></div>
            <div><b>Tujuan:</b> {{ $order->destination }}</div>
            <div><b>Deskripsi:</b> {{ $order->description }}</div>
            <div><b>Latitude:</b> {{ $order->latitude }} | <b>Longitude:</b> {{ $order->longitude }}</div>
        </div>
    @elseif($scannedCode && $error)
        <div class="bg-red-100 text-red-800 rounded p-3 mt-4">
            {{ $error }}
        </div>
    @endif

    {{-- Script html5-qrcode --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            // Inisialisasi scanner hanya sekali
            if (!window._barcodeScannerInitialized) {
                window._barcodeScannerInitialized = true;
                var instanceId = document.querySelector('[wire\\:id]')?.getAttribute('wire:id');
                if (window.Html5QrcodeScanner && instanceId && document.getElementById('reader')) {
                    try {
                        var scanner = new Html5QrcodeScanner(
                            "reader", { fps: 10, qrbox: 250 }
                        );
                        scanner.render(function(decodedText, result) {
                            if (window.livewire && window.livewire.find(instanceId)) {
                                window.livewire.find(instanceId).set('scannedCode', decodedText);
                            }
                        }, function(error) {
                            let readerDiv = document.getElementById('reader');
                            if (readerDiv && !readerDiv.querySelector('.camera-error')) {
                                let err = document.createElement('div');
                                err.className = 'camera-error text-red-600 text-sm mt-2';
                                err.innerText = 'Tidak dapat mengakses kamera. Pastikan izin kamera diaktifkan dan tidak sedang digunakan aplikasi lain.';
                                readerDiv.appendChild(err);
                            }
                        });
                    } catch (e) {
                        let readerDiv = document.getElementById('reader');
                        if (readerDiv && !readerDiv.querySelector('.camera-error')) {
                            let err = document.createElement('div');
                            err.className = 'camera-error text-red-600 text-sm mt-2';
                            err.innerText = 'Gagal menginisialisasi kamera: ' + (e.message || e);
                            readerDiv.appendChild(err);
                        }
                    }
                }
            }
        });
    </script>
</div>
