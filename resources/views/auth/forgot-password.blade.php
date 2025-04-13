<x-guest-layout>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>

    <div class="min-h-screen bg-cover bg-center flex items-center justify-center px-4 sm:px-6 lg:px-8 relative" style="background-image: url('{{ asset('images/background-banjir.png') }}')">
        <div class="absolute inset-0 bg-black opacity-60 z-0"></div>

        <div class="z-10 bg-[#121B22]/90 backdrop-blur-md p-8 sm:p-10 rounded-2xl shadow-2xl w-full max-w-md text-white animate-fade-in-up">
            
            <!-- Logo & Title -->
            <div class="flex flex-col items-center justify-center mb-6 sm:mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Cegah Banjir" class="w-16 h-16 sm:w-20 sm:h-20 mb-2">
                <span class="text-xl sm:text-2xl md:text-3xl font-bold text-[#FFA404]">Reset Password</span>  
            </div>

            <p class="mb-5 text-sm text-white/70 text-center leading-relaxed">
                Lupa password? Masukkan email kamu dan kami akan kirimkan link untuk reset.
            </p>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-400 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm mb-2 text-white/80 font-medium">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        class="w-full px-4 py-3 rounded-lg bg-[#0F1A21] border border-[#FFA404]/30 placeholder-[#CCCCCC] text-white focus:outline-none focus:ring-2 focus:ring-[#FFA404] transition"
                        placeholder="example@gmail.com" />
                    @error('email')
                        <span class="text-red-300 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('login') }}" class="text-sm text-[#FFA404] hover:text-yellow-300 transition-colors duration-300 font-medium">
                        Kembali ke login
                    </a>
                    <button type="submit"
                        class="bg-[#FFA404] hover:bg-yellow-400 text-[#121B22] font-semibold px-5 py-2.5 rounded-lg shadow hover:shadow-lg transition-all duration-300 transform hover:scale-[1.03]">
                        Kirim Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
