@extends('layouts.app')
@section('title', 'Все ОК!')
@section('content')
<article class="container h110">
    <div class="row">
        <div class="col-12">
    @if (isset($success))
            <div class="alert alert-success" role="alert">
                <strong>
                {{ $success }}
                </strong>
                <br/>
                <ul>
                    @if(isset($order[0]['model']))
                    @foreach($order as $ord)
                    <li>Картридж <b>{{$ord['model']}}</b> для <u>{{$ord['tech']}}</u> в количестве - <b>{{$ord['count_m']}} шт.</b></li>
                    @endforeach
                    @endif
                </ul>
                <p>
                    Дополнительно:
                    @foreach($order as $ord)
                    <b>{{$ord['others']}}</b>
                    @endforeach
                </p>
            </div>
    @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
            @endif
        </div>
    </div>
</article>
@endsection

