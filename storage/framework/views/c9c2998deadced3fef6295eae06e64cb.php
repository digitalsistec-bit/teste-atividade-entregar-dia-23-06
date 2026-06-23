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

<a href="<?php echo e(route('livros.create')); ?>">Cadastrar Novo Livro</a>

<table>
    <thead>
        <tr>
            <td>id</td>
            <td>titulo</td>
            <td>autor</td>
            <td>isbn</td>
            <td>data_publicacao</td>
            <td>created_at</td>
            <td>updated_at</td>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $livros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $livro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($livro->id); ?></td>
                <td>
                    <a href="<?php echo e(route('livros.edit', ['id' => $livro->id])); ?>"><?php echo e($livro->titulo); ?></a>
                </td>
                <td><?php echo e($livro->autor->nome); ?></td>
                <td><?php echo e($livro->isbn); ?></td>
                <td><?php echo e($livro->data_publicacao); ?></td>
                <td><?php echo e($livro->created_at); ?></td>
                <td><?php echo e($livro->updated_at); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/livros/index.blade.php ENDPATH**/ ?>