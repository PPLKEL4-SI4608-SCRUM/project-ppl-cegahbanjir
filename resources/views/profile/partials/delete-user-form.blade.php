<section class="space-y-6 font-poppins">
    <!-- Header -->
    <header class="bg-[#0F1A21]/80 text-white rounded-lg p-6 shadow-md">
        <h2 class="text-lg font-semibold">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-1 mb-3 text-sm text-white/90 leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>

        <!-- Button Trigger -->
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="bg-[#FFA404] hover:bg-[#e39603] text-black font-medium px-4 py-2 rounded-md transition"
        >
            {{ __('Delete Account') }}
        </x-danger-button>
    </header>

    <!-- Modal Form -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-[#0F1A21] text-white rounded-lg shadow-lg font-poppins">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-white">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>
            <p class="mt-2 text-sm text-white/90 leading-relaxed">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <!-- Password Input -->
            <div class="mt-6 relative">
                <x-input-label for="modal_password" value="{{ __('Password') }}" class="sr-only" />
                <input
                    id="modal_password"
                    name="password"
                    type="password"
                    class="block w-full bg-[#0F1A21] text-white border border-[#FFA404]/50 rounded-md px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-[#FFA404]"
                    placeholder="{{ __('Password') }}"
                />
                <!-- Eye Icon Button (Same as update password) -->
                <span class="absolute right-3 inset-y-0 flex items-center cursor-pointer text-[#FFA404]"
                    onclick="togglePassword('modal_password', 'modalEyeOpen', 'modalEyeClosed')">
                    <svg id="modalEyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                            -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="modalEyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7A10.05 10.05 0 015.22 6.222M9.88 9.88a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8" />
                    </svg>
                </span>
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-400" />
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-end space-x-4">
                <!-- Cancel Button Re-styled -->
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="bg-black text-white font-medium px-4 py-2 rounded-md transition"
                >
                    {{ __('Cancel') }}
                </button>

                <x-danger-button class="bg-[#FFA404] hover:bg-[#e39603] text-black font-medium px-4 py-2 rounded-md transition">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>

        <!-- Toggle Password Script -->
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
    </x-modal>
</section>
