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

        .eye-button svg {
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .eye-button:hover svg {
            transform: scale(1.15);
            color: #FFD75E;
        }
    </style>

    <div class="min-h-screen bg-cover bg-center flex items-center justify-center px-4 sm:px-6 lg:px-8 relative" style="background-image: url('{{ asset('images/background-banjir.png') }}')">
        <div class="absolute inset-0 bg-black opacity-60 z-0"></div>

        <div class="z-10 bg-[#121B22]/90 backdrop-blur-md p-8 sm:p-10 rounded-2xl shadow-2xl w-full max-w-md text-white animate-fade-in-up">
            <div class="flex flex-col items-center justify-center mb-6 sm:mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Cegah Banjir" class="w-16 h-16 sm:w-20 sm:h-20 mb-2">
                <span class="text-xl sm:text-2xl md:text-3xl font-bold text-[#FFA404]">Reset Password</span>  
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block text-sm mb-2 text-white/80 font-medium">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                        class="w-full px-4 py-3 rounded-lg bg-[#0F1A21] border border-[#FFA404]/30 placeholder-[#CCCCCC] text-white focus:outline-none focus:ring-2 focus:ring-[#FFA404] transition"
                        placeholder="example@gmail.com" />
                    @error('email')
                        <span class="text-red-300 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="mb-5 relative">
                    <label for="password" class="block text-sm mb-2 text-white/80 font-medium">Password Baru</label>
                    <div class="relative flex">
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-3 pr-10 rounded-lg bg-[#0F1A21] border border-[#FFA404]/30 placeholder-[#CCCCCC] text-white focus:outline-none focus:ring-2 focus:ring-[#FFA404] transition"
                            placeholder="********" />
                        <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
                            class="absolute right-3 text-[#FFA404] hover:text-yellow-300 transition duration-300 ease-in-out flex items-center h-full">
                            <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-red-300 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div class="mb-6 relative">
                    <label for="password_confirmation" class="block text-sm mb-2 text-white/80 font-medium">Konfirmasi Password</label>
                    <div class="relative flex">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 pr-10 rounded-lg bg-[#0F1A21] border border-[#FFA404]/30 placeholder-[#CCCCCC] text-white focus:outline-none focus:ring-2 focus:ring-[#FFA404] transition"
                            placeholder="********" />
                        <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                            class="absolute right-3 text-[#FFA404] hover:text-yellow-300 transition duration-300 ease-in-out flex items-center h-full">
                            <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="text-red-300 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-[#FFA404] hover:bg-yellow-400 text-[#121B22] font-semibold px-6 py-2.5 rounded-lg shadow hover:shadow-lg transition-all duration-300 transform hover:scale-[1.03]">
                    Reset Password
                </button>
            </form>
        </div>
    </div>

    <!-- Password toggle script -->
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.27-2.943-9.544-7A10.05 10.05 0 015.22 6.222M9.88 9.88a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8" />`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</x-guest-layout>
