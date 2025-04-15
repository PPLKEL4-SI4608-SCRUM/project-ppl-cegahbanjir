<section class="font-poppins">
    <!-- Header -->
    <header class="bg-[#121B22]/90 text-white rounded-lg p-6 shadow-md">
        <h2 class="text-lg font-semibold">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-white/90">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <!-- Form -->
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6 bg-[#121B22]/90 text-white rounded-lg p-6 shadow-2xl backdrop-blur-md">
        @csrf
        @method('put')

        @php
            $inputClasses = "mt-1 block w-full px-4 py-3 pr-10 rounded-lg bg-[#0F1A21] border border-[#FFA404]/50 placeholder-[#CCCCCC] text-white focus:outline-none focus:ring-2 focus:ring-[#FFA404] transition";
        @endphp

        <!-- Current Password -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-white" />
            <div class="relative">
                <input 
                    id="update_password_current_password" 
                    name="current_password" 
                    type="password" 
                    class="{{ $inputClasses }}" 
                    autocomplete="current-password" 
                    placeholder="********"
                />
                <span class="absolute right-3 inset-y-0 flex items-center cursor-pointer text-[#FFA404] hover:text-yellow-300 transition"
                    onclick="togglePassword('update_password_current_password', 'eyeIcon1Open', 'eyeIcon1Closed')">
                    <svg id="eyeIcon1Open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                            -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eyeIcon1Closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.27-2.943-9.544-7A10.05 10.05 0 015.22 6.222M9.88 9.88a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8" />
                    </svg>
                </span>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-400" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-white" />
            <div class="relative">
                <input 
                    id="update_password_password" 
                    name="password" 
                    type="password" 
                    class="{{ $inputClasses }}" 
                    autocomplete="new-password" 
                    placeholder="********"
                />
                <span class="absolute right-3 inset-y-0 flex items-center cursor-pointer text-[#FFA404] hover:text-yellow-300 transition"
                    onclick="togglePassword('update_password_password', 'eyeIcon2Open', 'eyeIcon2Closed')">
                    <svg id="eyeIcon2Open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                            -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eyeIcon2Closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.27-2.943-9.544-7A10.05 10.05 0 015.22 6.222M9.88 9.88a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8" />
                    </svg>
                </span>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-white" />
            <div class="relative">
                <input 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    class="{{ $inputClasses }}" 
                    autocomplete="new-password" 
                    placeholder="********"
                />
                <span class="absolute right-3 inset-y-0 flex items-center cursor-pointer text-[#FFA404] hover:text-yellow-300 transition"
                    onclick="togglePassword('update_password_password_confirmation', 'eyeIcon3Open', 'eyeIcon3Closed')">
                    <svg id="eyeIcon3Open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                            -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eyeIcon3Closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.27-2.943-9.544-7A10.05 10.05 0 015.22 6.222M9.88 9.88a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8" />
                    </svg>
                </span>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-4">
            <button type="submit" class="bg-[#FFA404] hover:bg-[#e39603] text-black font-semibold px-5 py-2 rounded-md transition">
                {{ __('SAVE') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-white/90">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>

    <!-- Script -->
    <script>
        function togglePassword(inputId, openIconId, closedIconId) {
            const input = document.getElementById(inputId);
            const openIcon = document.getElementById(openIconId);
            const closedIcon = document.getElementById(closedIconId);

            if (input.type === 'password') {
                input.type = 'text';
                openIcon.classList.add('hidden');
                closedIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                openIcon.classList.remove('hidden');
                closedIcon.classList.add('hidden');
            }
        }
    </script>
</section>
