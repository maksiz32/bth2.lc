@extends('layouts.app')
@section('title', "По подразделению")
@section('content')
<div class="container"> 
        <form action="{{ action('OrderController@getByFirm',['what' => 'f']) }}" method="post"> 
            <div class="form-row"> 
                {{ csrf_field() }}
            <div class="form-group col">
                <label for="name" class="col-12 control-label">Выберите отдел:</label>
                <select name="name" required>
                    @foreach($firms as $firm)
                    <option value="{{ $firm->name }}">{{ $firm->name }}</option>
                    @endforeach
                </select>
            </div>
            </div>
            <div class="form-row">
        <button type="submit" class="btn btn-primary">Создать</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
            </div>
        </form>
</div>
@endsection
