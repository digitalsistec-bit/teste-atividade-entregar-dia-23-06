<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <link href="<?php echo e(asset('css/materialize.min.css')); ?>" rel="stylesheet">
    </head>
    <body class="">
        <header>
            <nav>
                <div class="nav-wrapper container">
                    <a href="/" class="brand-logo"><?php echo e(config('app.name', 'App')); ?></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <?php if(Route::has('login')): ?>
                            <?php if(auth()->guard()->check()): ?>
                                <li><a href="<?php echo e(url('/dashboard')); ?>">Dashboard</a></li>
                            <?php else: ?>
                                <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                                <?php if(Route::has('register')): ?>
                                    <li><a href="<?php echo e(route('register')); ?>">Register</a></li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </header>

        <main class="container" style="margin-top:2rem">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <footer class="page-footer">
            <div class="container">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?></div>
        </footer>

        
        <script src="<?php echo e(asset('js/materialize.min.js')); ?>"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof M !== 'undefined' && M.AutoInit) {
                    M.AutoInit();
                }
            });
        </script>
    </body>
</html>
<?php /**PATH /app/resources/views/layouts/app.blade.php ENDPATH**/ ?>