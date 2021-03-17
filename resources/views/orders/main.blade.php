@extends('layouts.app')
@section('title', "Оформление заказа картриджей и расходных материалов")
@section('content')
@push("head")
<script>
    $(document).ready(function() {
        $('#forclick').on('click', function(){
            $('#first').css('display', 'none');
            $('#second').css('display', 'block');
        });
    });
    function doPlus(id) {
        var inpNum = document.getElementById('inpNum'+id);
        var answer = parseInt(inpNum.value) + 1;
        var div = document.getElementById('div'+id);
        if (answer > 0) {
            document.getElementById('tech'+id).setAttribute('name', 'tech[]');
            document.getElementById('model'+id).setAttribute('name', 'model[]');
            inpNum.setAttribute('name', 'count_m[]');
            div.setAttribute('style', 'border:1px solid rgb(46, 170, 247)');
            div.setAttribute('style', 'background-color:lightskyblue');
        }
        let max = parseInt(document.getElementById('remain'+id).innerHTML);
        if (answer <= max) {
            inpNum.value = answer;
        } else {
            answer = answer - 1;
            if (answer <= 0) {
                div.setAttribute('style', 'border:none');
                div.setAttribute('style', 'background-color:none');
            }
            alert('Нельзя выбрать больше остатка на складе '+max+"you: "+answer);
        }
    };
    function doMinus(id) {
        let answerM = parseInt(document.getElementById('inpNum'+id).value) - 1;
        let inpNum = document.getElementById('inpNum'+id);
        let div = document.getElementById('div'+id);
        if (answerM >= 0) {
            inpNum.value = answerM;
        } 
        if (answerM <= 0) {
            document.getElementById('tech'+id).removeAttribute('name');
            document.getElementById('model'+id).removeAttribute('name');
            inpNum.removeAttribute('name');
            div.setAttribute('style', 'border:none');
            div.setAttribute('style', 'background-color:none');
        }
    }
</script>
@endpush
<article>
    <div class="container main_page orders">
    <?php $real_ip = ip2long($ip); ?>
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($message = Session::get('danger'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{$message}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ action('OrderController@store') }}" method="post">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <input type="hidden" name="real_ip" value="{{ old('real_ip', $ip) }}">
        {{-- <input type="hidden" name="created" value="{{ date('Y-m-d H:i:s') }}"> --}}
        <input type="hidden" name="firm" value="{{ old('firm', isset($firm->name) ? $firm->name : 'Test') }}">
        <input type="hidden" name="userRealName" value="{{$userRealName}}">
        @foreach($categories as $cat)
        <div class="form-group">
            <div class="card-header text-center alert alert-success">
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-0">
                                {{$cat->category}}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="form-row form-body-order cards-row">
            @foreach($technics as $tech)
                @if($tech->category_id == $cat->id)
                <div class="card-orders" id="div{{$tech->id}}">
                    <input type="hidden" id="model{{ $tech->id }}" value="{{ old('model', $tech->model) }}">
                    <input type="hidden" id="tech{{ $tech->id }}" value="{{ old('tech', $tech->tech) }}">
                        <img src="{{ asset('img/tech/'.$tech->photo) }}" class="img-thumbnail h110" />
                    <div class="flex-child-grow">
                        <h4 class="dashboard-table-text">{!! $tech->tech !!}</h4>
                        <span class="dashboard-table-timestamp text-muted">Картридж {{ $tech->model }}</span>
                    </div>
                    <div>
                        <h6 class="text-center badge badge-info">Остаток на складе:  <span id="remain{{ $tech->id }}">{{$tech->count}}</span> шт.</h6>
                    </div>
                    <br>
                    <div class="order-bottom">
                        <div class="input-group input-number-group row">
                            <div class="input-group-button col">
                                <i class="bi bi-dash-square s500 orderMinus" data-id="{{ $tech->id }}" 
                                onclick="doMinus({{$tech->id}})"></i>
                            </div>
                            <input class="input-number text-center col" type="number" id="inpNum{{ $tech->id }}" value="0" min="0" readonly>
                            <div class="input-group-button col">
                                <i class="bi bi-plus-square orderPlus s500" data-id="{{ $tech->id }}" 
                                onclick="doPlus({{$tech->id}})"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
                </div>
            </div>
<hr><hr>
        @endforeach
        <br/>
        <div class="row">
            <div class="col-12 text-center">
                <label lass="control-label" for="others">
                    Здесь можно дописать то, что не вошло в форму заказа (напр. сетевые фильтры, мыши, клавиатуры, телефоны и прочее):
                </label>
                    <textarea rows="2" class="form-control" maxlength="2000" name="others"></textarea>
                    <p><small>Не более 2000 символов.</small></p>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-12 text-center">
                    <div class="spinner-border text-danger" id="second" 
                         style="display: none" role="status">
                        <span class="sr-only">Loading...</span>
                        <span class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true">
                        </span>
                    </div>
                <div id="first">
                    <button type="submit" class="btn btn-primary" 
                        id="forclick">Отправить</button>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 text-right">
            <span class="text-muted">
                {{ isset($firm->name) ? $firm->name : 'Test' }} - {{ $ip }}
                <br/> {{ $userRealName }}
            </span>
        </div>
    </div>
</div>
    <script type="text/javascript">
    // var buttons_plus = document.querySelectorAll('.orderPlus');
    //     buttons_plus.forEach((elem) => {
    //         elem.addEventListener('click', function() {
    //             var id = elem.getAttribute('data-id');
    //             var inpNum = document.getElementById('inpNum'+id);
    //             var answer = parseInt(inpNum.value) + 1;
    //             var div = document.getElementById('div'+id);
    //             if (answer > 0) {
    //                 document.getElementById('tech'+id).setAttribute('name', 'tech[]');
    //                 document.getElementById('model'+id).setAttribute('name', 'mosel[]');
    //                 inpNum.setAttribute('name', 'count_m[]');
    //                 div.setAttribute('style', 'border:1px solid rgb(46, 170, 247)');
    //                 div.setAttribute('style', 'background-color:lightskyblue');
    //             }
    //             var max = parseInt(document.getElementById('remain'+id).innerHTML);
    //             if (answer <= max) {
    //                inpNum.value = answer;
    //            } else {
    //                alert('Нельзя выбрать больше остатка на складе '+max);
    //            }
    //        })
    //     });
    // var buttons_minus = document.querySelectorAll('.orderMinus');
    //     buttons_minus.forEach((elem) => {
//            elem.addEventListener('click', function() {
//                var id = elem.getAttribute('data-id');
//                var answerM = parseInt(document.getElementById('inpNum'+id).value) - 1;
//                var inpNum = document.getElementById('inpNum'+id);
//                var div = document.getElementById('div'+id);
//                // console.log(inpNum.hasOwnProperty(name));
//                if (answerM >= 0) {
//                    inpNum.value = answerM;
//                } 
//                if (answerM <= 0) {//
//                    document.getElementById('tech'+id).removeAttribute('name');
//                    document.getElementById('model'+id).removeAttribute('name');
//                    inpNum.removeAttribute('name');
//                    div.setAttribute('style', 'border:none');
//                    div.setAttribute('style', 'background-color:none');
//                }
//            })
//        });
//        };
</script>
</article>
@endsection

