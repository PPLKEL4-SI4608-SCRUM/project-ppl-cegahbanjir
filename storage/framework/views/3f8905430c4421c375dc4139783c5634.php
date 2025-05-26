<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cegah Banjir - Dashboard</title>

    <!-- Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Preload background image -->
    <link rel="preload" as="image" href="<?php echo e(asset('images/background-banjir2.png')); ?>">

    <!-- Custom font style -->
    <style>
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #0F1A21;
            transition: background 0.3s ease-in-out;
        }
    </style>
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo $__env->yieldContent('head'); ?>
</head>

<body class="bg-cover bg-center min-h-screen text-gray-900 font-poppins"
    style="background-image: url('<?php echo e(asset('images/background-banjir2.png')); ?>')">

    <!-- Navbar -->
    <nav class="bg-[#0F1A21]/70 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo + Title -->
            <div class="flex items-center gap-2">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Cegah Banjir Logo" class="w-10 h-10 rounded-full object-cover">
                <span class="text-3xl font-semibold tracking-wide">
                    Cegah<span class="text-[#FFA404]"> Banjir</span>
                </span>
            </div>

            <!-- Navigation + Profile -->
            <div class="flex items-center space-x-10">
                <!-- Main Links -->
                <div class="hidden md:flex space-x-6 text-sm font-medium items-center">
                    <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-[#FFA404] transition">Home</a>

                    <!-- About Dropdown (styled like Admin dropdown) -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="hover:text-[#FFA404] transition flex items-center space-x-1 focus:outline-none">
                            <span>About</span>
                            <svg class="w-4 h-4 transform transition duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="absolute z-30 mt-2 bg-[#0F1A21] text-white rounded-md shadow-xl w-56">
                            <a href="<?php echo e(route('laporan.index')); ?>"
                               class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-[#FFA404]/90 transition">
                                <i class="fas fa-water"></i>
                                <span>Laporan Bencana</span>
                            </a>
                        </div>
                    </div>

                    <a href="<?php echo e(route('user.map')); ?>" class="hover:text-[#FFA404] transition">Interactive Map</a>
                    <a href="#" class="hover:text-[#FFA404] transition">Data Portal</a>
                    <a href="#" class="hover:text-[#FFA404] transition">Publications</a>
                    <a href="<?php echo e(route('user.weather.dashboard')); ?>" class="hover:text-[#FFA404] transition">Weather</a>
                    <a href="#" class="hover:text-[#FFA404] transition">Past Floods</a>
                </div>

                <!-- Profile Dropdown -->
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
                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A8 8 0 0112 4a8 8 0 016.879 13.804M15 21H9a3 3 0 01-3-3v-1a6 6 0 0112 0v1a3 3 0 01-3 3z" />
                                </svg>
                                <span><?php echo e(Auth::user()->name); ?></span>
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4" />
                                </svg>
                            </button>
                         <?php $__env->endSlot(); ?>

                         <?php $__env->slot('content', null, []); ?> 
                            <div class="bg-[#0F1A21] rounded-md shadow-md py-2">
                                <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => ''.e(route('profile.edit')).'','class' => 'font-poppins text-white hover:bg-[#FFA404]/70 hover:text-white transition px-4 py-2 block']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('profile.edit')).'','class' => 'font-poppins text-white hover:bg-[#FFA404]/70 hover:text-white transition px-4 py-2 block']); ?>
                                    <?php echo e(__('Edit Profile')); ?>

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

                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => ''.e(route('logout')).'','class' => 'font-poppins text-white hover:bg-[#FFA404]/70 hover:text-white transition px-4 py-2 block','onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('logout')).'','class' => 'font-poppins text-white hover:bg-[#FFA404]/70 hover:text-white transition px-4 py-2 block','onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']); ?>
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

    <!-- Page Content -->
    <main class="py-12 px-6">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\SEMESTER 6\PROYEK PERANGKAT LUNAK\clone-update\project-ppl-cegahbanjir\resources\views/layouts/app.blade.php ENDPATH**/ ?>