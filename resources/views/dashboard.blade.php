<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Ini isi dashboard kamu -->
    <div class="max-w-7xl mx-auto bg-[#0F1A21]/70 backdrop-blur-md p-6 md:p-10 rounded-xl shadow-2xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Isi cards dengan fitur fitur seperti sebelumnya -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Fitur 1</h3>
                <p class="mt-2 text-gray-600">Deskripsi fitur 1.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Fitur 2</h3>
                <p class="mt-2 text-gray-600">Deskripsi fitur 2.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Fitur 3</h3>
                <p class="mt-2 text-gray-600">Deskripsi fitur 3.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Fitur 4</h3>
                <p class="mt-2 text-gray-600">Deskripsi fitur 4.</p>
            </div>
        </div>
    </div>
</x-app-layout>
