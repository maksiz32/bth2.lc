@extends('layouts.app')
@section('title', 'Добавить/ удалить отделы к заявкам на авто')
@section('content')
@push('head')
<script>
    $(document).ready(function(){
        $('.btn-primary').on('click',function(){
            $(this).css('display','none');
        })
    });
</script>
@endpush
<div class="container top-130">
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 text-center mt-5">
            <h3>Доступ предоставлен:</h3>
            <table class="table table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Подразделение</th>
                        <th scope="col">Операции</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($acss as $acs)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <th scope="row">{{$acs->name}}</th>
                        <th scope="row">
                            @if($acs->name === "Дирекция филиала")
                            <a class="btn btn-light">
                                Запретить 
                            </a>
                            @else
                            <a class="btn btn-primary" href="{{action('AccessIpController@destroy',['id'=>$acs->id])}}">
                                Запретить 
                            </a>
                            @endif
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
    <div class="col-12 text-center small mt-5">
        Добавить - разрешить:
    </div>
    @if(count($errors)>0)
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ action('AccessIpController@save') }}" method="post">
        <div class="form-row">
        {{ csrf_field() }}
            <div class="form-group col-lg-9">
                <label for="id_firms" class="control-label small">
                    Выбрать одел:
                </label>
                <select name="id_firms" required>
                    <option selected disabled>Выбрать отдел:</option>
                @foreach($firms as $firm)
                    @if(!$acss->contains('id_firms',$firm->id))
                    <option value="{{$firm->id}}">{{$firm->name}}</option>
                    @else
                    <option disabled>{{$firm->name}}</option>
                    @endif
                @endforeach
                </select>
            </div>
            <div class="form-group col-lg-3 align-self-start">
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
        </div>
    </form>
        </div>
    </div>
</div>
@endsection
