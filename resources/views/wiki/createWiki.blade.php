@extends('layouts.app')
@section('title', "Добавление / редактирование Базы Знаний")
@section('content')
@push('head')
    <script src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
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
@endpush
<div class="container top-130">
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    @if ($message = Session::get('danger'))
        <div class="alert alert-warning" role="alert">
            {{$message}}
        </div>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ action('WikiController@inputWiki') }}" method="post" enctype="multipart/form-data">
    <div class="form-row">
        {{ csrf_field() }}
        @if ($wiki->id)
        {{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{ old('id', $wiki->id) }}">
        @endif
            <div class="form-group col-12">
                <label for="id_systems" class="control-label">К какому разделу относится:</label>
                <select name="id_systems" required>
                    <option selected disabled>Выбрать раздел:</option>
                    @foreach($systems as $sys)
                    <option class="small" value="{{$sys->id}}" @if($sys->id==$wiki->id_systems) {{__('selected')}} @endif>
                        {{$sys->system}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-12">
                <label for="error" class="control-label">Текст ошибки (описание):</label>
                <input type="text" class="form-control" name="error" value="{{ old('error', $wiki->error) }}" required>
            </div>
            <div class="form-group col-md-12">
                <label for="fix" class="control-label">Описание работ по исправлению:</label>
                <textarea id="wikinput" class="form-control" name="fix">{{old('fix', $wiki->fix)}}</textarea>
            </div>
            <div class="form-group col-md-8">
                <label for="docs" class="control-label">Добавить файлы:</label>
                <input type="file" class="form-control" name="docs[]" multiple>
            </div>
    </div>
        @if ($wiki->id)
        <button type="submit" class ="btn btn-primary">Изменить</button>
        <div class="hideSpeanerWiki spinner-grow spinner-grow-sm" role="status" aria-hidden="true">
            Идет загрузка, подождите
        </div>
        @else
        <button type="submit" class="btn btn-primary">Добавить</button>
        <div class="hideSpeanerWiki spinner-grow spinner-grow-sm" role="status" aria-hidden="true">
            Идет загрузка, подождите
        </div>
        @endif
    </form>
</div>
@endsection
