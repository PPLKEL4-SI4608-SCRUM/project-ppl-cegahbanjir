<section class="font-poppins">
    <!-- Header -->
    <header class="bg-[#0F1A21]/90 text-white rounded-xl p-6 shadow-md">
        <h2 class="text-lg font-semibold">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-white/90">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Form -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6 bg-[#0F1A21]/90 text-white rounded-xl p-6 shadow-md">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-white" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-1 block w-full bg-[#0F1A21] text-white border border-[#FFA404]/50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400" 
                :value="old('name', $user->name)" 
                required autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1 block w-full bg-[#0F1A21] text-white border border-[#FFA404]/50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-white">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-yellow-400 hover:text-yellow-300 transition">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-300">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-[#FFA404] hover:bg-[#e39603] text-black font-semibold px-5 py-2 rounded-md transition">
                {{ __('SAVE') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-white/90">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
