@extends('layouts.app')
@section('title', "Все отчеты в разделе Заказ расходных материалов")
@section('content')
<article class="container main_page">
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ url('/byfirm') }}" class="stretched-link">
                <div class="shadow alert alert-success rounded" role="alert" id="link">
                    <p>
                        <strong>
                            По отделам
                        </strong>
                    </p>
                </div>
            </a>
        </div>
        <div class="col-lg-12">
            <a href="{{ url('/bydate') }}" class="stretched-link">
                <div class="shadow alert alert-success rounded" role="alert" id="link">
                    <p>
                        <strong>
                            По дате
                        </strong>
                    </p>
                </div>
            </a>
        </div>
        <div class="col-lg-12">
            <a href="{{ url('/bytech') }}" class="stretched-link">
                <div class="shadow alert alert-success rounded" role="alert" id="link">
                    <p>
                        <strong>
                            По технике
                        </strong>
                    </p>
                </div>
            </a>
        </div>
    </div>
</article>
@endsection

