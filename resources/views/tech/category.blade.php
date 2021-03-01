@extends('layouts.app')
@section('title', "Категории техники")
@section('content')
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
        <div class="col-12">
            Категории:
        </div>
        @if(isset($categories))
        @foreach($categories as $category)
            <div class="col-12">
                {{$category->id . ". ". $category->category}}
                <a href="/category/{{$category->id}}" class="btn btn-info">Редактировать</a>
                <a href="" class="btn btn-danger">Удалить</a>
            </div>
                <br>
        @endforeach
        @endif
        <form action="{{ action('TechController@makeCategory') }}" method="post">
            <div class="form-row">
                @if (isset($cat) && $cat->id)
                    {{ method_field('PUT') }}
                <input type="hidden" name="id" value="{{ old('id', $cat->id) }}">
                @endif
                {{ csrf_field() }}
                    <div class="form-group col-10">
                        <label for="category" class="control-label small">Название категории:</label>
                        <input type="text" class="form-control" name="category" value="{{ old('category', $cat->category) }}" required>
                    </div>
            </div>
            <button type="submit">Ввод</button>
    </form>
</div>
@endsection
