<?php $__env->startSection('title', "Все подразделения Филиала"); ?>
<?php $__env->startSection('content'); ?>
<article class="container-fluid main_page top-110">
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
    <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
    <div class="row mar15 alert alert-danger" role="alert">
        <div class="col-6 text-center">
            <a href="/firms/create" class="btn btn-primary">
                Создать подразделение
            </a>
        </div>
        <?php if(Route::currentRouteAction() == 'App\Http\Controllers\FirmController@index'): ?>
        <div class="col-6 text-center">
            <a href="/firms/no-all" class="btn btn-danger">
                Убрать закрытые
            </a>
        </div>
        <?php else: ?>
        <div class="col-6 text-center">
            <a href="/firms" class="btn btn-primary">
                Отобразить все
            </a>
        </div>
        <?php endif; ?>
    </div>
    <?php else: ?>
    <div class="row mar15 alert alert-danger" role="alert">
        <?php if(Route::currentRouteAction() == 'App\Http\Controllers\FirmController@index'): ?>
        <div class="col-12 text-center">
            <a href="/firms/all" class="btn btn-primary">
                Отобразить все
            </a>
        </div>
        <?php else: ?>
        <div class="col-12 text-center">
            <a href="/firms" class="btn btn-danger">
                Убрать закрытые
            </a>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <table class="table table-striped">
        <thead class="thead-dark text-center">
            <tr>
                <?php if($stat): ?>
                <th scope="col">Статус</th>
                <?php endif; ?>
                <th scope="col">Название</th>
                <th scope="col">ФИО НСО</th>
                <th scope="col">Код СКК</th>
                <th scope="col">Адрес</th>
                <th scope="col">Телефон</th>
                <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
                <th scope="col">Начальный ip-адрес</th>
                <th scope="col">Конечный ip-адрес</th>
                <th scope="col">Имя латиница</th>
                <th scope="col">Операции</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            
            <?php $__currentLoopData = $firms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $firm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr <?php if(!$firm->isblock) {?>
                class="text-danger"
                <?php } ?>>
                <?php if($stat): ?>
                <th scope="row">
                <?php if(!$firm->isblock): ?>
                ЗАКРЫТО
                <?php endif; ?>
                </th>
                <?php endif; ?>
                <th scope="row"><?php echo e($firm->name); ?></th>
                <th><?php echo e($firm->famNSO." ".$fName = $firm->nameNSO." ".$fOtch = $firm->otchNSO); ?></th>
                <?php /*
                <?php $initNSO = mb_substr($fName, 0, 1).".".mb_substr($fOtch, 0, 1).".";?>
                <th>{{ $initNSO }}</th>
                */?>
                <th><?php echo e($firm->skk); ?></th>
                <th><address><?php echo e($firm->addr); ?></address></th>
                <th><?php echo e($firm->tel); ?></th>
                <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
                <th class="lead"><?php echo e(long2ip($firm->ipStart)); ?></th>
                <th class="lead"><?php echo e(long2ip($firm->ipEnd)); ?></th>
                <th class="lead"><?php echo e($firm->nameEng); ?></th>
                <th>
                    <p><a href="<?php echo e(action('FirmController@create', ['id' => $firm->id])); ?>" class="btn btn-primary">
                        Редактировать
                        </a></p>
                        <form action="<?php echo e(action('FirmController@destroy', ['id' => $firm->id])); ?>" method="post">
                            <?php echo e(method_field('delete')); ?>

                            <?php echo e(csrf_field()); ?>

                            <button class="btn btn-danger" 
                                    OnClick="return confirm('Подтвердите удаление элемента')" 
                                    type="submit">Удалить</button>
                        </form>
                </th>
                <?php endif; ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            </tbody>
    </table>
      
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>