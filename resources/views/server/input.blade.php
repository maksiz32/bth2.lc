@extends('layouts.app')
@section('title', "Оформление заказа картриджей и расходных материалов")
@section('content')
<article>
    <div class="container main_page">
    @if (isset($message))
        <div class="alert alert-danger" role="alert">
            {{ $message }}
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
        <form action="" method="post" id="formF" enctype="multipart/form-data" class="serverform">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="serverform-top">
                <!-- Сюда выводить количество уже загруженных изображений в конкретном типе -->
                В блоке <span id="form_block" class="serverform-top__block">A</span> загружено 
                <span id="form_count" class="serverform-top__count">{{$countImgs}}</span> фотографий
            </div>
            <div class="serverform-main">
                <label for="view">Выберите тип блока фоток:</label>
                <select name="view" onchange="" class="serverform-main__choys">
                    <option value="A" selected>A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
                <label for="pic">Выберите изображение (не более 800 Кб):</label>
                <input type="file" name="pic" class="serverform-main__file" required>
            </div>
            <div class="serverform-btn">
                <button type="submit" class="serverform-btn__submit">
                    Загрузить
                </button>
                <button type="reset" class="serverform-btn__reset">
                    Очистить
                </button>
            </div>
        </form>
        <script>
            function getCountImgs(char) {
                //TODO
            }
        </script>
    </div>
</article>
@endsection