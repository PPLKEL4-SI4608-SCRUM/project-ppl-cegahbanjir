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

        /* Smooth icon eye transition */
        .eye-button svg {
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .eye-button:hover svg {
            transform: scale(1.15);
            color: #FFD75E;
        }

        /* Custom checkbox styling */
        input[type="checkbox"].custom-checkbox {
            appearance: none;
            background-color: #0F1A21;
            border: 2px solid #FFA404;
            width: 18px;
            height: 18px;
            border-radius: 4px;
            position: relative;
            transition: background-color 0.3s, border-color 0.3s;
        }

        input[type="checkbox"].custom-checkbox:checked {
            background-color: #FFA404;
        }

        input[type="checkbox"].custom-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>

    <div class="min-h-screen bg-cover bg-center flex items-center justify-center px-4 sm:px-6 lg:px-8 relative" style="background-image: url('<?php echo e(asset('images/background-banjir.png')); ?>')">
        <div class="absolute inset-0 bg-black opacity-60 z-0"></div>

        <div class="z-10 bg-[#121B22]/90 backdrop-blur-md p-8 sm:p-10 rounded-2xl shadow-2xl w-full max-w-md text-white animate-fade-in-up">
            
            <!-- Logo & Title -->
            <div class="flex flex-col items-center justify-center mb-6 sm:mb-8">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo Cegah Banjir" class="w-16 h-16 sm:w-20 sm:h-20 mb-2">
                <span class="text-xl sm:text-2xl md:text-3xl font-bold text-[#FFA404]">Cegah Banjir</span>  
            </div>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm mb-2 text-white/80 font-medium">Email</label>
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                        class="w-full px-4 py-3 pr-4 rounded-lg bg-[#0F1A21] border border-[#FFA404]/30 placeholder-[#CCCCCC] text-white focus:outline-none focus:ring-2 focus:ring-[#FFA404] transition placeholder:text-left placeholder:align-middle"
                        placeholder="example@gmail.com" />
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-300 text-sm"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm mb-2 text-white/80 font-medium">Password</label>
                    <div class="relative flex">
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-3 pr-10 rounded-lg bg-[#0F1A21] border border-[#FFA404]/30 placeholder-[#CCCCCC] text-white focus:outline-none focus:ring-2 focus:ring-[#FFA404] transition placeholder:text-left text-left"
                            placeholder="********" />

                        <!-- Eye Icon -->
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 text-[#FFA404] hover:text-yellow-300 transition duration-300 ease-in-out flex items-center h-full">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-300 text-sm"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Remember Me -->
                <div class="mb-5 flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="custom-checkbox">
                    <label for="remember_me" class="ml-3 text-sm text-white/70 select-none">Ingat saya</label>
                </div>

                <!-- Forgot password & Login -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                    <?php if(Route::has('password.request')): ?>
                        <a class="text-sm text-[#FFA404] hover:text-yellow-300 transition-colors duration-300" href="<?php echo e(route('password.request')); ?>">
                            Lupa password?
                        </a>
                    <?php endif; ?>
                    <button type="submit"
                        class="w-full sm:w-auto bg-[#FFA404] hover:bg-yellow-400 text-[#121B22] font-semibold px-6 py-2.5 rounded-lg shadow hover:shadow-lg transition-all duration-300 transform hover:scale-[1.03]">
                        Login
                    </button>
                </div>

                <!-- Register -->
                <div class="text-center text-sm mt-4">
                    <span class="text-white/70">Belum punya akun?</span>
                    <a href="<?php echo e(route('register')); ?>" class="text-[#FFA404] hover:text-yellow-300 transition-colors duration-300 font-medium">Register di sini</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Toggle Password Script -->
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.27-2.943-9.544-7A10.05 10.05 0 015.22 6.222M9.88 9.88a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8" />`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
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
<?php /**PATH D:\SEMESTER 6\PROYEK PERANGKAT LUNAK\clone-update\project-ppl-cegahbanjir\resources\views/auth/login.blade.php ENDPATH**/ ?>