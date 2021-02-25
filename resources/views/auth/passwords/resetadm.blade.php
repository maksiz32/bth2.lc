@extends('layouts.app')

@section('content')
<div class="container">
    Смена пароля для пользователя: <strong>{{ $user->name }}</strong>
            @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
            @endif
    <form id="form-change-password" role="form" method="POST" action="{{ url('/user/credentials') }}" novalidate class="form-horizontal">
        <div class="col-md-9">
            {{ csrf_field() }}
            <input type="hidden" class="form-control" id="password" name="id" value="{{ $user->id }}">
            <label for="password" class="col-sm-4 control-label">New Password</label>
            <div class="col-sm-8">
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
            </div>
            <label for="password_confirmation" class="col-sm-4 control-label">Re-enter Password</label>
            <div class="col-sm-8">
                <div class="form-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter Password">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-6">
                <button type="submit" class="btn btn-danger">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
