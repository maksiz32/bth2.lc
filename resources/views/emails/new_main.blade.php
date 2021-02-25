@extends('layouts.app')
@section('title', 'Просмотр адресов уведомлений различных ресурсов')
@section('content')
<div class="container-fluid top-130">
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 text-center mt-5">
            <table class="table table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Текущий адрес</th>
                        <th scope="col">Описание/ Принадлежность</th>
                        <th scope="col">Используется для</th>
                        <th scope="col">Последнее изменение</th>
                        <th scope="col">Операции</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emails as $email)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <th scope="row">{{$email->email}}</th>
                        <th scope="row">{{$email->who}}</th>
                        <th scope="row">{{$email->setMailNameSource(2)}}</th>
                        <th scope="row">{{date('d-m-Y H:m', strtotime($email->updated_at))}}</th>
                        <th scope="row">
                            <a class="btn btn-primary" 
                                href="{{action('AddrEmailController@edit', ['id' => $email->id])}}">
                                Изменить 
                            </a>
                            <a class="btn btn-danger" 
                               href="{{action('AddrEmailController@delete', ['id' => $email->id])}}" 
                               OnClick="return confirm('Подтвердите удаление элемента')" >
                                Удалить
                            </a>
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
    @if(count($errors)>0)
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-12 text-center small">
        Добавить адрес почты
    </div>
    <form action="{{ action('AddrEmailController@saveNew') }}" method="post">
    <div class="form-row">
        {{ csrf_field() }}
            <div class="form-group col-lg-5">
                <label for="email" class="control-label small">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group col-lg-6">
                <label for="who" class="control-label small">Чей (пользователь или группа):</label>
                <input type="text" class="form-control" name="who" required>
            </div>
            <div class="form-group col-lg-1 align-self-end">
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
    </div>
        </div>
    </div>
</div>
@endsection
