@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    {{-- Leaflet Geocoding Control CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        #map, .modal-map {
            height: 300px;
            margin-top: 1rem;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .leaflet-control-geocoder {
            margin-top: 10px;
            margin-left: 10px;
        }

        /* Custom File Input Styling */
        .custom-file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
            cursor: pointer;
        }

        .custom-file-input {
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10; /* Ensure it's clickable */
        }

        .custom-file-label {
            display: flex;
            align-items: center;
            justify-content: space-between; /* To push icon to the right */
            background-color: #374151; /* Darker gray for better contrast */
            color: #d1d5db; /* Light gray text */
            border: 1px solid #4b5563; /* Darker border */
            border-radius: 0.5rem;
            padding: 0.625rem 1rem; /* Equivalent to px-3 py-2.5 */
            font-size: 0.875rem; /* text-sm */
            line-height: 1.25rem;
            overflow: hidden; /* Hide overflow text */
            white-space: nowrap; /* Prevent text wrap */
            text-overflow: ellipsis; /* Add ellipsis for long file names */
            transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }

        .custom-file-label:hover {
            background-color: #4b5563; /* Slightly lighter on hover */
            border-color: #6b7280;
        }

        .custom-file-label svg {
            flex-shrink: 0; /* Prevent icon from shrinking */
            margin-left: 0.5rem; /* Space between text and icon */
        }

        /* Ensure modal backdrop covers everything */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
            z-index: 49; /* Just below the modal's z-index */
        }
    </style>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-white">Laporan Kejadian Bencana</h1>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Tambah Laporan Baru --}}
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-black-700">Tambah Laporan Baru</h2>
            <form method="POST" action="{{ route('laporan.store') }}" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="location" class="block text-white font-medium bg-[#121B22] px-3 py-1 rounded">Lokasi Kejadian</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" required class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">
                    <div id="map" class="w-full mt-4 rounded"></div>
                    @error('location')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-white font-medium bg-[#121B22] px-3 py-1 rounded">Deskripsi Kejadian</label>
                    <textarea id="description" name="description" rows="3" required class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block mb-2 text-white font-medium bg-[#121B22] px-3 py-1 rounded" for="disaster_image">Foto Lokasi Kejadian</label>
                    <div class="custom-file-input-wrapper">
                        <input class="custom-file-input" id="disaster_image" name="disaster_image" type="file" required>
                        <label for="disaster_image" class="custom-file-label">
                            <span id="disaster_image_filename">Pilih file...</span>
                            <svg class="w-5 h-5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 8h6m-3 3V5m-3 6H2a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h5l2-3h9a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h6l2-3h7a1 1 0 0 1 1 1v7.5"/>
                            </svg>
                        </label>
                    </div>
                    @error('disaster_image')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="bg-[#FFA404] text-white px-4 py-2 rounded hover:bg-[#e69400] transition">
                        Simpan Laporan
                    </button>
                </div>
            </form>
        </div>

        {{-- Daftar Laporan --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Riwayat Laporan</h2>
            @if ($reports->isEmpty())
                <p class="text-gray-600">Belum ada laporan yang tersedia.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Nama Pelapor</th>
                                <th class="px-4 py-2 border">Lokasi</th>
                                <th class="px-4 py-2 border">Deskripsi</th>
                                <th class="px-4 py-2 border">Foto</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $index => $report)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $report->user->name ?? 'Tidak diketahui' }}</td>
                                    <td class="px-4 py-2 border">{{ $report->location }}</td>
                                    <td class="px-4 py-2 border">{{ $report->description }}</td>
                                    <td class="px-4 py-2 border">
                                        <img class="card-img-top" src="{{ url('disaster_images/' . $report->disaster_image) }}" alt="image" width="100"/>
                                    </td>
                                    <td class="px-4 py-2 border">
                                        @if ($report->status == 'rejected')
                                            <span class="text-red-600 font-semibold">Rejected</span>
                                        @elseif($report->status == 'pending')
                                            <span class="text-yellow-600 font-semibold">Pending</span>
                                        @else
                                            <span class="text-blue-600 font-semibold">Approved</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">{{ $report->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-4 py-2 border">
                                        <button data-modal-target="default-modal{{ $report->id }}" data-modal-toggle="default-modal{{ $report->id }}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                            Detail
                                        </button>
                                    </td>
                                </tr>

                                {{-- Detail/Edit Modal for each report --}}
                                {{-- Added a backdrop and adjusted z-index for the modal --}}
                                <div id="default-modal{{ $report->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full overflow-y-auto overflow-x-hidden hidden">
                                    <div class="modal-backdrop"></div> {{-- Custom backdrop --}}
                                    <div class="relative p-4 w-full max-w-2xl max-h-full z-50"> {{-- Ensure modal content has high z-index --}}
                                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Detail</h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal{{ $report->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <div class="p-4 md:p-5 space-y-4">
                                                <form method="POST" action="{{ route('laporan.update', $report->id) }}" class="space-y-4" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div>
                                                        <label for="location_{{ $report->id }}" class="block text-white font-medium bg-[#121B22] px-3 py-1 rounded">Lokasi Kejadian</label>
                                                        <input type="text" id="location_{{ $report->id }}" name="location" value="{{ $report->location }}" required class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">
                                                        <div id="modal-map-{{ $report->id }}" class="modal-map w-full mt-4 rounded"></div>
                                                        @error('location')
                                                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label for="description_{{ $report->id }}" class="block text-white font-medium bg-[#121B22] px-3 py-1 rounded">Deskripsi Kejadian</label>
                                                        <textarea id="description_{{ $report->id }}" name="description" rows="3" required class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">{{ $report->description }}</textarea>
                                                        @error('description')
                                                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label for="status_{{ $report->id }}" class="block text-white font-medium bg-[#121B22] px-3 py-1 rounded">Status</label>
                                                        <select id="status_{{ $report->id }}" name="status" required class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">
                                                            <option value="">Pilih Status</option>
                                                            <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>Merah (Rejected)</option>
                                                            <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Kuning (Pending)</option>
                                                            <option value="approved" {{ $report->status == 'approved' ? 'selected' : '' }}>Biru (Approved)</option>
                                                        </select>
                                                        @error('status')
                                                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-white font-medium bg-[#121B22] px-3 py-1 rounded" for="disaster_image_{{ $report->id }}">Foto Lokasi Kejadian</label>
                                                        <div class="custom-file-input-wrapper">
                                                            <input class="custom-file-input" id="disaster_image_{{ $report->id }}" name="disaster_image" type="file">
                                                            <label for="disaster_image_{{ $report->id }}" class="custom-file-label">
                                                                <span id="disaster_image_filename_{{ $report->id }}">Pilih file...</span>
                                                                <svg class="w-5 h-5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 8h6m-3 3V5m-3 6H2a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h5l2-3h9a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h6l2-3h7a1 1 0 0 1 1 1v7.5"/>
                                                                </svg>
                                                            </label>
                                                        </div>
                                                        @error('disaster_image')
                                                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                        <button type="submit" class="text-white bg-[#FFA404] hover:bg-[#e69400] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">update</button>
                                                        <button type="button" data-modal-target="popup-modal{{ $report->id }}" data-modal-toggle="popup-modal{{ $report->id }}" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-red rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Delete</button>
                                                    </div>
                                                </form>
                                            </div>

                                            {{-- Delete Confirmation Modal --}}
                                            <div id="popup-modal{{ $report->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative p-4 w-full max-w-md max-h-full">
                                                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal{{ $report->id }}">
                                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                        <div class="p-4 md:p-5 text-center">
                                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this Data?</h3>
                                                            <form action="{{ route('laporan.destroy', $report->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, I'm sure</button>
                                                            </form>
                                                            <button data-modal-hide="popup-modal{{ $report->id }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    {{-- Leaflet Geocoding Control JS --}}
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Function to reverse geocode and update location input
            function updateLocationInput(lat, lon, inputElementId) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`)
                    .then(response => response.json())
                    .then(data => {
                        const name = data.display_name || `${lat}, ${lon}`;
                        document.getElementById(inputElementId).value = name;
                    })
                    .catch(() => {
                        document.getElementById(inputElementId).value = `${lat}, ${lon}`;
                    });
            }

            // --- Map for "Tambah Laporan Baru" Form ---
            var map = L.map('map').setView([-6.200000, 106.816666], 10); // Default to Jakarta
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);

            var marker;

            // Add Geocoding control to the main map
            var geocoder = L.Control.Geocoder.nominatim();
            var searchControl = L.Control.geocoder({
                geocoder: geocoder,
                placeholder: 'Cari lokasi...',
                errorMessage: 'Tidak ditemukan.',
                defaultMarkGeocoded: false
            }).on('markgeocode', function(e) {
                map.fitBounds(e.geocode.bbox);
                if (marker) {
                    marker.setLatLng(e.geocode.center);
                } else {
                    marker = L.marker(e.geocode.center).addTo(map);
                }
                document.getElementById('location').value = e.geocode.name;
            }).addTo(map);


            map.on('click', function(e) {
                const lat = e.latlng.lat.toFixed(6);
                const lon = e.latlng.lng.toFixed(6);

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }
                updateLocationInput(lat, lon, 'location');
            });

            // --- Initialize maps for update modals when they are opened ---
            document.querySelectorAll('[data-modal-toggle^="default-modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.dataset.modalTarget;
                    const reportId = modalId.replace('default-modal', '');
                    const mapContainerId = `modal-map-${reportId}`;
                    const locationInputId = `location_${reportId}`;

                    // Show the modal
                    document.getElementById(modalId).classList.remove('hidden');

                    setTimeout(() => {
                        let modalMapElement = document.getElementById(mapContainerId);

                        // Destroy existing map instance if it exists to prevent re-initialization issues
                        if (modalMapElement._leaflet_id) {
                            modalMapElement._leaflet_map.remove();
                        }

                        // Try to parse coordinates from the existing location value
                        const initialLocationInput = document.getElementById(locationInputId);
                        let initialLat = -6.200000; // Default to Jakarta
                        let initialLon = 106.816666;

                        const locationValue = initialLocationInput.value;
                        // Regex to find coordinates like "latitude, longitude"
                        const latLonMatch = locationValue.match(/(-?\d+\.\d+),\s*(-?\d+\.\d+)/);

                        if (latLonMatch) {
                            initialLat = parseFloat(latLonMatch[1]);
                            initialLon = parseFloat(latLonMatch[2]);
                        } else {
                            // If direct coordinates are not found, attempt to geocode the location string
                            // This might take a moment, so the map will initially center on default, then update
                            geocoder.geocode(locationValue, function(results) {
                                if (results && results.length > 0) {
                                    const firstResult = results[0];
                                    modalMap.setView(firstResult.center, 13);
                                    modalMarker.setLatLng(firstResult.center);
                                }
                            });
                        }

                        let modalMap = L.map(mapContainerId).setView([initialLat, initialLon], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
                        }).addTo(modalMap);

                        let modalMarker = L.marker([initialLat, initialLon]).addTo(modalMap);

                        // Add Geocoding control to the modal map
                        var modalGeocoder = L.Control.Geocoder.nominatim();
                        L.Control.geocoder({
                            geocoder: modalGeocoder,
                            placeholder: 'Cari lokasi...',
                            errorMessage: 'Tidak ditemukan.',
                            defaultMarkGeocoded: false
                        }).on('markgeocode', function(e) {
                            modalMap.fitBounds(e.geocode.bbox);
                            modalMarker.setLatLng(e.geocode.center);
                            document.getElementById(locationInputId).value = e.geocode.name;
                        }).addTo(modalMap);

                        modalMap.on('click', function(e) {
                            const lat = e.latlng.lat.toFixed(6);
                            const lon = e.latlng.lng.toFixed(6);

                            if (modalMarker) {
                                modalMarker.setLatLng(e.latlng);
                            } else {
                                modalMarker = L.marker(e.latlng).addTo(modalMap);
                            }
                            updateLocationInput(lat, lon, locationInputId);
                        });

                        modalMap.invalidateSize();
                        modalMapElement._leaflet_map = modalMap; // Store the map instance
                    }, 100);
                });
            });

            // --- Custom File Input Scripting ---
            document.querySelectorAll('.custom-file-input').forEach(inputElement => {
                inputElement.addEventListener('change', function(event) {
                    const filenameDisplay = event.target.nextElementSibling.querySelector('span'); // Get the span element within the label
                    if (event.target.files.length > 0) {
                        filenameDisplay.textContent = event.target.files[0].name;
                    } else {
                        filenameDisplay.textContent = 'Pilih file...';
                    }
                });
            });

            // --- Handle modal closing to hide backdrop ---
            document.querySelectorAll('[data-modal-hide]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.dataset.modalHide;
                    document.getElementById(modalId).classList.add('hidden');
                });
            });
        });
    </script>
@endsection