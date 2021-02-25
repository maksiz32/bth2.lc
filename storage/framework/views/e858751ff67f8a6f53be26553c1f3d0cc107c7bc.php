<?php if($mounth): ?>
<?php
$p="Все сотрудники, родившиеся в месяце :: " . $mounth;
?>
<?php else: ?>
<?php
$p="Все сотрудники";
?>
<?php endif; ?>
<?php $__env->startSection('title', $p); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush("headup"); ?>
    <link href="<?php echo e(asset('/css/newfile.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>
<?php $__env->startPush("head"); ?>
<?php
function rusMounth($mounth=null) {
    $rMth = [
        "1" => "Январь",
        "2" => "Февраль",
        "3" => "Март",
        "4" => "Апрель",
        "5" => "Май",
        "6" => "Июнь",
        "7" => "Июль",
        "8" => "Август",
        "9" => "Сентябрь",
        "10" => "Октябрь",
        "11" => "Ноябрь",
        "12" => "Декабрь",
    ];
    echo $rMth[$mounth];
}

function mounthP($data=null) {
    $data = explode("-", $data);
    $mounth = $data[1];
    $rMth = [
        "01" => " января ",
        "02" => " февраля ",
        "03" => " марта ",
        "04" => " апреля ",
        "05" => " мая ",
        "06" => " июня ",
        "07" => " июля ",
        "08" => " августа ",
        "09" => " сентября ",
        "10" => " октября ",
        "11" => " ноября ",
        "12" => " декабря ",
    ];
    (isset($data[2]))?$result = $data[0].$rMth[$mounth].$data[2]:$result = $data[0].$rMth[$mounth];
    return $result;
}
?>
<script type="text/javascript">
    function addName(cb, cat) {
        cb = document.getElementById(cb);
        cat = document.getElementById(cat);
	cb.setAttribute('style', 'display:none;');
	cat.setAttribute('style', 'display:block;');
	}
</script>
<?php $__env->stopPush(); ?>
<div class="container-fluid">
    <div class="row top-110 text-center">
        <div class="alert alert-info col-md-4" role="alert">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl">Выбрать месяц</button>
            <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="row">
                            <?php for($i=1; $i<13; $i++): ?>
                            <div class="col-3 mar15">
                                <a class="btn btn-primary" role="button" href="<?php echo e(action('AllController', ['mounth' => $i])); ?>">
                <?php rusMounth($i)?>
                                </a>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
            <a class="btn btn-primary" role="button" href="/all">
                Отобразить всех
            </a>
        </div>
        <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
        <div class="col-md-4 alert alert-secondary" role="alert">
            Текущий адрес рассылки: 
            <?php if(isset($mail)): ?><?php echo e($mail->email); ?>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn btn-primary" role="button" href="/email">
                Изменить адрес
            </a>
            <?php else: ?>
            Адрес рассылки поздравлений не установлен
            <a class="btn btn-primary" role="button" href="/email">
            Добавить адрес
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="col-md-4 alert alert-dark" role="alert">
            <form action="<?php echo e(action('InputController@search')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <div class="form-row">
                    <div class="col">
                        <label for="column">Поиск по:</label>
                        <select name="column" class="form-control" id="column">
                            <option value="nameF">Фамилия</option>
                            <option value="dolzh">Должность</option>
                            <option value="work">Подразделение</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="textSearch">Строка поиска</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">?</div>
                            </div>
                            <input type="text" class="form-control" name="textSearch" id="textSearch">
                        </div>
                    </div>
                    <div class="col">
                        <button style="margin-top: 15px;" type="submit" class="btn btn-primary mb-2">Поиск</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
<?php if($mounth): ?>
    <div class="col text-center alert alert-success" role="alert">
    <?= rusMounth($mounth);?>
    </div>
<?php endif; ?>
    </div>
<div class="row">
    <div class="col-lg-12">
        <?php if($message = Session::get('status')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(Session::get('status')); ?>

            </div>
            <?php endif; ?>
            <?php if($message = Session::get('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo e(Session::get('error')); ?>

            </div>
            <?php endif; ?>
    <?php echo e($notes->links()); ?>

    <table class="table table-striped table-bordered">
        <caption>Список именинников</caption>
        <thead class="thead-dark">
            <tr>
                <th scope="col">Фотография</th>
                <th scope="col">Фамилия</th>
                <th scope="col">Имя</th>
                <th scope="col">Отчество</th>
                <th scope="col">Должность</th>
                <th scope="col">Компания</th>
                <th scope="col">Дата рождения</th>
                <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
                <th scope="col">Действие</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
    <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noteall): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th>
                    <?php if($noteall->photo !== null): ?>
                    <img class="img-thumbnail h90" src="<?php echo e(asset($noteall->photo)); ?>">
                    <?php else: ?>
                    <img src="<?php echo e(asset('/img/nophoto.png')); ?>" class="figure-img img-fluid rounded img-thumbnail h90" alt='Фотографии нет'>
                    <?php endif; ?>
                </th>
                <th><?php echo e($noteall->nameF); ?></th>
                <th><?php echo e($noteall->nameN); ?></th>
                <th><?php echo e($noteall->nameOt); ?></th>
                <th class="word-b"><?php echo e($noteall->dolzh); ?></th>
                <th class="word-b"><?php echo e($noteall->work); ?></th>
                <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
                <th><?php echo e(mounthP(date('d-m-Y', strtotime($noteall->date)))); ?></th>
                <?php else: ?>
                <th><?php echo e(mounthP(date('d-m', strtotime($noteall->date)))); ?></th>
                <?php endif; ?>
                <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
                <th>
                    <p><a href="<?php echo e(action('InputController@goPDF', ['id' => $noteall->id])); ?>" class="btn btn-primary">
                        Просмотреть
                        </a></p>
                    <p><a href="<?php echo e(action('InputController@editOne', ['id' => $noteall->id])); ?>" class="btn btn-primary">
                        Редактировать
                        </a></p>
                    <div class="spinner-border text-success" id="sp<?php echo e($noteall->id); ?>" style="display:none;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div><p><a href="<?php echo e(action('InputController@sendmail', ['id' => $noteall->id])); ?>" id="s<?php echo e($noteall->id); ?>" onclick='addName("s<?php echo e($noteall->id); ?>","sp<?php echo e($noteall->id); ?>")' class="btn btn-success">
                            <span class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true">
                            </span>
                        Отправить
                        </a></p>
                        <p><a href="<?php echo e(action('InputController@delOne', ['id' => $noteall->id])); ?>" 
                              OnClick="return confirm('Подтвердите удаление элемента')" class="btn btn-danger">
                        Удалить
                        </a></p>
                </th>
                <?php endif; ?>
            </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($notes->links()); ?>

    
</div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>