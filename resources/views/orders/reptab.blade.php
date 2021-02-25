@extends('layouts.app')
@section('title', "По подразделению")
@section('content')
<div class="container">
    <div class="row">
@if ($name)
    <div class="col-12 text-center alert alert-success" role="alert">
    {{ $name }}
    </div>
@endif
    <div class="col-lg-12">
    <table class="table table-striped table-bordered">
        <caption>Количество заказанных расходников</caption>
        <thead class="thead-dark">
            <tr>
                <th scope="col">Картридж</th>
                <th scope="col">Количество</th>
                <th scope="col">Дополнительно</th>
                <th scope="col">Дата</th>
                <th scope="col">Отдел</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $rep)
            <tr>
                <th>{{ $rep->model }}</th>
                <th>{{ $rep->count_m }}</th>
                <th>@isset($rep->others){{ $rep->others }}@endisset</th>
                <th>{{ date('d-m-Y', strtotime($rep->created)) }}</th>
                <th>{{ $rep->firm }}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
	<a class="btn btn-primary" href="javascript:history.go('-1');">
            <div id="back">
                <b>Назад</b>
            </div>
        </a>
    </div>
</div>
@endsection
