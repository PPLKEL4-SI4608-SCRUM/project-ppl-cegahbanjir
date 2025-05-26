<section class="font-poppins">
    <header class="bg-[#121B22] text-white rounded-t-lg p-6 shadow-md border-b border-[#FFA404]/50"> {{-- Rounded-t-lg for cohesive top, subtle orange border --}}
        <div class="flex items-center gap-3">
            <div class="bg-[#FFA404] p-3 rounded-full shadow-lg"> {{-- Orange circle for icon --}}
                <i class="fas fa-user-circle text-white text-xl"></i> {{-- User icon for profile --}}
            </div>
            <div>
                <h2 class="text-xl font-bold"> {{-- Slightly larger title --}}
                    {{ __('Profile Information') }}
                </h2>
                <p class="mt-1 text-sm text-gray-300"> {{-- Lighter gray for more contrast on dark background --}}
                    {{ __("Update your account's profile information and email address.") }}
                </p>
            </div>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden"></form> {{-- Hide form visually if it's just for sending verification --}}

    <form method="post" action="{{ route('profile.update') }}" class="mt-0 space-y-6 bg-[#121B22] text-white rounded-b-lg p-8 shadow-2xl backdrop-blur-md border-t-0"> {{-- Rounded-b-lg, no top border --}}
        @csrf
        @method('patch')

        @php
            $inputClasses = "mt-1 block w-full px-4 py-3 rounded-lg bg-[#0F1A21] border border-[#FFA404]/70 placeholder-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#FFA404] focus:border-transparent transition duration-200 ease-in-out";
        @endphp

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-300" /> {{-- Lighter label color --}}
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="{{ $inputClasses }}" {{-- Apply custom input classes --}}
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
                placeholder="Your Name" {{-- Added placeholder --}}
            />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-300" /> {{-- Lighter label color --}}
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="{{ $inputClasses }}" {{-- Apply custom input classes --}}
                :value="old('email', $user->email)"
                required
                autocomplete="username"
                placeholder="your.email@example.com" {{-- Added placeholder --}}
            />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-300"> {{-- Lighter text for consistency --}}
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-[#FFA404] hover:text-yellow-300 transition"> {{-- Orange link --}}
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400"> {{-- Slightly darker green for contrast --}}
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4"> {{-- Added top padding for separation --}}
            <button type="submit" class="bg-[#FFA404] hover:bg-[#e39603] text-black font-semibold px-6 py-2.5 rounded-lg transition shadow-lg flex items-center justify-center"> {{-- Orange button, larger padding --}}
                <i class="fas fa-save mr-2"></i> {{-- Save icon --}}
                {{ __('SAVE CHANGES') }} {{-- More explicit text --}}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-400">{{ __('Saved.') }}</p> {{-- Lighter text for saved message --}}
            @endif
        </div>
    </form>
</section>