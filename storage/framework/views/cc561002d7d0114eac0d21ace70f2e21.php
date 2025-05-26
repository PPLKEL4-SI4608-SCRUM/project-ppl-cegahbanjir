<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>

    <div class="min-h-screen bg-cover bg-center flex items-center justify-center px-4 sm:px-6 lg:px-8 relative" style="background-image: url('<?php echo e(asset('images/background-banjir.png')); ?>')">
        <div class="absolute inset-0 bg-black opacity-60 z-0"></div>

        <div class="z-10 bg-[#121B22]/90 backdrop-blur-md p-8 sm:p-10 rounded-2xl shadow-2xl w-full max-w-md text-white animate-fade-in-up border border-[#FFA404]/30">
            
            <h2 class="text-2xl font-bold mb-6 text-center text-[#FFA404]">Verifikasi Email</h2>

            <p class="mb-4 text-sm text-white/80 leading-relaxed text-center">
                <?php echo e(__('Terima kasih telah mendaftar! Sebelum mulai, silakan verifikasi email kamu melalui link yang kami kirim. Jika belum menerima, klik tombol di bawah untuk mengirim ulang.')); ?>

            </p>

            <?php if(session('status') == 'verification-link-sent'): ?>
                <div class="mb-4 font-medium text-sm text-green-400 text-center">
                    <?php echo e(__('Link verifikasi baru telah dikirim ke email kamu.')); ?>

                </div>
            <?php endif; ?>

            <!-- Tombol Aksi -->
            <div class="flex gap-3 mt-6">
                <!-- Kirim Ulang -->
                <form method="POST" action="<?php echo e(route('verification.send')); ?>" class="w-1/2">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="w-full bg-[#FFA404] hover:bg-yellow-400 text-[#121B22] font-semibold px-4 py-2.5 rounded-lg shadow hover:shadow-lg transition duration-300 transform hover:scale-[1.03] text-sm">
                        Kirim Ulang
                    </button>
                </form>

                <!-- Logout -->
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-1/2">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="w-full bg-transparent border border-white/20 text-white/80 hover:text-yellow-300 hover:border-yellow-300 font-medium px-4 py-2.5 rounded-lg transition duration-300 text-sm">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Back to Login -->
            <!-- Back to Login (dengan logout terlebih dulu) -->
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="text-center mt-6">
                <?php echo csrf_field(); ?>
                <button type="submit"
                    class="inline-block text-sm text-[#FFA404] hover:text-yellow-300 transition duration-300 font-medium underline">
                    ← Kembali ke Login
                </button>
            </form>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH D:\SEMESTER 6\PROYEK PERANGKAT LUNAK\clone-update\project-ppl-cegahbanjir\resources\views/auth/verify-email.blade.php ENDPATH**/ ?>