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

<a href="<?php echo e(route('users.create')); ?>">Criar Novo Usuário</a>

<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><a href="<?php echo e(route('users.show', ['user' => $user->id])); ?>"><?php echo e($user->name); ?></a></td>
                <td><?php echo e($user->email); ?></td>
                <td><?php echo e($user->role); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/users/index.blade.php ENDPATH**/ ?>