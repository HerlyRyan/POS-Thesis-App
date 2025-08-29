<x-customer-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            <div class="text-center mb-12">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                    <i class="fas fa-info-circle text-indigo-600 mr-3"></i> Tentang Kami
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Kisah di balik Galam Sani. Kami percaya pada Kualitas dari segi Produk sampai ke Pengalaman
                    berbelanja.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Misi & Visi Kami</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Di Galam Sani, kami memiliki misi untuk menyediakan produk galam terbaik dengan kualitas tak
                        tertandingi dan harga yang terjangkau.
                        Kami berdedikasi untuk kepuasan pelanggan, inovasi,
                        keberlanjutan.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        Visi kami adalah menjadi penyedia galam yang amanah dan berkualitas
                        di industri jual beli kayu galam, membangun hubungan yang kuat dengan pelanggan dan komunitas
                        kami.
                    </p>
                </div>
                <div>
                    {{-- Replace with an actual image relevant to your business --}}
                    {{-- <img src="https://images.unsplash.com/photo-1552588435-081498b813d1?auto=format&fit=crop&q=80&w=1974&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Our Team/Vision" class="rounded-xl shadow-md object-cover w-full h-72"> --}}
                </div>
            </div>

            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Nilai-Nilai Kami</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-indigo-50 p-6 rounded-lg shadow-sm">
                        <i class="fas fa-handshake text-4xl text-indigo-600 mb-3"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Integritas</h3>
                        <p class="text-gray-600">Kami menjunjung tinggi kejujuran dan etika dalam setiap aspek bisnis
                            kami.</p>
                    </div>
                    <div class="bg-indigo-50 p-6 rounded-lg shadow-sm">
                        <i class="fas fa-star text-4xl text-indigo-600 mb-3"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Kualitas</h3>
                        <p class="text-gray-600">Kami berkomitmen untuk memberikan produk/layanan dengan standar
                            kualitas tertinggi.</p>
                    </div>
                    <div class="bg-indigo-50 p-6 rounded-lg shadow-sm">
                        <i class="fas fa-heart text-4xl text-indigo-600 mb-3"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Kepuasan Pelanggan</h3>
                        <p class="text-gray-600">Pelanggan adalah prioritas utama kami, kami selalu berusaha melampaui
                            ekspektasi.</p>
                    </div>
                    {{-- Add more values if needed --}}
                </div>
            </div>

            <div class="text-center bg-indigo-600 text-white p-8 rounded-xl shadow-md">
                <h2 class="text-3xl font-bold mb-4">Siap untuk Memulai?</h2>
                <p class="text-lg mb-6">Jelajahi produk/layanan kami yang berkualitas dan rasakan perbedaannya.</p>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-8 py-4 border border-white text-base font-semibold rounded-full shadow-lg hover:bg-white hover:text-indigo-600 transition duration-300">
                    <i class="fas fa-shopping-bag mr-2"></i> Kunjungi Toko
                </a>
            </div>
        </div>
    </div>
</x-customer-layout>
