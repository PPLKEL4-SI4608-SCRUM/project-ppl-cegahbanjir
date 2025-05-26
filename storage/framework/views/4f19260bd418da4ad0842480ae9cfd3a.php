<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-8 mt-10">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Tambah Artikel Rekomendasi</h2>

    <?php if($errors->any()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.artikels.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
            <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 text-gray-800" required>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Artikel</label>
            <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 text-gray-800" required></textarea>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Utama Artikel</label>
            <input type="file" name="image" accept="image/*" class="text-sm text-gray-600">
        </div>

        <div class="mb-6">
            <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Ikon Utama Artikel</label>
            <input type="file" name="icon" accept="image/*" class="text-sm text-gray-600">
        </div>

        <h3 class="text-xl font-semibold text-gray-800 mb-3">Solusi / Cara</h3>
        <div id="solution-container" class="space-y-4">
            <div class="border border-gray-300 bg-gray-50 p-4 rounded-lg">
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Solusi</label>
                    <input type="text" name="solution_titles[]" class="w-full border border-gray-300 rounded-lg shadow-sm text-gray-800" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Solusi</label>
                    <textarea name="solution_descriptions[]" rows="2" class="w-full border border-gray-300 rounded-lg shadow-sm text-gray-800" required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Ikon Solusi</label>
                    <input type="file" name="solution_icons[]" class="block mt-1 text-sm text-gray-500">
                </div>
            </div>
        </div>

        <button type="button" id="add-solution" class="mt-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
            + Tambah Solusi
        </button>

        <div class="mt-8 flex justify-between items-center">
            <a href="<?php echo e(route('admin.artikels.index')); ?>" class="text-gray-600 hover:underline">← Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg">
                Simpan Artikel
            </button>
        </div>
    </form>
</div>

<script>
    let solutionIndex = 1;
    document.getElementById('add-solution').addEventListener('click', function () {
        const container = document.getElementById('solution-container');
        const html = `
        <div class="border border-gray-300 bg-gray-50 p-4 rounded-lg mt-4">
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Solusi</label>
                <input type="text" name="solution_titles[]" class="w-full border border-gray-300 rounded-lg shadow-sm text-gray-800" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Solusi</label>
                <textarea name="solution_descriptions[]" rows="2" class="w-full border border-gray-300 rounded-lg shadow-sm text-gray-800" required></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Ikon Solusi</label>
                <input type="file" name="solution_icons[]" class="block mt-1 text-sm text-gray-500">
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
        solutionIndex++;
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 6\PROYEK PERANGKAT LUNAK\clone-update\project-ppl-cegahbanjir\resources\views/admin/artikels/create.blade.php ENDPATH**/ ?>