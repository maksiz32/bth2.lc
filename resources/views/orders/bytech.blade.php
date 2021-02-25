@extends('layouts.app')
@section('title', "По моделе оборудования")
@section('content')
<div class="container"> 
        <form action="{{ action('OrderController@getByFirm',['what' => 't']) }}" method="post"> 
            <div class="form-row"> 
                {{ csrf_field() }}
            <div class="form-group col">
                <label for="tech" class="col-12 control-label">Выберите критерий:</label>
                <select name="tech" required>
                    @foreach($teches as $tech)
                    <option value="{{ $tech->model }}">{{ $tech->tech }}</option>
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
