<?php $__env->startSection('title', 'Dashboard Cuaca'); ?>

<?php $__env->startSection('content'); ?>
    <?php if($notifications): ?>
        <div id="notification-alert" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-yellow-200 text-yellow-800 px-6 py-4 rounded-lg shadow-lg z-50 max-w-md w-full">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold">📢 PERINGATAN BANJIR 📢</h3>
                <button onclick="document.getElementById('notification-alert').remove()" class="text-xl font-bold text-yellow-800 hover:text-red-600">&times;</button>
            </div>
            <div class="space-y-2 max-h-60 overflow-y-auto">
                <div class="border-t border-yellow-400 pt-2">
                    <!-- Menampilkan Nama Stasiun dan Lokasi -->
                    <p><strong>Stasiun:</strong> <?php echo e($stationName); ?></p>
                    <p><strong>Lokasi:</strong> <?php echo e($stationLocation); ?></p>
                </div>
            </div>

             <!-- Tombol untuk berbagi ke Twitter dengan Tailwind CSS -->
            <a href="<?php echo e($twitterShareUrl); ?>" target="_blank" class="inline-block px-6 py-3 mt-4 text-white bg-red-600 rounded-full text-center font-semibold hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-white-500 focus:ring-opacity-50">
                Bagikan ke Twitter
            </a>

        </div>

        <!-- <script>
            setTimeout(() => {
                const el = document.getElementById('notification-alert');
                if (el) el.remove();
            }, 15000); // hilang setelah 15 detik
        </script> -->
    <?php endif; ?>




    
    <link href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">

    <div style="max-width: 1200px; margin: -40px auto 0; padding: 10px 20px;">

        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="font-size: 32px; margin-bottom: 10px;">Cuaca & Prediksi</h2>
            <form action="<?php echo e(route('user.weather.dashboard')); ?>" method="GET" style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
                <input type="text" name="search" placeholder="Cari nama kota..."
                       value="<?php echo e(request('search')); ?>"
                       style="padding: 12px 20px; border-radius: 25px; border: none; background-color: #2a2b2d; color: white; width: 250px;">
                <button type="submit" style="padding: 12px 20px; border-radius: 25px; border: none; background-color: #FFA404; color: white;">
                    <i class="fa-regular fa-search"></i> Cari
                </button>
            </form>
        </div>

        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px;">

            
            <div style="background-color: #2a2b2d; padding: 20px; border-radius: 15px; color: white;">
                <h3 style="margin-bottom: 10px;">🌡️ Cuaca Sekarang</h3>
                <?php if(count($rainfalls) > 0): ?>
                    <h2 style="font-size: 36px;"><?php echo e($rainfalls[0]->rainfall_amount); ?>&deg;C</h2>
                    <p><?php echo e($rainfalls[0]->weatherStation->name ?? 'Stasiun tidak diketahui'); ?></p>
                    <p><i class="fa-light fa-calendar"></i> <?php echo e(\Carbon\Carbon::parse($rainfalls[0]->recorded_at)->format('d M Y H:i')); ?></p>
                <?php else: ?>
                    <p>Data tidak tersedia.</p>
                <?php endif; ?>
            </div>

            
            <div style="background-color: #2a2b2d; padding: 20px; border-radius: 15px; color: white;">
                <h3 style="margin-bottom: 10px;">📍 Stasiun Cuaca</h3>
                <?php $__empty_1 = true; $__currentLoopData = $stations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $station): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div style="margin-bottom: 10px; border-bottom: 1px solid #999; padding-bottom: 5px;">
                        <p><i class="bx bx-map"></i> <?php echo e($station->name); ?></p>
                        <p><i class="bx bx-location-plus"></i> <?php echo e($station->location); ?></p>
                        <p><i class="bx bx-current-location"></i> <?php echo e($station->latitude); ?>, <?php echo e($station->longitude); ?></p>
                        <p><i class="bx bx-signal-4"></i> Status: <?php echo e(ucfirst($station->status)); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>Belum ada stasiun cuaca.</p>
                <?php endif; ?>
            </div>

            
            <div style="background-color: #2a2b2d; padding: 20px; border-radius: 15px; color: white; grid-column: span 2;">
                <h3 style="margin-bottom: 10px;">🌊 Prediksi Banjir</h3>
                <?php $__empty_1 = true; $__currentLoopData = $predictions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pred): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div style="margin-bottom: 15px; border-bottom: 1px solid #999; padding-bottom: 5px;">
                        <p><i class="bx bx-calendar-alt"></i> <?php echo e(\Carbon\Carbon::parse($pred->prediction_date)->format('d M Y')); ?></p>
                        <p><i class="bx bx-map-pin"></i> <?php echo e($pred->weatherStation->name ?? '-'); ?></p>
                        <p><i class="bx bx-error-circle"></i> Risiko: <strong><?php echo e(ucfirst($pred->risk_level)); ?></strong></p>
                        <p><i class="bx bx-cloud-rain"></i> Prediksi Curah Hujan: <?php echo e($pred->predicted_rainfall ?? '-'); ?> mm</p>
                        <p><i class="bx bx-note"></i> <?php echo e($pred->notes); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>Tidak ada data prediksi.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 6\PROYEK PERANGKAT LUNAK\clone-update\project-ppl-cegahbanjir\resources\views/user/weather.blade.php ENDPATH**/ ?>