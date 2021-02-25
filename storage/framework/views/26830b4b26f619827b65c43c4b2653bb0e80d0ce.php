<?php $__env->startSection('title', 'Просмотр адресов уведомлений различных ресурсов'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid top-130">
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(Session::get('success')); ?>

        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-12 text-center mt-5">
            <table class="table table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Текущий адрес</th>
                        <th scope="col">Описание/ Принадлежность</th>
                        <th scope="col">Используется для</th>
                        <th scope="col">Последнее изменение</th>
                        <th scope="col">Операции</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th scope="row"><?php echo e($loop->iteration); ?></th>
                        <th scope="row"><?php echo e($email->email); ?></th>
                        <th scope="row"><?php echo e($email->who); ?></th>
                        <th scope="row"><?php echo e($email->setMailNameSource(2)); ?></th>
                        <th scope="row"><?php echo e(date('d-m-Y H:m', strtotime($email->updated_at))); ?></th>
                        <th scope="row">
                            <a class="btn btn-primary" 
                                href="<?php echo e(action('AddrEmailController@edit', ['id' => $email->id])); ?>">
                                Изменить 
                            </a>
                            <a class="btn btn-danger" 
                               href="<?php echo e(action('AddrEmailController@delete', ['id' => $email->id])); ?>" 
                               OnClick="return confirm('Подтвердите удаление элемента')" >
                                Удалить
                            </a>
                        </th>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <hr>
    <?php if(count($errors)>0): ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="col-12 text-center small">
        Добавить адрес почты
    </div>
    <form action="<?php echo e(action('AddrEmailController@saveNew')); ?>" method="post">
    <div class="form-row">
        <?php echo e(csrf_field()); ?>

            <div class="form-group col-lg-5">
                <label for="email" class="control-label small">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group col-lg-6">
                <label for="who" class="control-label small">Чей (пользователь или группа):</label>
                <input type="text" class="form-control" name="who" required>
            </div>
            <div class="form-group col-lg-1 align-self-end">
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
    </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>