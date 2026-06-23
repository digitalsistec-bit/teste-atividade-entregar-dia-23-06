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

<a href="<?php echo e(route('bibliotecas.create')); ?>">Criar Nova Biblioteca</a>

<table>
    <thead>
        <tr>
            <td>id</td>
            <td>responsavel</td>
            <td>nome</td>
            <td>endereco</td>
            <td>telefone</td>
            <td>email</td>
            <td>created_at</td>
            <td>updated_at</td>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $bibliotecas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $biblioteca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($biblioteca->id); ?></td>
                <td>
                    <a href="<?php echo e(route('bibliotecas.edit', ['id' => $biblioteca->id])); ?>"><?php echo e($biblioteca->nome); ?></a>
                </td>
                <td><?php echo e($biblioteca->creator->name); ?></td>
                <td><?php echo e($biblioteca->endereco); ?></td>
                <td><?php echo e($biblioteca->telefone); ?></td>
                <td><?php echo e($biblioteca->email); ?></td>
                <td><?php echo e($biblioteca->created_at); ?></td>
                <td><?php echo e($biblioteca->updated_at); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/bibliotecas/index.blade.php ENDPATH**/ ?>