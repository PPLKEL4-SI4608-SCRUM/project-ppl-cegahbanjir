<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 mt-10">
    <div class="bg-gray-100 p-6 rounded-xl shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Artikel</h2>
            <a href="<?php echo e(route('admin.artikels.create')); ?>" class="flex items-center bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-plus mr-2"></i> Tambah Artikel
            </a>
        </div>

        
        <div class="grid grid-cols-5 font-semibold text-gray-700 border-b pb-3 mb-3">
            <div>Judul</div>
            <div>Deskripsi</div>
            <div>Gambar Artikel</div>
            <div>Icon Path</div>
            <div>Aksi</div>
        </div>

        
        <?php $__currentLoopData = $artikels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artikel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="grid grid-cols-5 items-center bg-white p-4 mb-3 rounded-lg shadow-sm">
                
                <div class="text-gray-800 font-medium">
                    <?php echo e($artikel->title); ?>

                </div>

                
                <div class="text-sm text-gray-600">
                    <?php echo e($artikel->description); ?>

                </div>

                
                <div>
                    <?php if($artikel->image_path): ?>
                        <img src="<?php echo e(url('artikel_images/' . $artikel->image_path)); ?>" class="w-20 h-20 object-cover rounded" alt="gambar">
                    <?php else: ?>
                        <span class="text-sm text-gray-500">Tidak Ada</span>
                    <?php endif; ?>
                </div>

                
                <div class="flex gap-2 flex-wrap">
                    <?php $__currentLoopData = $artikel->solutions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $solution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($solution->icon_path): ?>
                            <img src="<?php echo e(url('solution_icons/' . $solution->icon_path)); ?>" class="w-6 h-6 rounded-full" alt="icon">
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="flex gap-2">
                    <a href="<?php echo e(route('admin.artikels.edit', $artikel)); ?>" class="bg-yellow-400 text-black px-3 py-1 rounded flex items-center">
                        <i class="fas fa-pen mr-1"></i>Edit
                    </a>
                    <form action="<?php echo e(route('admin.artikels.destroy', $artikel)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button onclick="return confirm('Yakin ingin hapus artikel ini?')" class="bg-red-600 text-white px-3 py-1 rounded flex items-center">
                            <i class="fas fa-trash mr-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 6\PROYEK PERANGKAT LUNAK\clone-update\project-ppl-cegahbanjir\resources\views/admin/artikels/index.blade.php ENDPATH**/ ?>