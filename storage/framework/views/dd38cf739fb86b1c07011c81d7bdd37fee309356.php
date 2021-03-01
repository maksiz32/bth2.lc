<?php $__env->startSection('title', 'Подтверждение отправки'); ?>
<?php $__env->startSection('content'); ?><?php $__env->startPush("head"); ?>
<script>
    $(document).ready(function() {
        $('#forclick').on('click', function(){
            $('#first').css('display', 'none');
            $('#second').css('display', 'block');
        });
    });
    function doPlus(id) {
        var inpNum = document.getElementById('inpNum'+id);
        var answer = parseInt(inpNum.value) + 1;
        let max = parseInt(document.getElementById('remain'+id).innerHTML);
        if (answer <= max) {
            inpNum.value = answer;
        } else {
            answer = answer - 1;
            alert('Нельзя выбрать больше остатка на складе '+max+"you: "+answer);
        }
    };
    function doMinus(id) {
        let answerM = parseInt(document.getElementById('inpNum'+id).value) - 1;
        let inpNum = document.getElementById('inpNum'+id);
        if (answerM >= 0) {
            inpNum.value = answerM;
        } 
    }
</script>
<?php $__env->stopPush(); ?>
<article class="container main_page orders">
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
    <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
    <?php echo e($orders->links()); ?>

    <?php endif; ?>
    <form action="<?php echo e(action('OrderController@submitOrder')); ?>" method="post">
        Подтверждение отправки:
            <?php echo e(method_field('PUT')); ?>

            <?php echo e(csrf_field()); ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>IP-адрес</th>
                <th>Дата</th>
                <th>Подразделение</th>
                <th>Имя пользователя</th>
                <th>Техника</th>
                <th>Расходка</th>
                <th>Заказано</th>
                <th>Осталось</th>
                <th>Подтверждение</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <?php echo e(long2ip($order->real_ip)); ?>

                </td>
                <td>
                    <?php echo e($order->created); ?>

                </td>
                <td>
                    <?php echo e($order->firm); ?>

                </td>
                <td>
                    <?php echo e($order->user_name); ?>

                </td>
                <td>
                    <?php echo $order->tech; ?>

                </td>
                <td <?php if($order->count <= 5): ?> <?php echo e(_('class=td-red')); ?><?php endif; ?>>
                    <?php echo e($order->model); ?>

                </td>
                <td>
                    <input type="hidden" value="<?php echo e($order->order_id); ?>" name="ordId[]">
                    <input type="hidden" value="<?php echo e($order->id); ?>" name="remainId[]">
                    <input type="hidden" value="<?php echo e($order->tech_id); ?>" name="techId[]">
                    <input type="text" value="<?php echo e($order->count_m); ?>" id="inpNum<?php echo e($order->id); ?>" name="count[]">
                    <div>
                        <i class="bi bi-dash-square s500 orderMinus" 
                        onclick="doMinus(<?php echo e($order->id); ?>)"></i>
                        <i class="bi bi-plus-square orderPlus s500" 
                        onclick="doPlus(<?php echo e($order->id); ?>)"></i>
                    </div>
                </td>
                <td <?php if($order->count <= 5): ?> <?php echo e(_('class=td-red')); ?><?php endif; ?>>
                    <span id="remain<?php echo e($order->id); ?>"><?php echo e($order->count); ?></span>
                </td>
                <td>
                    <?php if($order->confirmed): ?>
                        <i class="bi bi-check-square" style="color: cornflowerblue"></i>
                    <?php else: ?>
                        <i class="bi bi-x-square" style="color: red"></i>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(!$nobutton): ?>
            <tr class="bg-warning" id="forclick">
                <td class="success" colspan="9" style="text-align: center" id="first">
                    <button type="submit" class="btn btn-info btn-lg">Подтвердить</button>
                </td>
                <td class="success" colspan="9" style="text-align: center; display: none" id="second">
                    Отправляю
                </td>
            </tr>
        </tbody>
        <?php endif; ?>
    </table>
    </form>
    <?php if(RGSPortal::isAdmin(getenv('REMOTE_USER'))): ?>
    <?php echo e($orders->links()); ?>

    <?php endif; ?>
</article>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>