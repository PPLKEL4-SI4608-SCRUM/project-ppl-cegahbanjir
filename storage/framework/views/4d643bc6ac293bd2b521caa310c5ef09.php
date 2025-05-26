<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 mt-10">
    <h2 class="text-3xl font-extrabold text-white mb-6 drop-shadow">Kelola Laporan Bencana</h2>

    <?php if(session('success')): ?>
        <div class="bg-green-500 text-white px-4 py-3 rounded-lg shadow mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="bg-white/90 backdrop-blur rounded-xl shadow-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-700 text-sm font-semibold uppercase">
                <tr>
                    <th class="py-4 px-6">Pelapor</th>
                    <th class="py-4 px-6">Lokasi</th>
                    <th class="py-4 px-6">Deskripsi</th>
                    <th class="py-4 px-6">Gambar</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-800">
                <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-b hover:bg-gray-50 transition duration-200">
                    <td class="py-4 px-6"><?php echo e($report->user->name); ?></td>
                    <td class="py-4 px-6"><?php echo e($report->location); ?></td>
                    <td class="py-4 px-6"><?php echo e($report->description); ?></td>
                    <td class="py-4 px-6">
                        <?php if($report->disaster_image): ?>
                            <img src="<?php echo e(asset('disaster_images/' . $report->disaster_image)); ?>" class="w-24 h-16 object-cover rounded shadow" alt="Bukti Bencana">
                        <?php else: ?>
                            <span class="italic text-gray-400">Tidak ada gambar</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-4 px-6 capitalize">
                        <span class="px-2 py-1 rounded text-white <?php echo e($report->status == 'pending' ? 'bg-yellow-500' : 'bg-green-600'); ?>">
                            <?php echo e($report->status); ?>

                        </span>
                    </td>
                    <td class="py-4 px-6 space-x-2">
                        <?php if($report->status == 'pending'): ?>
                            <form action="<?php echo e(route('admin.disaster-reports.accept', $report->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded shadow">
                                    Terima
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.disaster-reports.reject', $report->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow">
                                    Tolak
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="italic text-gray-500">Sudah diproses</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 6\PROYEK PERANGKAT LUNAK\clone-update\project-ppl-cegahbanjir\resources\views/admin/disaster_reports/index.blade.php ENDPATH**/ ?>