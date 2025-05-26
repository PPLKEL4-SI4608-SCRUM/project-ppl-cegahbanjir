<?php $__env->startSection('title', 'Buat Notifikasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white shadow rounded-lg p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Buat Notifikasi</h1>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2 text-gray-700"></i> Kembali
        </a>
    </div>

<div class="bg-white shadow rounded-lg p-6">
    <form action="<?php echo e(route('admin.weather.notification.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-4">
            <label for="weather_station_id" class="block text-sm font-medium text-gray-700">Lokasi<span class="text-red-500">*</span></label>
            <select id="weather_station_id" name="weather_station_id" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 <?php $__errorArgs = ['weather_station_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <option value="">Pilih Lokasi</option>
                <?php $__currentLoopData = $weatherStations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $station): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($station->id); ?>" <?php echo e(old('weather_station_id') == $station->id ? 'selected' : ''); ?>>
                        <?php echo e($station->name); ?> - (<?php echo e($station->location); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['weather_station_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="flex justify-end gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 text-xs text-white bg-yellow-600 rounded hover:bg-yellow-700">
                    Kirim Notifikasi
                </button>
            </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 6\PROYEK PERANGKAT LUNAK\clone-update\project-ppl-cegahbanjir\resources\views/admin/weather/notification/create.blade.php ENDPATH**/ ?>