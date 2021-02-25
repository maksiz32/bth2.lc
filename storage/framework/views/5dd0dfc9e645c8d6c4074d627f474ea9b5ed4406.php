<?php $__env->startSection('title', "Оформление заказа картриджей и расходных материалов"); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush("head"); ?>
<script src="<?php echo e(asset('/js/bs-custom-file-input.min.js')); ?>"></script>
<script type="text/javascript">
    function addName(cb, cat, mat, tec) {
        cb = document.getElementById(cb);
        cat = document.getElementById(cat);
	mat = document.getElementById(mat);
        tec = document.getElementById(tec);
    if (cb.checked) {
	cat.setAttribute('name', 'count_m[]');
	mat.setAttribute('style', 'visibility:visible');
	cat.setAttribute("min", "1");
        tec.setAttribute('name', 'tech[]');
    } else {
	cat.removeAttribute('name');
	mat.setAttribute('style', 'visibility:hidden');
	cat.setAttribute("min", "0");
        tec.removeAttribute('name');
	}
  }
</script>
<link href="<?php echo e(asset('/css/lightbox.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('/js/lightbox.min.js')); ?>"></script>
<script>
    $(document).ready(function () {
    bsCustomFileInput.init();
    });
</script>
<script>
    $(document).ready(function() {
        $('#forclick').on('click', function(){
            $('#first').css('display', 'none');
            $('#second').css('display', 'block');
        });
    });
</script>
<?php $__env->stopPush(); ?>
<article class="container main_page">
    <?php $real_ip = ip2long($ip); ?>
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(Session::get('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <?php if($message = Session::get('danger')): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo e($message); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <?php if(count($errors)>0): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(action('OrderController@store')); ?>" method="post">
        <div class="row">
            <?php echo e(method_field('PUT')); ?>

            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="real_ip" value="<?php echo e(old('real_ip', $ip)); ?>">
            <input type="hidden" name="created" value="<?php echo e(date('Y-m-d H:i:s')); ?>">
            <input type="hidden" name="firm" value="<?php echo e(old('firm', isset($firm->name) ? $firm->name : 'Test')); ?>">
            <input type="hidden" name="userRealName" value="<?php echo e($userRealName); ?>">
    
        </div>
        <div class="accordion" id="accordionOne">
            <div class="card" id="order">
                <div class="card-header text-center alert alert-success" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-0">
                                <button class="btn btn-link text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Принтеры
                                </button>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
<?php $__currentLoopData = $picsP; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-3">
                            <img src="<?php echo e(asset('/img/tech/'.$pic->photo)); ?>" class="img-thumbnail h110" />
                        </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>			
                    </div>
                </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionOne">
                <div class="card-body">
                    <table class="table table-striped">
                        <colgroup>
                            <col width="150">
                            <col width="200">
                            <col width="220">
                            <col width="170">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Выбрать</th>
                                <th>Фото</th>
                                <th>Модель</th>
                                <th>Количество</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $__currentLoopData = $prints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $print): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="pr<?php echo e($loop->iteration); ?>" name="model[]" onchange='addName("pr<?php echo e($loop->iteration); ?>", "inpr<?php echo e($loop->iteration); ?>", "hidepr<?php echo e($loop->iteration); ?>", "tecpr<?php echo e($loop->iteration); ?>");' value="<?php echo e(old('model', $print->model)); ?>">
                                        <label class="custom-control-label" for="pr<?php echo e($loop->iteration); ?>">Выбрать</label>
                                    </div>
                                </td>
                                <td class="listing-inquiry-status">
                                    <input type="hidden" id="tecpr<?php echo e($loop->iteration); ?>" value="<?php echo e(old('tech', $print->tech)); ?>">
                                    <a href="<?php echo e(asset('img/tech/'.$print->photo)); ?>" data-lightbox="1150" data-title="<?php echo e($print->tech); ?>" alt="<?php echo e($print->tech); ?>" title="<?php echo e($print->tech); ?>">
                                        <img src="<?php echo e(asset('img/tech/'.$print->photo)); ?>" class="img-thumbnail h110" />
                                    </a>
                                </td>
                                <td>
                                    <div class="flex-child-grow">
                                    <h6 class="dashboard-table-text"><?php echo e($print->tech); ?></h6>
                                        <span class="dashboard-table-timestamp text-muted">Картридж <?php echo e($print->model); ?></span>
                                    </div>
                                </td>
                                <td id="hidepr<?php echo e($loop->iteration); ?>" style="visibility:hidden">
                                    <h6 class="text-center">Количество (шт.)</h6>
                                    <div class="input-group input-number-group">
                                        <div class="input-group-button">
                                            <button type="button" class="btn btn-info input-number-decrement">-</button>
                                        </div>
                                        <input class="input-number text-center" type="number" id="inpr<?php echo e($loop->iteration); ?>" value="0" min="0" max="10">
                                        <div class="input-group-button">
                                            <button type="button" class="btn btn-info input-number-increment">+</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
        <div class="accordion" id="accordionTwo">
            <div class="card" id="order">
                <div class="card-header text-center alert alert-info" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-0">
                                <button class="btn btn-link text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    Копиры
                                </button>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
<?php $__currentLoopData = $picsC; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-3">
                            <img src="<?php echo e(asset('/img/tech/'.$pic->photo)); ?>" class="img-thumbnail h110" />
                        </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>			
                    </div>
                </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionTwo">
                <div class="card-body">
                    <table class="table table-striped">
                        <colgroup>
                            <col width="150">
                            <col width="200">
                            <col width="220">
                            <col width="170">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Выбрать</th>
                                <th>Фото</th>
                                <th>Модель</th>
                                <th>Количество</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $__currentLoopData = $copyrs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $print): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="cop<?php echo e($loop->iteration); ?>" name="model[]" onchange='addName("cop<?php echo e($loop->iteration); ?>", "incop<?php echo e($loop->iteration); ?>", "hidecop<?php echo e($loop->iteration); ?>", "teccop<?php echo e($loop->iteration); ?>");' value="<?php echo e(old('model', $print->model)); ?>">
                                        <label class="custom-control-label" for="cop<?php echo e($loop->iteration); ?>">Выбрать</label>
                                    </div>
                                </td>
                                <td class="listing-inquiry-status">
                                    <input type="hidden" id="teccop<?php echo e($loop->iteration); ?>" value="<?php echo e(old('tech', $print->tech)); ?>">
                                    <a href="<?php echo e(asset('img/tech/'.$print->photo)); ?>" data-lightbox="1150" data-title="<?php echo e($print->tech); ?>" alt="<?php echo e($print->tech); ?>" title="<?php echo e($print->tech); ?>">
                                        <img src="<?php echo e(asset('img/tech/'.$print->photo)); ?>" class="img-thumbnail h110" />
                                    </a>
                                </td>
                                <td>
                                    <div class="flex-child-grow">
                                    <h6 class="dashboard-table-text"><?php echo e($print->tech); ?></h6>
                                        <span class="dashboard-table-timestamp text-muted">Картридж <?php echo e($print->model); ?></span>
                                    </div>
                                </td>
                                <td id="hidecop<?php echo e($loop->iteration); ?>" style="visibility:hidden">
                                    <h6 class="text-center">Количество (шт.)</h6>
                                    <div class="input-group input-number-group">
                                        <div class="input-group-button">
                                            <button type="button" class="btn btn-info input-number-decrement">-</button>
                                        </div>
                                        <input class="input-number text-center" type="number" id="incop<?php echo e($loop->iteration); ?>" value="0" min="0" max="10">
                                        <div class="input-group-button">
                                            <button type="button" class="btn btn-info input-number-increment">+</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
        <div class="accordion" id="accordionThree">
            <div class="card" id="order">
                <div class="card-header text-center alert alert-primary" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-0">
                                <button class="btn btn-link text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    МФУ
                                </button>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
