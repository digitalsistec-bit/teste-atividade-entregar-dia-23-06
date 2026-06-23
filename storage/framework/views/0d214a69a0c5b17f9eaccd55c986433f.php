<?php $__env->startSection('content'); ?>
<?php if(session('message')): ?>
<div class="alert"></div>
    <?php echo e(session('message')); ?>

</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="alert"></div>
    <?php echo e(session('error')); ?>

</div>
<?php endif; ?>

<a href="<?php echo e(route('autores.create')); ?>">Cadastrar novo Autor</a>

<table>
    <thead>
        <tr>
            <td>id</td>
            <td>nome</td>
            <td>nacionalidade</td>
            <td>data_nascimento</td>
            <td>created_at</td>
            <td>updated_at</td>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $autores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($autor->id); ?></td>
                <td>
                    <a href="<?php echo e(route('autores.edit', ['id' => $autor->id])); ?>"><?php echo e($autor->nome); ?></a>
                </td>
                <td><?php echo e($autor->nacionalidade); ?></td>
                <td><?php echo e($autor->data_nascimento); ?></td>
                <td><?php echo e($autor->created_at); ?></td>
                <td><?php echo e($autor->updated_at); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/autores/index.blade.php ENDPATH**/ ?>