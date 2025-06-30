<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Redirect ke Midtrans</h1>
    </x-slot>

    <div class="p-6 bg-white rounded shadow">
        <p>Anda akan diarahkan ke halaman pembayaran untuk <strong>Invoice #{{ $invoice }}</strong>.</p>
        <p>Jika tidak dialihkan, klik tombol berikut:</p>

        <a href="{{ $snapUrl }}" target="_blank"
            class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Buka Pembayaran
        </a>
    </div>

    <script>
        window.onload = () => {
            window.open(@json($snapUrl), '_blank');
            window.location.href = "{{ route('admin.sales.index') }}";
        }
    </script>
</x-admin-layout>
