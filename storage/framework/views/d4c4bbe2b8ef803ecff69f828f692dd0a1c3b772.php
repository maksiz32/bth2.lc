<?php $__env->startSection('title', 'Вся техника'); ?>
<?php $__env->startSection('content'); ?>
<article class="container main_page">
    <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
    <div class="row alert alert-danger" role="alert">
        <div class="col-12 text-center">
            <a href="/tech/create" class="btn btn-primary">
                Добавить новое оборудование
            </a>
        </div>
    </div>
    <?php endif; ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Фото</th>
                <th>Модель</th>
                <th>Картридж</th>
                <th>Категория</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $teches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tech): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <img src="<?php echo e(asset('img/tech/'.$tech->photo)); ?>" class="img-thumbnail h110" />
                </td>
                <td>
                    <?php echo e($tech->tech); ?>

                </td>
                <td>
                    <?php echo $tech->model; ?>

                </td>
                <td>
                    <?php echo e($tech->category); ?>

                </td>
                <td>
                <a href="<?php echo e(action('TechController@create', ['id' => $tech->id])); ?>" class="btn btn-primary btn-block">
                    Изменить
                </a>
                <a href="<?php echo e(action('TechController@destroy', ['id' => $tech->id])); ?>" 
                   OnClick="return confirm('Подтвердите удаление элемента')" 
                   class="btn btn-danger btn-block">
                    Удалить
                </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</article>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>