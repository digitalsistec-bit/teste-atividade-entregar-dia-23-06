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

<a href="<?php echo e(route('pessoas.create')); ?>">Criar Nova Pessoa</a>


<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Matricula</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $pessoas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pessoa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td>
                <a href='<?php echo e(route("pessoas.edit", $pessoa->id)); ?>'><?php echo e($pessoa->name); ?></a>
            </td>
            <td><?php echo e($pessoa->email); ?></td>
            <td><?php echo e($pessoa->telefone); ?></td>
            <td><?php echo e($pessoa->matricula); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/pessoas/index.blade.php ENDPATH**/ ?>