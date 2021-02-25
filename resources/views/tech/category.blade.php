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
        @foreach($categories as $category)
            <div class="col-12">
                {{$category->id . ". ". $category->category}}
            </div>
        @endforeach
        <form action="{{ action('TechController@makeCategory') }}" method="post">
            <div class="form-row">
    
        @if (isset($cat) && $cat->id)
            {{ method_field('PUT') }}
        <input type="hidden" name="id" value="{{ old('id', $cat->id) }}">
        @endif
        {{ csrf_field() }}
            <div class="form-group col-10">
                <label for="number" class="control-label small">Номер машины (6 символов, без пробелов):</label>
                <input type="text" class="form-control" name="number" value="" required>
            </div>
            </div>
    </form>
</div>
@endsection
