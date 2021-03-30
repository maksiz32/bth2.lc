<?php $__env->startSection('title', "База знаний ИТ"); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush("head"); ?>
<script>
    $(document).ready(function() {
        $('select').on('change', function () {
            $('.sel-text').css('display', 'none');
            var $idSys = $('select :selected').val();
            $("."+$idSys).css('display', 'block');
        })
    });
</script>
<script> 
  $(document).ready(function() { 
  $('#searchBtn').prop("disabled",true); 
  $(document).on('input', 'input[type="text"]', function () { 
  var $item = $(this).val().length; 
  if($item > 2) { 
  $('#searchBtn').removeAttr("disabled"); 
  } else { 
  $('#searchBtn').prop("disabled",true); 
  }; 
  }); 
  }); 
  </script>
<?php $__env->stopPush(); ?>
<article class="container-fluid main_page top-130">
            <div class="breadcr text-mono" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/wiki">База знаний</a></li>
                    <li class="breadcrumb-item">Результаты поиска</li>
                </ol>
            </div>
    <?php if($search): ?>
    <?php $__currentLoopData = $search; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p>
    <a href="<?php echo e(action('WikiController@wikiOne',['id' => $ser->id])); ?>">
    <?php echo e($loop->iteration.": ".$ser->error." (Раздел: \"".$ser->system."\")"); ?>

    </a>
    </p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
    <div class="form-group row">
        <div class="col-11 text-center align-content-center mt-3">
            <label for="font-size">Выбрать раздел:</label>
            <select class="form-control">
                <option selected disabled>Выбрать раздел:</option>
                <?php $__currentLoopData = $mainSystems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sys): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($sys->id); ?>"><?php echo e($sys->system); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <br>
        <ul>
        <?php $__currentLoopData = $systems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sys): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="sel-text col-12 ml-3 mt-3 <?php echo e($sys->id_sys); ?>" style="display: none">
            <li>
            <a href="<?php echo e(action('WikiController@wikiOne',['id' => $sys->id])); ?>">
                <?php echo e($sys->error); ?>

            </a>
            </li>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php if(count($errors)>0): ?>
    <div class="alert alert-danger" role="alert">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>
        <div class="col-md-5">
            <form action="<?php echo e(action('WikiController@search')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                    <div class="input-group">
                        <div class="ml-3 mr-3 mt-1">
                            Поиск:
                        </div>
                        <div class="input-group-prepend">
                            <div class="input-group-text">?</div>
                        </div>
                        <input type="text" placeholder="Три символа и больше" class="form-control" name="textSearch" id="textSearch" required="">
                        <button type="submit" class="btn btn-primary ml-1" id="searchBtn">Найти</button>
                    </div>
            </form>
        </div>
    <?php endif; ?>
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>