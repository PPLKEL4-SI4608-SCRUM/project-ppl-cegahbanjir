@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            z-index: 10;
        }

        .custom-file-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #374151;
            color: #d1d5db;
            border: 1px solid #4b5563;
            border-radius: 0.5rem;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }

        .custom-file-label:hover {
            background-color: #4b5563;
            border-color: #6b7280;
        }

        .custom-file-label svg {
            flex-shrink: 0;
            margin-left: 0.5rem;
        }

        .modal-content-container {
            background-color: #fff;
            color: #1a202c;
            position: relative;
            z-index: 60;
        }
        .dark .modal-content-container {
            background-color: rgba(55, 65, 81, 5);
            color: #d1d5db;
        }

        .leaflet-control-geocoder .leaflet-control-geocoder-form input {
            font-family: 'Poppins', sans-serif !important;
            border-radius: 0.25rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border: 1px solid #ccc;
            outline: none;
            box-shadow: none;
        }

        .leaflet-control-geocoder-form.geocoding-icon-throbber input {
            background-image: url('{{ asset('images/loading-cute.gif') }}');
            background-repeat: no-repeat;
            background-position: calc(100% - 8px) center;
            background-size: 20px 20px;
            padding-right: 30px;
        }

        [data-modal-show][data-modal-target],
        [data-modal-toggle][data-modal-target] {
            cursor: pointer;
        }

        body.overflow-hidden {
            overflow: hidden !important;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-white">Laporan Kejadian Bencana</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

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

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Riwayat Laporan</h2>
            @if ($reports->isEmpty())
                <p class="text-gray-600">Belum ada laporan yang tersedia.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="px-4 py-2 border">No.</th>
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
                                            <span class="text-blue-400 font-semibold">Approved</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">{{ $report->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-4 py-2 border">
                                        <button data-modal-target="default-modal{{ $report->id }}" data-modal-toggle="default-modal{{ $report->id }}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    @foreach ($reports as $report)
        <div id="default-modal{{ $report->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full overflow-y-auto overflow-x-hidden hidden bg-gray-900 bg-opacity-50">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative rounded-lg shadow-sm modal-content-container">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-black">Detail</h3>
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
                                <button type="submit" class="text-white bg-[#FFA404] hover:bg-[#e69400] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                                <button type="button" data-modal-target="popup-modal{{ $report->id }}" data-modal-toggle="popup-modal{{ $report->id }}" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-red rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="popup-modal{{ $report->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900 bg-opacity-50">
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
                        <div class="flex justify-center items-center space-x-4">
                            <form action="{{ route('laporan.destroy', $report->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, I'm sure</button>
                            </form>
                            <button data-modal-hide="popup-modal{{ $report->id }}" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js" defer></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin="" defer></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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

            var map = L.map('map').setView([-6.200000, 106.816666], 10);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);

            var marker;

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

            let openModalsCount = 0;
            const mainMapElement = document.getElementById('map');

            document.querySelectorAll('[data-modal-toggle^="default-modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    openModalsCount++;
                    if (mainMapElement) {
                        mainMapElement.style.display = 'none';
                    }

                    const modalId = this.dataset.modalTarget;
                    const reportId = modalId.replace('default-modal', '');
                    const mapContainerId = `modal-map-${reportId}`;
                    const locationInputId = `location_${reportId}`;

                    document.body.classList.add('overflow-hidden');

                    setTimeout(() => {
                        let modalMapElement = document.getElementById(mapContainerId);

                        if (modalMapElement && modalMapElement._leaflet_id) {
                            modalMapElement._leaflet_map.remove();
                            modalMapElement._leaflet_map = null;
                        }
                        
                        modalMapElement.style.display = 'block';


                        const initialLocationInput = document.getElementById(locationInputId);
                        let initialLat = -6.200000;
                        let initialLon = 106.816666;

                        const locationValue = initialLocationInput.value;
                        const latLonMatch = locationValue.match(/(-?\d+\.\d+),\s*(-?\d+\.\d+)/);

                        if (latLonMatch) {
                            initialLat = parseFloat(latLonMatch[1]);
                            initialLon = parseFloat(latLonMatch[2]);
                        } else {
                            geocoder.geocode(locationValue, function(results) {
                                if (results && results.length > 0) {
                                    const firstResult = results[0];
                                    if (modalMap) {
                                        modalMap.setView(firstResult.center, 13);
                                        modalMarker.setLatLng(firstResult.center);
                                    }
                                }
                            });
                        }

                        let modalMap = L.map(mapContainerId).setView([initialLat, initialLon], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
                        }).addTo(modalMap);

                        let modalMarker = L.marker([initialLat, initialLon]).addTo(modalMap);

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
                        modalMapElement._leaflet_map = modalMap;
                    }, 100);
                });
            });

            document.querySelectorAll('.custom-file-input').forEach(inputElement => {
                inputElement.addEventListener('change', function(event) {
                    const filenameDisplay = event.target.nextElementSibling.querySelector('span');
                    if (event.target.files.length > 0) {
                        filenameDisplay.textContent = event.target.files[0].name;
                    } else {
                        filenameDisplay.textContent = 'Pilih file...';
                    }
                });
            });

            document.querySelectorAll('[data-modal-toggle^="popup-modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const detailModalId = this.dataset.modalTarget.replace('popup-modal', 'default-modal');
                    const detailModalElement = document.getElementById(detailModalId);
                    const detailMapElement = detailModalElement.querySelector('.modal-map');

                    if (detailMapElement) {
                        detailMapElement.style.display = 'none';
                    }
                });
            });

            document.querySelectorAll('[data-modal-hide]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalIdToHide = this.dataset.modalHide;
                    
                    if (modalIdToHide.startsWith('popup-modal')) {
                        const reportId = modalIdToHide.replace('popup-modal', '');
                        const detailModalId = `default-modal${reportId}`;
                        const detailModalElement = document.getElementById(detailModalId);
                        const detailMapElement = detailModalElement.querySelector('.modal-map');
                        
                        if (detailModalElement && !detailModalElement.classList.contains('hidden')) {
                            if (detailMapElement) {
                                detailMapElement.style.display = 'block';
                                if (detailMapElement._leaflet_map) {
                                    detailMapElement._leaflet_map.invalidateSize();
                                }
                            }
                        }
                    }

                    if (modalIdToHide.startsWith('default-modal')) {
                        openModalsCount--;
                        if (openModalsCount <= 0) {
                            document.body.classList.remove('overflow-hidden');
                            if (mainMapElement) {
                                mainMapElement.style.display = 'block';
                                map.invalidateSize();
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection