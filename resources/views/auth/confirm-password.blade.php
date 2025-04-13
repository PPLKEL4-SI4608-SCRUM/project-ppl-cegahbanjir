<x-guest-layout>
    <div class="min-h-screen bg-cover bg-center flex items-center justify-center relative" style="background-image: url('{{ asset('images/background-banjir.png') }}')">
        <div class="absolute inset-0 bg-black opacity-60 z-0"></div>

        <div class="z-10 bg-gradient-to-br from-gray-900/90 to-blue-900/90 backdrop-blur-sm p-8 rounded-lg shadow-xl w-full max-w-md text-white border border-blue-800/30">
            <h2 class="text-2xl font-semibold mb-6 text-center text-blue-100">Konfirmasi Password</h2>

            <p class="mb-4 text-sm text-blue-200 leading-relaxed">
                {{ __('Untuk keamanan, mohon masukkan password kamu sebelum melanjutkan.') }}
            </p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-6 relative">
                    <label for="password" class="block text-sm mb-1 text-blue-200">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2 rounded bg-gray-900/80 border border-blue-800/40 placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="********" />
                    @error('password')
                        <span class="text-red-300 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 px-5 py-2 rounded shadow transition transform hover:scale-105">
                        Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
