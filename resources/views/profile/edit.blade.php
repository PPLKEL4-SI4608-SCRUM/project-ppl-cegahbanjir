<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight font-poppins">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 font-poppins text-white">
            <!-- Menampilkan Profile Information dan Update Password berdampingan di md ke atas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Update Profile Information Card -->
                <div class="p-6 rounded-lg shadow-md">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <!-- Update Password Card -->
                <div class="p-6 rounded-lg shadow-md">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card, berada di bawah -->
            <div class="p-6 rounded-lg shadow-md">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
