<?php $__env->startSection('head'); ?>
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    #map,
    .modal-map {
        height: 300px;
        margin-top: 1rem;
        border-radius: 0.5rem;
        overflow: hidden;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Main modal -->
<div class="max-w-5xl mx-auto p-6">
<h1 class="text-3xl font-bold mb-6 text-white">Laporan Kejadian Bencana</h1>
<?php $__env->startSection('content'); ?>
<!-- Main modal -->
<div class="max-w-5xl mx-auto p-6">
<h1 class="text-3xl font-bold mb-6 text-gray-800">Laporan Kejadian Bencana</h1>
    
    <?php if(session('success')): ?>
        <div class="bg-green-100 text-green-800 p-3 rounded mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-black-700">Tambah Laporan Baru</h2>
        <form method="POST" action="<?php echo e(route('laporan.store')); ?>" class="space-y-4" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div>
                <label for="location" class="block text-black font-medium bg-[#121B22] px-3 py-1 rounded">Lokasi Kejadian</label>
                <input type="text" id="location" name="location" value="<?php echo e(old('location')); ?>" required
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">
                <div id="map" class="w-full mt-4 rounded" style="height: 300px;"></div>
                <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="description" class="block text-black font-medium bg-[#121B22] px-3 py-1 rounded">Deskripsi Kejadian</label>
                <textarea id="description" name="description" rows="3" required
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400"><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="block mb-2 text-black font-medium bg-[#121B22] px-3 py-1 rounded" for="file_input">Foto Lokasi Kejadian</label>
                <label class="block mb-2 text-black font-medium bg-[#121B22] px-3 py-1 rounded" for="file_input">Foto Lokasi
                    Kejadian</label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    id="disaster_image" name="disaster_image" type="file" required>
                <?php $__errorArgs = ['disaster_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <button type="submit" class="bg-[#FFA404] text-black px-4 py-2 rounded hover:bg-[#e69400] transition">
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>

    
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Riwayat Laporan</h2>
        <?php if($reports->isEmpty()): ?>
            <p class="text-gray-600">Belum ada laporan yang tersedia.</p>
        <?php else: ?>
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
                        <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border"><?php echo e($index + 1); ?></td>
                                <td class="px-4 py-2 border"><?php echo e($report->user->name ?? 'Tidak diketahui'); ?></td>
                                <td class="px-4 py-2 border"><?php echo e($report->location); ?></td>
                                <td class="px-4 py-2 border"><?php echo e($report->description); ?></td>
                                <td class="px-4 py-2 border"><img class="card-img-top"
                                        src="<?php echo e(url('disaster_images/' . $report->disaster_image)); ?>" alt="image" />
                                </td>
                                <td class="px-4 py-2 border">
                                    <?php if($report->status == 'rejected'): ?>
                                        <span class="text-red-600 font-semibold">Rejected</span>
                                    <?php elseif($report->status == 'pending'): ?>
                                        <span class="text-yellow-600 font-semibold">Pending</span>
                                    <?php else: ?>
                                        <span class="text-blue-600 font-semibold">Approved</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-2 border"><?php echo e($report->created_at->format('d M Y, H:i')); ?></td>
                                <td class="px-4 py-2 border">
                                    <button data-modal-target="default-modal<?php echo e($report->id); ?>"
                                        data-modal-toggle="default-modal<?php echo e($report->id); ?>"
                                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        type="button">
                                        Detail
                                    </button>
                                </td>
                                <div id="default-modal<?php echo e($report->id); ?>" tabindex="-1" aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-50 md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div
                                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Detail
                                                </h3>
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="default-modal<?php echo e($report->id); ?>">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="<http://www.w3.org/2000/svg>" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-4 md:p-5 space-y-4">
                                                <form method="POST"
                                                    action="<?php echo e(route('laporan.update', $report->id)); ?>"
                                                    class="space-y-4" enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <div>
                                                        <label for="location"
                                                            class="block text-white font-medium bg-[#121B22] px-3 py-1 rounded">Lokasi
                                                            Kejadian</label>
                                                        <input type="text" id="location" name="location"
                                                            value="<?php echo e($report->location); ?>" required
                                                            class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">
                                                        <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div>
                                                        <label for="description"
                                                            class="block text-white font-medium bg-[#121B22] px-3 py-1 rounded">Deskripsi
                                                            Kejadian</label>
                                                        <textarea id="description" name="description" rows="3" required
                                                            class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400"><?php echo e($report->description); ?></textarea>
                                                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div>
                                                        <label for="status"
                                                            class="block text-white font-medium bg-[#121B22] px-3 py-1 rounded">Status</label>
                                                        <select id="status" name="status" required disabled
                                                            class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-400">
                                                            <option value="">Pilih Status</option>
                                                            <option value="rejected"
                                                                <?php echo e($report->status == 'rejected' ? 'selected' : ''); ?>>
                                                                Merah (Rejected)</option>
                                                            <option value="pending"
                                                                <?php echo e($report->status == 'pending' ? 'selected' : ''); ?>>
                                                                Kuning (Pending)</option>
                                                            <option value="approved"
                                                                <?php echo e($report->status == 'approved' ? 'selected' : ''); ?>>
                                                                Biru (Approved)</option>
                                                        </select>
                                                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-white font-medium bg-[#121B22] px-3 py-1 rounded" for="file_input">Foto Lokasi
                                                            Kejadian</label>
                                                        <input
                                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                            id="disaster_image" name="disaster_image" type="file">
                                                        <?php $__errorArgs = ['disaster_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div
                                                class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                <button type="submit"
                                                    class="text-white bg-[#FFA404] hover:bg-[#e69400] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    update</button>
                                                <button type="button"
                                                    data-modal-target="popup-modal<?php echo e($report->id); ?>"
                                                    data-modal-toggle="popup-modal<?php echo e($report->id); ?>"
                                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-red rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Delete</button>
                                            </div>
                                            </form>
                                            <div id="popup-modal<?php echo e($report->id); ?>" tabindex="-1"
                                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative p-4 w-full max-w-md max-h-full">
                                                    <div
                                                        class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                                        <button type="button"
                                                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                            data-modal-hide="popup-modal<?php echo e($report->id); ?>">
                                                            <svg class="w-3 h-3" aria-hidden="true"
                                                                xmlns="<http://www.w3.org/2000/svg>" fill="none"
                                                                viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                        <div class="p-4 md:p-5 text-center">
                                                            <h3
                                                                class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                                Are you sure you want to delete this Data?</h3>
                                                            <form action="<?php echo e(route('laporan.destroy', $report->id)); ?>"
                                                                method="POST">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit"
                                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                                    Yes, I'm sure
                                                                </button>
                                                            </form>
                                                            <button data-modal-hide="popup-modal<?php echo e($report->id); ?>"
                                                                type="button"
                                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                                                                cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var map = L.map('map').setView([-6.200000, 106.816666], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker;

        map.on('click', function(e) {
            const lat = e.latlng.lat.toFixed(6);
            const lon = e.latlng.lng.toFixed(6);

            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }

            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                    const name = data.display_name || `${lat}, ${lon}`;
                    document.getElementById('location').value = name;
                })
                .catch(() => {
                    document.getElementById('location').value = `${lat}, ${lon}`;
                });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 6\PROYEK PERANGKAT LUNAK\clone-update\project-ppl-cegahbanjir\resources\views/disaster/index.blade.php ENDPATH**/ ?>