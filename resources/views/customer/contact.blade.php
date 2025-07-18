<x-customer-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            <div class="text-center mb-12">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                    <i class="fas fa-headset text-indigo-600 mr-3"></i> Hubungi Kami
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Kami siap membantu! Jangan ragu untuk menghubungi kami jika ada pertanyaan, masukan, atau kendala.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm flex items-start space-x-4">
                    <i class="fas fa-map-marker-alt text-4xl text-indigo-600 mt-1"></i>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Alamat Kami</h3>
                        <p class="text-gray-700">
                            [Alamat Lengkap Anda]<br>
                            [Kota, Kode Pos]<br>
                            [Provinsi, Negara]
                        </p>
                        <a href="https://maps.google.com/?q=[Alamat Lengkap Anda Tanpa Spasi, contoh:Jl.MerdekaNo.10,Banjarmasin]"
                            target="_blank" class="text-indigo-600 hover:underline mt-2 inline-block">Lihat di Peta</a>
                    </div>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm flex items-start space-x-4">
                    <i class="fas fa-phone-alt text-4xl text-indigo-600 mt-1"></i>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Telepon</h3>
                        <p class="text-gray-700 mb-2">
                            Customer Service: <a href="tel:[Nomor Telepon CS Anda]"
                                class="text-indigo-600 hover:underline">[Nomor Telepon CS Anda]</a>
                        </p>
                        <p class="text-gray-700">
                            WhatsApp: <a
                                href="https://wa.me/[Nomor WhatsApp Anda Tanpa Simbol/Spasi, contoh:6281234567890]"
                                target="_blank" class="text-green-600 hover:underline font-semibold">[Nomor WhatsApp
                                Anda]</a>
                        </p>
                        <p class="text-sm text-gray-500 mt-2">Jam Kerja: Senin - Jumat, 09:00 - 17:00 WITA</p>
                    </div>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm flex items-start space-x-4">
                    <i class="fas fa-envelope text-4xl text-indigo-600 mt-1"></i>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Email</h3>
                        <p class="text-gray-700">
                            Informasi Umum: <a href="mailto:[Email Umum Anda]"
                                class="text-indigo-600 hover:underline">[Email Umum Anda]</a>
                        </p>
                        <p class="text-gray-700">
                            Dukungan Pelanggan: <a href="mailto:[Email Dukungan Anda]"
                                class="text-indigo-600 hover:underline">[Email Dukungan Anda]</a>
                        </p>
                    </div>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm flex items-start space-x-4">
                    <i class="fas fa-share-alt text-4xl text-indigo-600 mt-1"></i>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Media Sosial</h3>
                        <div class="flex space-x-4">
                            {{-- Replace with your actual social media links --}}
                            <a href="[Link Facebook Anda]" target="_blank"
                                class="text-gray-500 hover:text-blue-600 transition">
                                <i class="fab fa-facebook-square text-3xl"></i>
                            </a>
                            <a href="[Link Instagram Anda]" target="_blank"
                                class="text-gray-500 hover:text-pink-600 transition">
                                <i class="fab fa-instagram-square text-3xl"></i>
                            </a>
                            <a href="[Link Twitter/X Anda]" target="_blank"
                                class="text-gray-500 hover:text-blue-400 transition">
                                <i class="fab fa-twitter-square text-3xl"></i>
                            </a>
                            {{-- Add more social media icons as needed --}}
                        </div>
                    </div>
                </div>
            </div>

            {{--
                Jika Anda ingin menambahkan form kontak yang berfungsi, Anda perlu membuat route dan controller
                di Laravel untuk menangani pengiriman form ini (misal: mengirim email ke admin).
                Ini hanya tampilan UI form-nya.
            --}}
            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Kirim Pesan Kepada Kami</h2>
                <form
                    action="https://www.reddit.com/r/Backend/comments/18syzdt/add_contact_me_form_on_personal_website/"
                    method="POST" class="max-w-2xl mx-auto">
                    @csrf {{-- Laravel CSRF token --}}
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Nama Anda">
                    </div>
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Anda</label>
                        <input type="email" name="email" id="email" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="email@example.com">
                    </div>
                    <div class="mb-5">
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                        <input type="text" name="subject" id="subject"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Perihal pesan Anda">
                    </div>
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan Anda</label>
                        <textarea name="message" id="message" rows="5" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Tulis pesan Anda di sini..."></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit"
                            class="inline-flex items-center px-8 py-3 border border-transparent text-base font-semibold rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-customer-layout>
