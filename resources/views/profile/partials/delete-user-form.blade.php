<section class="space-y-6 font-poppins">
    <header class="bg-[#121B22] text-white rounded-t-lg p-6 shadow-md border-b border-red-500/50"> {{-- Rounded-t-lg for cohesive top, subtle red border for danger --}}
        <div class="flex items-center gap-3">
            <div class="bg-red-600 p-3 rounded-full shadow-lg"> {{-- Red circle for danger icon --}}
                <i class="fas fa-trash-alt text-white text-xl"></i> {{-- Trash icon for deletion --}}
            </div>
            <div>
                <h2 class="text-xl font-bold"> {{-- Slightly larger title --}}
                    {{ __('Delete Account') }}
                </h2>
                <p class="mt-1 text-sm text-gray-300 leading-relaxed"> {{-- Lighter gray for more contrast on dark background --}}
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </p>
            </div>
        </div>

        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="mt-6 bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 rounded-lg transition shadow-md flex items-center justify-center"> {{-- Red button for delete action --}}
            <i class="fas fa-trash-alt mr-2"></i>
            {{ __('Delete Account') }}
        </button>
    </header>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-[#121B22] text-white rounded-lg shadow-lg font-poppins"> {{-- Increased padding, solid dark background --}}
            @csrf
            @method('delete')

            <h2 class="text-2xl font-bold text-white mb-2"> {{-- Increased title size, bold --}}
                {{ __('Are you sure you want to delete your account?') }}
            </h2>
            <p class="mt-2 text-sm text-gray-300 leading-relaxed"> {{-- Lighter gray for content text --}}
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6 relative">
                <x-input-label for="modal_password" value="{{ __('Password') }}" class="sr-only" />
                <input
                    id="modal_password"
                    name="password"
                    type="password"
                    class="block w-full bg-[#0F1A21] text-white border border-gray-600 rounded-lg px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200 ease-in-out" {{-- Red focus ring for danger --}}
                    placeholder="{{ __('Password') }}"
                />
                <span class="absolute right-3 inset-y-0 flex items-center cursor-pointer text-gray-400 hover:text-white transition"
                    onclick="togglePassword('modal_password', 'modalEyeOpen', 'modalEyeClosed')">
                    {{-- Using Font Awesome eye icons directly --}}
                    <i id="modalEyeOpen" class="fas fa-eye h-5 w-5"></i>
                    <i id="modalEyeClosed" class="fas fa-eye-slash h-5 w-5 hidden"></i>
                </span>
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-400" />
            </div>

            <div class="mt-8 flex justify-end space-x-4"> {{-- Increased top margin --}}
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="bg-gray-700 text-white font-semibold px-6 py-2.5 rounded-lg transition hover:bg-gray-600 shadow-md"> {{-- Dark gray cancel button --}}
                    <i class="fas fa-times mr-2"></i> {{-- Times icon --}}
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 rounded-lg transition shadow-md"> {{-- Red delete button --}}
                    <i class="fas fa-trash-alt mr-2"></i> {{-- Trash icon --}}
                    {{ __('Delete Account') }}
                </button>
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
    </x-modal>
</section>