<?php $__currentLoopData = $picsM; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-3">
                            <img src="<?php echo e(asset('/img/tech/'.$pic->photo)); ?>" class="img-thumbnail h110" />
                        </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>			
                    </div>
                </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionThree">
                <div class="card-body">
                    <table class="table table-striped">
                        <colgroup>
                            <col width="150">
                            <col width="200">
                            <col width="220">
                            <col width="170">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Выбрать</th>
                                <th>Фото</th>
                                <th>Модель</th>
                                <th>Количество</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $__currentLoopData = $mfus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $print): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="mf<?php echo e($loop->iteration); ?>" name="model[]" onchange='addName("mf<?php echo e($loop->iteration); ?>", "inmf<?php echo e($loop->iteration); ?>", "hidemf<?php echo e($loop->iteration); ?>", "tecmf<?php echo e($loop->iteration); ?>");' value="<?php echo e(old('model', $print->model)); ?>">
                                        <label class="custom-control-label" for="mf<?php echo e($loop->iteration); ?>">Выбрать</label>
                                    </div>
                                </td>
                                <td class="listing-inquiry-status">
                                    <input type="hidden" id="tecmf<?php echo e($loop->iteration); ?>" value="<?php echo e(old('tech', $print->tech)); ?>">
                                    <a href="<?php echo e(asset('img/tech/'.$print->photo)); ?>" data-lightbox="1150" data-title="<?php echo e($print->tech); ?>" alt="<?php echo e($print->tech); ?>" title="<?php echo e($print->tech); ?>">
                                        <img src="<?php echo e(asset('img/tech/'.$print->photo)); ?>" class="img-thumbnail h110" />
                                    </a>
                                </td>
                                <td>
                                    <div class="flex-child-grow">
                                    <h6 class="dashboard-table-text"><?php echo e($print->tech); ?></h6>
                                        <span class="dashboard-table-timestamp text-muted">Картридж <?php echo e($print->model); ?></span>
                                    </div>
                                </td>
                                <td id="hidemf<?php echo e($loop->iteration); ?>" style="visibility:hidden">
                                    <h6 class="text-center">Количество (шт.)</h6>
                                    <div class="input-group input-number-group">
                                        <div class="input-group-button">
                                            <button type="button" class="btn btn-info input-number-decrement">-</button>
                                        </div>
                                        <input class="input-number text-center" type="number" id="inmf<?php echo e($loop->iteration); ?>" value="0" min="0" max="10">
                                        <div class="input-group-button">
                                            <button type="button" class="btn btn-info input-number-increment">+</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
        
        <br/>
        <div class="row">
            <div class="col-12 text-center">
                <label lass="control-label" for="others">
                    Здесь можно дописать то, что не вошло в форму заказа (напр. сетевые фильтры, мыши, клавиатуры, телефоны и прочее):
                </label>
                    <textarea rows="2" class="form-control" maxlength="2000" name="others"></textarea>
                    <p><small>Не более 2000 символов.</small></p>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-12 text-center">
                    <div class="spinner-border text-danger" id="second" 
                         style="display: none" role="status">
                        <span class="sr-only">Loading...</span>
                        <span class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true">
                        </span>
                    </div>
                <div id="first">
                    <button type="submit" class="btn btn-primary" 
                            id="forclick">Сохранить</button>
                <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 text-right">
            <span class="text-muted">
                <?php echo e(isset($firm->name) ? $firm->name : 'Test'); ?> - <?php echo e($ip); ?>

                <br/> <?php echo e($userRealName); ?>

            </span>
        </div>
    </div>
</article>
<script src="<?php echo e(asset('/js/input-number-group.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>