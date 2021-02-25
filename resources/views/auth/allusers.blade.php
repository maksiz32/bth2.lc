@extends('layouts.app')
@section('title', 'Все пользователи Портала')
@section('content')
<div class="container-fluid top-110">
<div class="row">
    <div class="col-lg-12">
        @if ($message = Session::get('status'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('status') }}
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
            @endif
            @if (auth()->check() && Auth::user()->role == 'admin')
            <div class="text-center"><p>
                <a href="{{ route('register') }}" class="btn btn-primary">Создать нового пользователя</a>
                </p></div>
            @endif
    <table class="table table-striped table-bordered">
        <caption>Список разделов для просмотра и редактирования</caption>
        <thead class="thead-dark">
            <tr>
                <th scope="col">№</th>
                <th scope="col">Имя пользователя</th>
                <th scope="col">E-mail</th>
                <th scope="col">Роль</th>
                <th scope="col">Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;?>
    @foreach ($users as $user)
            <tr>
                <th scope="row">{{ $i }}</th>
                <th>{{ $user->name }}</th>
                <th>{{ $user->email }}</th>
                <th>{{ $user->role }}</th>
                <th>
                    <p><a href="{{ action('Auth\RegisterController@edit', ['id' => $user->id]) }}" class="btn btn-primary">
                        Редактировать
                        </a></p>
                    <p><a href="{{ action('Auth\RegisterController@chPass', ['id' => $user->id]) }}" class="btn btn-primary">
                        Изменить пароль
                        </a></p>
                    <p><a href="{{ action('Auth\RegisterController@delete', ['id' => $user->id]) }}" class="btn btn-danger">
                        Удалить
                        </a></p>
                </th>
            </tr>
            <?php $i++;?>
    @endforeach
        </tbody>
    </table>
            @if ($users->has('links'))
    {{ $user->links() }}
    @endif
</div>
</div>
</div>
@endsection

