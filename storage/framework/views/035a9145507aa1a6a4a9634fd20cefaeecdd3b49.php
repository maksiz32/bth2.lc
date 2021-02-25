<?php $__env->startSection('title', "Форма для загрузки именинников"); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush("head"); ?>
    <script src="<?php echo e(asset('/js/bs-custom-file-input.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery-ui.min.js')); ?>"></script>
    <link href="<?php echo e(asset('/css/wbn-datepicker.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('/js/wbn-datepicker.js')); ?>"></script>
<script>
    $(document).ready(function () {
    bsCustomFileInput.init()
    })
</script>
<script>
    $(function(){
        $('.wbn-datepicker').datepicker();
    });
</script>
<?php $__env->stopPush(); ?>
<div class="container">	
    <div class="panel panel-primary alert alert-secondary">
        <div class="panel-body">
            <?php if($message = Session::get('success')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(Session::get('success')); ?>

            </div>
            <?php endif; ?>
            <?php if($message = Session::get('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo e(Session::get('error')); ?>

            </div>
            <?php endif; ?>
            <h4>Загрузить готовый Excel-файл:</h4>
            <form style="margin-top: 15px;padding: 20px;" action="<?php echo e(URL::to('importExcel')); ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="import_file" id="customFileLangHTML" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    <label class="custom-file-label" for="import_file" data-browse="Обзор...">Выбрать таблицу</label>
                <?php echo e(csrf_field()); ?>

                </div>
                <br />
                <button class="btn btn-primary">Загрузить документ Excel</button>
            </form>
        </div>
    </div>
    Или <hr>
    <div class="panel panel-primary alert alert-success">
        <h4>Ручной ввод:</h4>
        <form action="<?php echo e(action('InputController@inputOne')); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-7">
                <div class="custom-file" id="photo">
                    <input type="file" class="custom-file-input" name="photoFile">
                    <label class="custom-file-label" for="photoFile" data-browse="Обзор...">Выбрать фотографию:</label>
                </div>
        </div>
        <?php echo e(method_field('PUT')); ?>

            <input type="hidden" name="id" value="<?php echo e(old('id')); ?>">
        <?php echo e(csrf_field()); ?>

    </div>
    <div class="row">
            <div class="form-group col-lg-4">
                <label for="nameF" class="control-label">Фамилия:</label>
                <input id="nameF" type="text" class="form-control" name="nameF" value="<?php echo e(old('nameF')); ?>" required>
            </div>
            <div class="form-group col-lg-4">
                <label for="nameN" class="control-label">Имя:</label>
                <input id="nameN" type="text" class="form-control" name="nameN" value="<?php echo e(old('nameN')); ?>" required>
            </div>
            <div class="form-group col-lg-4">
                <label for="nameOt" class="control-label">Отчество:</label>
                <input id="nameOt" type="text" class="form-control" name="nameOt" value="<?php echo e(old('nameOt')); ?>" required>
            </div>
    </div>
    <div class="row">
            <div class="form-group col-lg-4">
                <label for="dolzh" class="control-label">Должность:</label>
                <input id="dolzh" type="text" class="form-control" name="dolzh" value="<?php echo e(old('dolzh')); ?>" required>
            </div>
            <div class="form-group col-lg-4">
                <label for="work" class="control-label">Подразделение:</label>
                <input id="work" type="text" class="form-control" name="work" value="<?php echo e(old('work')); ?>" required>
            </div>
            <div class="form-group col-lg-4">
                <label for="date" class="control-label">Дата рождения:</label>
                <input id="date" type="date" class="form-control wbn-datepicker" name="date" value="<?php echo e(old('date')); ?>" required>
            </div>
    </div>
    <div class="row">  
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
    </div>
        </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nonstyle', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>