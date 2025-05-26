<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title'); ?> - Admin CeBan</title>
    <!-- Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Preload background -->
    <link rel="preload" as="image" href="<?php echo e(asset('images/background-banjir2.png')); ?>">
    <!-- Custom Styles -->
    <style>
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #0F1A21;
            transition: background 0.3s ease-in-out;
        }
        .dropdown-menu {
            min-width: 220px;
            left: 0;
            top: 100%;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-cover bg-center min-h-screen text-white font-poppins"
      style="background-image: url('<?php echo e(asset('images/background-banjir2.png')); ?>')">
    <!-- Navbar Admin -->
    <nav class="bg-[#0F1A21]/80 shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Brand -->
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="CeBan" class="w-10 h-10 rounded-full object-cover">
                <span class="text-2xl font-semibold tracking-wide text-white">CeBan <span class="text-[#FFA404]">Admin</span></span>
            </a>
            <!-- Menu & Profile -->
            <div class="flex items-center space-x-10">
                <!-- Admin Menu -->
                <div class="hidden md:flex space-x-6 text-sm font-medium">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-[#FFA404] transition">Dashboard</a>
                    
                    <!-- 1. Manajemen Data Cuaca -->
                    <div class="relative dropdown">
                        <button class="hover:text-[#FFA404] transition focus:outline-none flex items-center gap-1">
                            <i class="fas fa-cloud-sun text-sm"></i>
                            Manajemen Data Cuaca
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute hidden dropdown-menu bg-[#0F1A21] text-white rounded-md mt-2 shadow-lg z-10 border border-gray-600">
                            <a href="<?php echo e(route('admin.weather.stations.index')); ?>" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-broadcast-tower text-sm"></i>
                                Stasiun Cuaca
                            </a>
                            <a href="<?php echo e(route('admin.weather.rainfall.index')); ?>" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-cloud-rain text-sm"></i>
                                Data Curah Hujan
                            </a>
                        </div>
                    </div>

                    <!-- 2. Manajemen Data Banjir -->
                    <div class="relative dropdown">
                        <button class="hover:text-[#FFA404] transition focus:outline-none flex items-center gap-1">
                            <i class="fas fa-water text-sm"></i>
                            Manajemen Data Banjir
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute hidden dropdown-menu bg-[#0F1A21] text-white rounded-md mt-2 shadow-lg z-10 border border-gray-600">
                            <a href="<?php echo e(route('admin.weather.predictions.index')); ?>" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-chart-line text-sm"></i>
                                Prediksi Banjir
                            </a>
                            <a href="<?php echo e(route('admin.disaster-reports.index')); ?>" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle text-sm"></i>
                                Laporan Bencana
                            </a>
                            <a href="<?php echo e(route('admin.weather.disaster-statistics')); ?>" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-chart-bar text-sm"></i>
                                Statistik Laporan Banjir
                            </a>
                            <a href="<?php echo e(route('admin.weather.notification.create')); ?>" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-bell text-sm"></i>
                                Notifikasi
                            </a>
                            <a href="<?php echo e(route('admin.artikels.index')); ?>" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-newspaper text-sm"></i>
                                Artikel Rekomendasi
                            </a>
                        </div>
                    </div>

                    <!-- 3. Manajemen Data Pengguna -->
                    <div class="relative dropdown">
                        <button class="hover:text-[#FFA404] transition focus:outline-none flex items-center gap-1">
                            <i class="fas fa-users text-sm"></i>
                            Manajemen Data Pengguna
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute hidden dropdown-menu bg-[#0F1A21] text-white rounded-md mt-2 shadow-lg z-10 border border-gray-600">
                            <a href="<?php echo e(route('admin.pengguna.index')); ?>" class="block px-4 py-2 hover:bg-[#FFA404] hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-user text-sm"></i>
                                Data Pengguna
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Profile -->
                <div class="relative">
                    <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'right','width' => '48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                         <?php $__env->slot('trigger', null, []); ?> 
                            <button class="flex items-center space-x-2 text-sm font-medium hover:text-[#FFA404] focus:outline-none transition">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M5.121 17.804A8 8 0 0112 4a8 8 0 016.879 13.804M15 21H9a3 3 0 01-3-3v-1a6 6 0 0112 0v1a3 3 0 01-3 3z"/>
                                </svg>
                                <span><?php echo e(Auth::user()->name); ?></span>
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/>
                                </svg>
                            </button>
                         <?php $__env->endSlot(); ?>
                         <?php $__env->slot('content', null, []); ?> 
                            <div class="bg-[#0F1A21] rounded-md shadow-md py-2">
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => ''.e(route('logout')).'','class' => 'font-poppins text-white hover:bg-[#FFA404] hover:text-white transition px-4 py-2 block','onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('logout')).'','class' => 'font-poppins text-white hover:bg-[#FFA404] hover:text-white transition px-4 py-2 block','onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']); ?>
                                        <?php echo e(__('Log Out')); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                                </form>
                            </div>
                         <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    <main class="py-10 px-6">
        <?php if(session('success')): ?>
            <div class="bg-green-500/80 text-white px-4 py-3 rounded mb-4 shadow-md">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('warning')): ?>
            <div class="bg-yellow-500/80 text-white px-4 py-3 rounded mb-4 shadow-md">
                <?php echo e(session('warning')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="bg-red-500/80 text-white px-4 py-3 rounded mb-4 shadow-md">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    
    <!-- Footer -->
    <footer class="bg-[#0F1A21]/90 text-white py-6 mt-12">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-4">
            <div>
                <h5 class="text-xl font-semibold mb-2">CeBan (Cegah Banjir)</h5>
                <p>Sistem peringatan dini dan pencegahan banjir</p>
            </div>
            <div class="text-md md:text-right">
                <h5 class="text-xl font-semibold mb-2">Kontak</h5>
                <p>Email: info@ceban.id<br>Telepon: (021) 1234-5678</p>
            </div>
        </div>
        <hr class="my-4 border-gray-600">
        <p class="text-center text-sm">&copy; <?php echo e(date('Y')); ?> CeBan. Hak Cipta Dilindungi.</p>
    </footer>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\SEMESTER 6\PROYEK PERANGKAT LUNAK\clone-update\project-ppl-cegahbanjir\resources\views/layouts/admin.blade.php ENDPATH**/ ?>