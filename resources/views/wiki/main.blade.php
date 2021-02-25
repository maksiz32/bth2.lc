@extends('layouts.app')
@section('title', "База знаний ИТ")
@section('content')
@push("head")
<script>
    $(document).ready(function() {
        $('select').on('change', function () {
            $('.sel-text').css('display', 'none');
            var $idSys = $('select :selected').val();
            $("."+$idSys).css('display', 'block');
        })
    });
</script>
<script> 
  $(document).ready(function() { 
  $('#searchBtn').prop("disabled",true); 
  $(document).on('input', 'input[type="text"]', function () { 
  var $item = $(this).val().length; 
  if($item > 2) { 
  $('#searchBtn').removeAttr("disabled"); 
  } else { 
  $('#searchBtn').prop("disabled",true); 
  }; 
  }); 
  }); 
  </script>
@endpush
<article class="container-fluid main_page top-130">
            <div class="breadcr text-mono" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/wiki">База знаний</a></li>
                    <li class="breadcrumb-item">Результаты поиска</li>
                </ol>
            </div>
    @if($search)
    @foreach($search as $ser)
    <p>
    <a href="{{action('WikiController@wikiOne',['id' => $ser->id])}}">
    {{$loop->iteration.": ".$ser->error." (Раздел: \"".$ser->system."\")"}}
    </a>
    </p>
    @endforeach
    @else
    <div class="form-group row">
        <div class="col-11 text-center align-content-center mt-3">
            <label for="font-size">Выбрать раздел:</label>
            <select class="form-control">
                <option selected disabled>Выбрать раздел:</option>
                @foreach($mainSystems as $sys)
                <option value="{{$sys->id}}">{{$sys->system}}</option>
                @endforeach
            </select>
        </div>
        <br>
        <ul>
        @foreach($systems as $sys)
        <div class="sel-text col-12 ml-3 mt-3 {{$sys->id_sys}}" style="display: none">
            <li>
            <a href="{{action('WikiController@wikiOne',['id' => $sys->id])}}">
                {{$sys->error}}
            </a>
            </li>
        </div>
        @endforeach
        </ul>
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
        <div class="col-md-5">
            <form action="{{action('WikiController@search')}}" method="post">
                {{ csrf_field() }}
                    <div class="input-group">
                        <div class="ml-3 mr-3 mt-1">
                            Поиск:
                        </div>
                        <div class="input-group-prepend">
                            <div class="input-group-text">?</div>
                        </div>
                        <input type="text" placeholder="Три символа и больше" class="form-control" name="textSearch" id="textSearch" required="">
                        <button type="submit" class="btn btn-primary ml-1" id="searchBtn">Найти</button>
                    </div>
            </form>
        </div>
    @endif
</article>
@endsection
