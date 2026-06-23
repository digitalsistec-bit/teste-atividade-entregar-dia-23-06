<?php $__env->startSection('content'); ?>
<div class="section">
    <div class="row">
        <div class="col s12 m10 l8 offset-m1 offset-l2">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title">Bem-vindo à Biblioteca</span>
                    <p>Este app agora usa Material Design via Materialize, sem depender de Node ou build local.</p>
                </div>
                <div class="card-action">
                    <p><a href="<?php echo e(route('bibliotecas.index')); ?>">Ver Bibliotecas</a></p>
                    <p><a href="<?php echo e(route('users.index')); ?>">Ver Usuários</a></p>
                    <p><a href="<?php echo e(route('pessoas.index')); ?>">Ver Pessoas</a></p>
                    <p><a href="<?php echo e(route('autores.index')); ?>">Ver Autores</a></p>
                    <p><a href="<?php echo e(route('livros.index')); ?>">Ver Livros</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/welcome.blade.php ENDPATH**/ ?>