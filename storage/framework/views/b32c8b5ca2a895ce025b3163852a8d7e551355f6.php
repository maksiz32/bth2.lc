<?php $h = ($tech->id) ? "Редактирование техники " . $tech->tech : "Добавление новой техники" ?>
<?php $__env->startSection('title', $h); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush("head"); ?>
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
<?php $__env->stopPush(); ?>
<article class="container main_page">
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
            <form action="<?php echo e(action('TechController@store')); ?>" method="POST" enctype="multipart/form-data">
                <?php if($tech->id): ?>
                            <?php echo e(method_field('PUT')); ?>

                        <input type="hidden" name="id" value="<?php echo e(old('id', $tech->id)); ?>">
                <?php endif; ?>
                            <?php echo e(csrf_field()); ?>

                <div class="row">
                    <div class="form-group col-lg-12">
                <?php if($tech->id): ?>
                    <img src="<?php echo e(asset('/img/tech/'.$tech->photo)); ?>" class="img-thumbnail h110">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="sw1" name="sw1" onchange='addName("sw1", "photo1");'>
                            <label class="custom-control-label" for="sw1">Будем менять картинку?</label><br />
                            <div style="display:none" class="form-row" id="photo1">
                                <label for="photo1">Выберите изображение устройства:</label>
                                <input type="file" class="form-control-file" name="photo1" value="">
                            </div>
                        </div>
                <?php else: ?>
                        <label for="photo1">Выберите изображение устройства:</label>
                        <input type="file" class="form-control-file" name="photo1" required>
                <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="tech" class="control-label">Модель устройства:</label>
                        <input type="text" class="form-control" name="tech" value="<?php echo e(old('tech', $tech->tech)); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="model" class="control-label">Модель картриджа:</label>
                        <input type="text" class="form-control" name="model" value="<?php echo e(old('model', $tech->model)); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="category_id" class="col-md-4 control-label">Категория устройства:</label>
                        <select name="category_id" required>
                            <option value="1"<?php if($tech->category_id == '1') echo " selected"?>>Принтеры</option>
                            <option value="2"<?php if($tech->category_id == '2') echo " selected"?>>Копиры</option>
                            <option value="3"<?php if($tech->category_id == '3') echo " selected"?>>МФУ</option>
                            <option value="4"<?php if($tech->category_id == '4') echo " selected"?>>Сканеры</option>
                        </select>
                    </div>
                </div>
                <div class="row">  
                    <button type="submit" class="btn btn-primary">Сохранить</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
                </div>
            </form>
</article>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>