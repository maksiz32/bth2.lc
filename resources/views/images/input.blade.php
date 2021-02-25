@extends('layouts.app')
@section('title', "Уменьшить / увеличить изображения")
@section('content')
@push('head')
<script>
    $(document).ready(function() {
        $('#forclick').on('click', function(){
            $('#first').css('display', 'none');
            $('#second').css('display', 'block');
        });
    });
</script>
@endpush
<div class="container">
    <div class="row" id='first'>
        <div class='col-md-8'>
            @if ($message = Session::get('status'))
            <div class="alert alert-danger" role='alert'>
                {{$message}}
            </div>
            @endif
            @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        <div class="col-lg-12 text-center" style="margin-top: 40px;">
            <form action="{{ action('ImageController@resize') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="size" class="control-label">Изменить размер для:</label>
                    <select name="size">
                        <option value="0">КАСКО (1600 x 1200)</option>
                        <option value="1">Почта (1024 x 768)</option>
                        <option value="2">Анкета (800 x 600)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="img" class="control-label"></label>
                    <input type="file" class="form-control" name="img[]" multiple required accept="image/*">
                </div>
                <button type="submit" class="btn btn-info" 
                        id="forclick">Изменить размер</button>
            </form>
        </div>
    </div>
    <div class="row justify-content-center text-center" 
         id="second" style="display: none; padding: 90px">
        Сейчас появится запрос на сохранение новых изображений
    </div>
</div>
@endsection

