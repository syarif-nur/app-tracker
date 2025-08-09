<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Log Transaksi Aplikasi</h2>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200 text-xs">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-2 py-2">Waktu</th>
                    <th class="px-2 py-2">User</th>
                    <th class="px-2 py-2">Aksi</th>
                    <th class="px-2 py-2">Model</th>
                    <th class="px-2 py-2">ID Data</th>
                    <th class="px-2 py-2">Sebelum</th>
                    <th class="px-2 py-2">Sesudah</th>
                    <th class="px-2 py-2">IP</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($logs as $log)
                    <tr>
                        <td class="px-2 py-1 whitespace-nowrap">{{ $log->created_at }}</td>
                        <td class="px-2 py-1">{{ $log->user?->name ?? '-' }}</td>
                        <td class="px-2 py-1">{{ strtoupper($log->action) }}</td>
                        <td class="px-2 py-1">{{ class_basename($log->model) }}</td>
                        <td class="px-2 py-1">{{ $log->model_id }}</td>
                        <td class="px-2 py-1 max-w-xs overflow-x-auto"><pre class="whitespace-pre-wrap">{{ json_encode($log->data_before, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre></td>
                        <td class="px-2 py-1 max-w-xs overflow-x-auto"><pre class="whitespace-pre-wrap">{{ json_encode($log->data_after, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre></td>
                        <td class="px-2 py-1">{{ $log->ip_address }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
