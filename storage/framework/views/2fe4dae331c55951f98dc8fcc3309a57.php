<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Selamat datang, <?php echo e(Auth::user()->name); ?>!</h1>
        <p class="text-white/80 mt-2">Ini adalah dashboard untuk pengguna <strong>CeBan</strong> (Cegah Banjir)</p>
    </div>
    
    <!-- Quick Links Section -->
    <div class="bg-white/80 p-6 rounded-2xl shadow-xl backdrop-blur-md mb-8">
        <h2 class="text-xl font-semibold text-[#0F1A21] mb-4">Quick Links</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Card: Laporan Bencana -->
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold text-gray-800">Laporan Bencana</h3>
                <p class="text-sm text-gray-600 mt-1">Input & pantau laporan kejadian banjir</p>
                <a href="<?php echo e(route('laporan.index')); ?>" class="mt-4 inline-block bg-[#FFA404] text-white font-semibold px-4 py-2 rounded-lg hover:bg-[#FF8C00] transition">Akses</a>
            </div>
            
            <!-- Card: Prakiraan Cuaca -->
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold text-gray-800">Prakiraan Cuaca</h3>
                <p class="text-sm text-gray-600 mt-1">Lihat prakiraan cuaca terkini</p>
                <a href="<?php echo e(route('user.weather.dashboard')); ?>" class="mt-4 inline-block bg-[#FFA404] text-white font-semibold px-4 py-2 rounded-lg hover:bg-[#FF8C00] transition">Akses</a>
            </div>
            
            <!-- Card: Titik Pantau -->
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold text-gray-800">Titik Pantau</h3>
                <p class="text-sm text-gray-600 mt-1">Pantau status titik banjir</p>
                <a href="#" class="mt-4 inline-block bg-[#FFA404] text-white font-semibold px-4 py-2 rounded-lg hover:bg-[#FF8C00] transition">Akses</a>
            </div>
        </div>
    </div>

    
            <<div class="bg-white/80 p-6 rounded-2xl shadow-xl backdrop-blur-md mb-8">
                <h2 class="text-2xl font-extrabold text-blue-700 text-center">Rekomendasi Tindakan Saat Banjir</h2>
                <p class="text-gray-500 text-center mb-6">Jadi apa yang harus kamu lakukan ketika banjir ada di daerah kamu?</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php $__currentLoopData = $rekomendasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white border border-gray-300 rounded-xl text-center shadow-sm hover:shadow-md w-full max-w-xs py-6 px-4 flex flex-col justify-between">
                            <div class="flex justify-center mb-4">
                                <img src="<?php echo e(url('artikel_icons/' . $item->icon_path)); ?>"
                                    alt="<?php echo e($item->title); ?> icon" class="w-10 h-10">
                            </div>
                            <h3 class="text-md font-semibold text-gray-900 mb-2"><?php echo e($item->title); ?></h3>
                            <p class="text-sm text-gray-600 mb-4">
                                <?php echo e(Str::limit(strip_tags($item->description), 100)); ?></p>
                            <div class="text-right">
                                <a href="<?php echo e(route('rekomendasi.show', $item->id)); ?>"
                                    class="text-sm font-medium text-blue-500 hover:underline">More info</a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="mt-6">
                    <?php echo e($rekomendasis->links()); ?>

                </div>
            </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Informasi Profil & Aktivitas -->
        <div class="space-y-6">
            <!-- Profil Card -->
            <div class="bg-white/90 rounded-xl shadow-lg p-5">
                <div class="flex items-center mb-4">
                    <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center text-2xl font-bold text-gray-600 mr-4">
                        <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-[#0F1A21]"><?php echo e(Auth::user()->name); ?></h2>
                        <p class="text-gray-600"><?php echo e(Auth::user()->email); ?></p>
                    </div>
                </div>
                <div class="border-t border-gray-200 pt-4 mt-2">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="bg-[#FFA404] text-white px-4 py-2 rounded-lg inline-block hover:bg-[#FF8C00] transition">
                        Edit Profil
                    </a>
                </div>
            </div>
            
            <!-- Aktivitas Terbaru -->
            <div class="bg-white/90 rounded-xl shadow-lg p-5">
                <h2 class="text-xl font-semibold text-[#0F1A21] mb-4">Aktivitas Terbaru</h2>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-800">Login terakhir</p>
                            <p class="text-xs text-gray-500"><?php echo e(Auth::user()->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-500 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-800">Laporan banjir terakhir</p>
                            <p class="text-xs text-gray-500">Belum ada laporan</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Nomor Darurat Banjir -->
            <?php if (isset($component)) { $__componentOriginala1245d4958e38f4c133653fb9f5632de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala1245d4958e38f4c133653fb9f5632de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.emergency-numbers','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('emergency-numbers'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala1245d4958e38f4c133653fb9f5632de)): ?>
<?php $attributes = $__attributesOriginala1245d4958e38f4c133653fb9f5632de; ?>
<?php unset($__attributesOriginala1245d4958e38f4c133653fb9f5632de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala1245d4958e38f4c133653fb9f5632de)): ?>
<?php $component = $__componentOriginala1245d4958e38f4c133653fb9f5632de; ?>
<?php unset($__componentOriginala1245d4958e38f4c133653fb9f5632de); ?>
<?php endif; ?>
        </div>
        
        <!-- Kolom Tengah: Informasi Cuaca & Peringatan -->
        <div class="space-y-6">
            <!-- Informasi Cuaca -->
            <div class="bg-white/90 rounded-xl shadow-lg p-5">
                <h2 class="text-xl font-semibold text-[#0F1A21] mb-4">Informasi Cuaca Hari Ini</h2>
                <div class="flex items-center justify-between">
                    <div class="text-center">
                        <div class="text-5xl text-[#FFA404] mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="text-2xl font-bold">29°C</div>
                        <div class="text-gray-600">Jakarta</div>
                    </div>
                    <div class="border-l border-gray-200 pl-6">
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                            <span class="text-sm">Kelembaban: 80%</span>
                        </div>
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M9 10h.01M15 10h.01M9 10h.01M15 10h.01M9 10h.01M15 10h.01" />
                            </svg>
                            <span class="text-sm">Curah Hujan: 70mm</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            <span class="text-sm">Angin: 12 km/h</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="<?php echo e(route('user.weather.dashboard')); ?>" class="text-[#FFA404] font-medium hover:underline">Lihat prakiraan lengkap</a>
                </div>
            </div>
            
            <!-- Peringatan Banjir -->
            <div class="bg-white/90 rounded-xl shadow-lg p-5 border-l-4 border-yellow-500">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h2 class="text-xl font-semibold text-[#0F1A21]">Peringatan Dini</h2>
                </div>
                <p class="text-gray-700 mb-3">
                    Waspada hujan lebat disertai angin kencang di wilayah Jakarta, Bogor, Depok, dan sekitarnya dalam 24 jam ke depan.
                </p>
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <div class="flex items-center">
                        <div class="h-2 w-2 rounded-full bg-yellow-500 mr-2"></div>
                        <span class="text-sm font-medium text-yellow-700">Status: Siaga</span>
                    </div>
                    <p class="text-xs text-yellow-600 mt-1">
                        Diperbarui: 29 April 2025, 09:30 WIB
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Kolom Kanan: Titik Pantau & Tips Banjir -->
        <div class="space-y-6">
            <!-- Titik Pantau Banjir -->
            <div class="bg-white/90 rounded-xl shadow-lg p-5">
                <h2 class="text-xl font-semibold text-[#0F1A21] mb-4">Titik Pantau Banjir</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                        <span class="font-medium">Katulampa</span>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Normal</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                        <span class="font-medium">Manggarai</span>
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Waspada</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                        <span class="font-medium">Depok</span>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Normal</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Jembatan Merah</span>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Normal</span>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="text-[#FFA404] font-medium hover:underline">Lihat semua titik pantau</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 6\PROYEK PERANGKAT LUNAK\clone-update\project-ppl-cegahbanjir\resources\views/user/dashboard.blade.php ENDPATH**/ ?>