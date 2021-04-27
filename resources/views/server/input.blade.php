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
        <form action="{{action('PhotoorderController@inputAction')}}" method="post" 
        id="formF" enctype="multipart/form-data" class="serverform">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <section class="serverform-top">
                <p class="server-top__title">
                    <!-- Сюда выводить количество уже загруженных изображений в конкретном типе -->
                    В блоке <span id="form_block" class="serverform-top__block">A</span> загружено 
                    <span id="form_count" class="serverform-top__count">{{$countImgs}}</span> фотографий:
                </p>
                <div class="serverform-top-pic" id="imgsBlock">
                    @if(isset($images))
                    @foreach($images as $img)
                    <img src="{{asset('/img/server/' . $img->path)}}" width="80" 
                        class="serverform-top-pic__img">
                    @endforeach
                    @endif
                </div>
            </section>
            <section class="serverform-main">
                <label for="view">Выберите тип блока фоток:</label>
                <select name="view" onchange="" class="serverform-main__choys" id="chngView">
                    <option value="A" selected>A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
                <label for="pic">Выберите изображения (не более 15 штук - если выбрали больше 15, загрузятся только 15 и не более 1.5 Mб каждое):</label>
                <input type="file" name="pic[]" class="serverform-main__file" 
                    multiple required accept="image/*" id="file">
            </section>
            <div class="serverform-btn" id="btnBlock">
                <button type="submit" class="serverform-btn__submit" id="formBtn">
                    Загрузить
                </button>
                <button type="reset" class="serverform-btn__reset">
                    Очистить
                </button>
            </div>
        </form>
    </div>
</article>
<script src="{{asset('/js/serverphotoorder.js')}}"></script>
@endsection