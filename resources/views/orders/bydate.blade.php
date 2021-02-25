@extends('layouts.nonstyle')
@section('title', "По дате")
@section('content')
@push('head')
    <script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
    <link href="{{ asset('/css/wbn-datepicker.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/wbn-datepicker.js') }}"></script>
<script>
    $(function(){
        $('.wbn-datepicker').datepicker();
    });
</script>
@endpush
<div class="container"> 
        <form action="{{ action('OrderController@getByFirm',['what' => 'd']) }}" method="post"> 
                Выберите критерий:
            <div class="form-row">
                {{ csrf_field() }}
                <div class="form-group col">
                    <label for="dateStart" class="control-label">From:</label>
                    <input type="text" name="dateStart" class="form-control wbn-datepicker" />
                </div>
                <div class="form-group col">
                    <label for="dateEnd" class="control-label">To:</label>
                    <input type="text" name="dateEnd" class="form-control wbn-datepicker" />
                </div>
            </div>
            <div class="form-row align-content-center">
                <div class="form-group col">
                    <button type="submit" class="btn btn-primary">Создать отчет</button>
                    <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
                </div>
            </div>
        </form>
</div>
@endsection
