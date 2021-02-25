<?php $__env->startSection('title', "Редактирование " . $edit->nameF); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush("head"); ?>
    <script src="<?php echo e(asset('/js/jquery-ui.min.js')); ?>"></script>
    <link href="<?php echo e(asset('/css/wbn-datepicker.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('/js/wbn-datepicker.js')); ?>"></script>
<script>
      function addName(cb, mat) {
    cb = document.getElementById(cb);
	mat = document.getElementById(mat);
    if (cb.checked) {
		mat.setAttribute('style', 'display:block');
	} else {
		mat.setAttribute('style', 'display:none');
	}
  }
</script>
<script>
    $(function(){
        $('.wbn-datepicker').datepicker();
    });
</script>
<?php $__env->stopPush(); ?>
<div class="container">
        <form action="<?php echo e(action('InputController@saveOne')); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
    <figure class="figure col-lg-5">
        <?php if($edit->photo !== null): ?>
        <img src="<?php echo e(asset($edit->photo)); ?>" class="figure-img img-fluid rounded img-thumbnail" alt='Фотография <?php echo e($edit->nameF." ".$edit->nameN." ".$edit->nameOt); ?>'>
        <?php else: ?>
        <img src="<?php echo e(asset('/img/nophoto.png')); ?>" class="figure-img img-fluid rounded img-thumbnail" alt='Фотографии еще нет'>
        <?php endif; ?>
        <figcaption class="figure-caption text-left">Фото <?php echo e($edit->nameF." ".$edit->nameN." ".$edit->nameOt); ?></figcaption>
    </figure>
        <div class="col-lg-7">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="sw1" name="sw1" onchange='addName("sw1", "photo");'>
                <label class="custom-control-label" for="sw1">Будем менять картинку?</label><br />
                <div style="display:none" class="form-row" id="photo">
                    <label for="photo">Выберите файл:</label>
                    <input type="file" class="form-control-file" name="photo" accept="image/*">
                </div>
        </div>
        </div>
    </div>
        <?php echo e(method_field('PUT')); ?>

            <input type="hidden" name="id" value="<?php echo e(old('id', $edit->id)); ?>">
        <?php echo e(csrf_field()); ?>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="nameF" class="control-label">Фамилия:</label>
                <input id="nameF" type="text" class="form-control" name="nameF" value="<?php echo e(old('nameF', $edit->nameF)); ?>" required>
            </div>
            <div class="form-group col-md-4">
                <label for="nameN" class="control-label">Имя:</label>
                <input id="nameN" type="text" class="form-control" name="nameN" value="<?php echo e(old('nameN', $edit->nameN)); ?>" required>
            </div>
            <div class="form-group col-md-4">
                <label for="nameOt" class="control-label">Отчество:</label>
                <input id="nameOt" type="text" class="form-control" name="nameOt" value="<?php echo e(old('nameOt', $edit->nameOt)); ?>" required>
            </div>
        </div>
            <div class="form-group col">
                <label for="dolzh" class="control-label">Должность:</label>
                <input id="dolzh" type="text" class="form-control" name="dolzh" value="<?php echo e(old('dolzh', $edit->dolzh)); ?>" required>
            </div>
            <div class="form-group col">
                <label for="work" class="control-label">Подразделение:</label>
                <input id="work" type="text" class="form-control" name="work" value="<?php echo e(old('work', $edit->work)); ?>" required>
            </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="date" class="control-label">Дата рождения:</label>
                <input id="date" type="date" class="form-control wbn-datepicker" name="date" value="<?php echo e(old('date', $edit->date)); ?>" required>
            </div>
            <div class="form-group col-md-3">
                <label for="phone" class="control-label">Номер сотового телефона:</label>
                <input type="text" class="form-control" name="phone" value="<?php echo e(old('phone', $edit->phone)); ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
        </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.nonstyle', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>