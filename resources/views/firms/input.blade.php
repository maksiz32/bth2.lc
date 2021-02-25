@extends('layouts.app')
<?php $h = ($firm->id) ? "Редактирование подразделения" . $firm->name : "Добавление нового подразделения" ?>
@section('title', $h)
@section('content')
<article class="container main_page">
    @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
            @endif
            <form action="{{ action('FirmController@store') }}" method="POST">
    @if ($firm->id)
                {{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{ old('id', $firm->id) }}">
    @endif
                {{ csrf_field() }}
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="name" class="control-label">Название подразделения:</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $firm->name) }}" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="nameEng" class="control-label">Название латиницей:</label>
            <input type="text" class="form-control" name="nameEng" value="{{ old('nameEng', $firm->nameEng) }}" required>
        </div>
        <div class="form-group col-lg-6">
            <label for="skk" class="control-label">Код СКК подразделения:</label>
            <input type="text" class="form-control" name="skk" value="{{ old('skk', $firm->skk) }}" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-4">
            <label for="famNSO" class="control-label">Фамилия НСО:</label>
            <input type="text" class="form-control" name="famNSO" value="{{ old('famNSO', $firm->famNSO) }}" required>
        </div>
        <div class="form-group col-lg-4">
            <label for="nameNSO" class="control-label">Имя НСО:</label>
            <input type="text" class="form-control" name="nameNSO" value="{{ old('nameNSO', $firm->nameNSO) }}" required>
        </div>
        <div class="form-group col-lg-4">
            <label for="otchNSO" class="control-label">Отчество НСО:</label>
            <input type="text" class="form-control" name="otchNSO" value="{{ old('otchNSO', $firm->otchNSO) }}" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="ipStart" class="control-label" pattern="\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}">Начальный IP-адрес адресного пространства для подразделения:</label>
            <input type="text" class="form-control" name="ipStart" value="{{ old('ipStart', long2ip($firm->ipStart)) }}" required>
        </div>
        <div class="form-group col-lg-6">
            <label for="ipEnd" class="control-label" pattern="\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}">Конечный IP-адрес адресного пространства для подразделения:</label>
            <input type="text" class="form-control" name="ipEnd" value="{{ old('ipEnd', long2ip($firm->ipEnd)) }}" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="addr" class="control-label">Фактический адрес подразделения:</label>
            <input type="text" class="form-control" name="addr" value="{{ old('addr', $firm->addr) }}" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="isblock" class="col-md-4 control-label">Закрыт/существует:</label>
            <select name="isblock" required>
                @if (!$firm->isblock)
                <option value="0" selected>Закрыт</option>
                <option value="1">Существует</option>
                @else
                <option value="0">Закрыт</option>
                <option value="1" selected>Существует</option>
                @endif
            </select>
        </div>
        <div class="form-group col-lg-6">
            <label for="tel" class="control-label">Телефоны подразделения:</label>
            <input type="text" class="form-control" name="tel" value="{{ old('tel', $firm->tel) }}">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="description" class="control-label">Описание:</label>
            <textarea rows="2" class="form-control" name="description">
            {{ old('description', $firm->description) }}
            </textarea>
        </div>
    </div>
    <div class="row">  
        <button type="submit" class="btn btn-primary">Сохранить</button>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="#" class="btn btn-secondary" onClick="window.location.href=window.location.href">Отмена</a>
    </div>
</article>
@endsection

