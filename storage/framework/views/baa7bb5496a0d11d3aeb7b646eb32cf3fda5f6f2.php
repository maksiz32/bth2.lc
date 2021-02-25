<?php $__env->startSection('title', "Добавление / редактирование Базы Знаний"); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush('head'); ?>
    <script src="<?php echo e(asset('/js/tinymce/tinymce.min.js')); ?>"></script>
    <script>
        tinymce.init({
        selector:'#wikinput',
        branding: false,
        menubar: false,
        plugins: "link, code, lists, charmap, hr, table",
        convert_fonts_to_spans : false,
        extended_valid_elements: 'span[*], p[*]',
        invalid_styles: {
            '*': 'color, font-family, font-size, background-color',
        },
        toolbar: 'undo redo | styleselect | bold italic | ' +
            'blockquote | bullist numlist | table | hr charmap link',
        style_formats: [
            { title: 'Headings', items: [
            { title: 'Heading 1', format: 'h1' },
            { title: 'Heading 2', format: 'h2' },
            { title: 'Heading 3', format: 'h3' },
            { title: 'Heading 4', format: 'h4' },
            { title: 'Heading 5', format: 'h5' },
            { title: 'Heading 6', format: 'h6' }
        ]},
            { title: 'Inline', items: [
            { title: 'Bold', format: 'bold' },
            { title: 'Italic', format: 'italic' },
            { title: 'Underline', format: 'underline' },
            { title: 'Strikethrough', format: 'strikethrough' },
            { title: 'Superscript', format: 'superscript' },
            { title: 'Subscript', format: 'subscript' },
            { title: 'Code', format: 'code' }
        ]},
            { title: 'Blocks', items: [
            { title: 'Paragraph', format: 'p' },
            { title: 'Blockquote', format: 'blockquote' },
            { title: 'Div', format: 'div' },
            { title: 'Pre', format: 'pre' }
        ]}
        ],
        height: 400
    });
    </script>
    <script>
        $(document).ready(function(){
            $('.hideSpeanerWiki').css('display', 'none');
            $('button').css('display', 'block');
            $('button').on('click',function(){
                $(this).css('display','none');
                $('.hideSpeanerWiki').css('display', 'block');
            });
            
        });
    </script>
<?php $__env->stopPush(); ?>
<div class="container top-130">
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(Session::get('success')); ?>

        </div>
    <?php endif; ?>
    <?php if($message = Session::get('danger')): ?>
        <div class="alert alert-warning" role="alert">
            <?php echo e($message); ?>

        </div>
    <?php endif; ?>
    <?php if(count($errors)>0): ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?php echo e(action('WikiController@inputWiki')); ?>" method="post" enctype="multipart/form-data">
    <div class="form-row">
        <?php echo e(csrf_field()); ?>

        <?php if($wiki->id): ?>
        <?php echo e(method_field('PUT')); ?>

            <input type="hidden" name="id" value="<?php echo e(old('id', $wiki->id)); ?>">
        <?php endif; ?>
            <div class="form-group col-12">
                <label for="id_systems" class="control-label">К какому разделу относится:</label>
                <select name="id_systems" required>
                    <option selected disabled>Выбрать раздел:</option>
                    <?php $__currentLoopData = $systems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sys): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option class="small" value="<?php echo e($sys->id); ?>" <?php if($sys->id==$wiki->id_systems): ?> <?php echo e(__('selected')); ?> <?php endif; ?>>
                        <?php echo e($sys->system); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group col-md-12">
                <label for="error" class="control-label">Текст ошибки (описание):</label>
                <input type="text" class="form-control" name="error" value="<?php echo e(old('error', $wiki->error)); ?>" required>
            </div>
            <div class="form-group col-md-12">
                <label for="fix" class="control-label">Описание работ по исправлению:</label>
                <textarea id="wikinput" class="form-control" name="fix"><?php echo e(old('fix', $wiki->fix)); ?></textarea>
            </div>
            <div class="form-group col-md-8">
                <label for="docs" class="control-label">Добавить файлы:</label>
                <input type="file" class="form-control" name="docs[]" multiple>
            </div>
    </div>
        <?php if($wiki->id): ?>
        <button type="submit" class ="btn btn-primary">Изменить</button>
        <div class="hideSpeanerWiki spinner-grow spinner-grow-sm" role="status" aria-hidden="true">
            Идет загрузка, подождите
        </div>
        <?php else: ?>
        <button type="submit" class="btn btn-primary">Добавить</button>
        <div class="hideSpeanerWiki spinner-grow spinner-grow-sm" role="status" aria-hidden="true">
            Идет загрузка, подождите
        </div>
        <?php endif; ?>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>