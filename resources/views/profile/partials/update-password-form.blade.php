<section class="font-poppins">
    <header class="bg-[#121B22] text-white rounded-t-lg p-6 shadow-md border-b border-[#FFA404]/50"> {{-- Rounded-t-lg for cohesive top, subtle orange border --}}
        <div class="flex items-center gap-3">
            <div class="bg-[#FFA404] p-3 rounded-full shadow-lg"> {{-- Orange circle for icon --}}
                <i class="fas fa-key text-white text-xl"></i> {{-- Key icon for password --}}
            </div>
            <div>
                <h2 class="text-xl font-bold"> {{-- Slightly larger title --}}
                    {{ __('Update Password') }}
                </h2>
                <p class="mt-1 text-sm text-gray-300"> {{-- Lighter gray for more contrast on dark background --}}
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </div>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-0 space-y-6 bg-[#121B22] text-white rounded-b-lg p-8 shadow-2xl backdrop-blur-md border-t-0"> {{-- Rounded-b-lg, no top border --}}
        @csrf
        @method('put')

        @php
            $inputClasses = "mt-1 block w-full px-4 py-3 pr-10 rounded-lg bg-[#0F1A21] border border-white placeholder-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#FFA404] focus:border-transparent transition duration-200 ease-in-out"; // Added focus:border-transparent for cleaner ring, duration, and placeholder color
        @endphp

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-gray-300" /> {{-- Lighter label color --}}
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
                    {{-- Using Font Awesome eye icons directly --}}
                    <i id="eyeIcon1Open" class="fas fa-eye h-5 w-5"></i>
                    <i id="eyeIcon1Closed" class="fas fa-eye-slash h-5 w-5 hidden"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-400" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-gray-300" />
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
                    <i id="eyeIcon2Open" class="fas fa-eye h-5 w-5"></i>
                    <i id="eyeIcon2Closed" class="fas fa-eye-slash h-5 w-5 hidden"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-400" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-gray-300" />
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
                    <i id="eyeIcon3Open" class="fas fa-eye h-5 w-5"></i>
                    <i id="eyeIcon3Closed" class="fas fa-eye-slash h-5 w-5 hidden"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <div class="flex items-center gap-4 pt-4"> {{-- Added top padding for separation --}}
            <button type="submit" class="bg-[#FFA404] hover:bg-[#e39603] text-black font-semibold px-6 py-2.5 rounded-lg transition shadow-lg flex items-center justify-center"> {{-- Orange button, larger padding --}}
                <i class="fas fa-save mr-2"></i> {{-- Save icon --}}
                {{ __('SAVE CHANGES') }} {{-- More explicit text --}}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-400">{{ __('Saved.') }}</p> {{-- Lighter text for saved message --}}
            @endif
        </div>

    </form>

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