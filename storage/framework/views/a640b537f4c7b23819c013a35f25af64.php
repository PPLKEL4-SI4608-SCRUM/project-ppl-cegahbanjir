<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <title><?php echo e(config('app.name', 'CegahBanjir')); ?></title>

    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('images/logo.png')); ?>" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Additional Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.7);
        }
        
        /* Custom focus rings */
        *:focus {
            outline: none;
        }
        
        /* Custom placeholder color */
        ::placeholder {
            opacity: 0.7;
        }
    </style>
</head>
<body class="antialiased font-sans bg-gray-100 min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Optional Header for branding if needed -->
        <header class="bg-blue-900 bg-opacity-95 text-white py-2 px-4 shadow-md hidden">
            <div class="container mx-auto">
                <div class="flex justify-between items-center">
                    <div class="font-semibold">Cegah Banjir</div>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="flex-grow">
            <?php echo e($slot); ?>

        </main>
        
        <!-- Optional Footer -->
        <footer class="bg-blue-900 bg-opacity-95 text-white py-2 px-4 text-center text-xs hidden">
            <div class="container mx-auto">
                &copy; <?php echo e(date('Y')); ?> Cegah Banjir. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html><?php /**PATH D:\SEMESTER 6\PROYEK PERANGKAT LUNAK\branches-baru\project-ppl-cegahbanjir\resources\views/layouts/guest.blade.php ENDPATH**/ ?>