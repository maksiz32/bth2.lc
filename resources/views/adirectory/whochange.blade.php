@extends('layouts.nolinks')
@section('title', "Редактирование записей в AD")
@section('content')
@push("head")
<script>
    function addName(adid, adkey, dn, name) {
        adid = document.getElementById(adid);
        dn = document.getElementById(dn);
	    adid.removeAttribute('readonly');
        adid.setAttribute('name', adkey+'['+name+']');
        dn.setAttribute('name', adkey+'[dn]');
  }
</script>
@endpush
<article class="container main_page">
    @if ($message = Session::get('message'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('message') }}
    </div>
    @endif

    <form action="{{ action('AdWorkController@adModify') }}" method="post">
        <div class="row">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <input type="hidden" name="ldapuser" value="{{ old('ldapuser', $ldapuser) }}">
            <input type="hidden" name="ldappass" value="{{ old('ldappass', $ldappass) }}">
            <input type="hidden" name="companyDN" value="{{ old('companyDN', $companyDN) }}">
        </div>
        <div class="accordion" id="accordionOne">
           
        <!-- Name of my array -->
        <div class="card">
            <div class="card-header text-center alert alert-success" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        ОСП и Дирекция
                    </button>
                </h5>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionOne">
                <div class="card-body">
                    
<?php
$i = 1;
?>
@foreach($ouRegionsTop as $reg)    
        <div class="regAD{{ $i }}">
            <input type="hidden" id="dn1-{{ $i }}" value="{{ $reg['dn'] }}">
            <table class="table table-striped table-bordered">
                <tr>
                    <td colspan="3">{{$reg['name'][0]}} <strong>({{$reg['oubkid'][0]}})</strong></td>
                </tr>
                <tr>
                    <td width="220">
                        <input type="text" class="form-control-sm col-12" 
                            id="pA1{{$i}}" value="{{ (isset($reg['postaladdress'][0]))?$reg['postaladdress'][0]:'' }}" readonly 
                            onclick='addName("pA1{{$i}}", "main1[varAD{{$i}}]", "dn1-{{$i}}", "postaladdress");'
                            placeholder="Адрес">
                    </td>
                    <td width="80">
                        <input type="text" class="form-control-sm col-12" 
                            id="pC1{{$i}}" value="{{ (isset($reg['postalcode'][0]))?$reg['postalcode'][0]:'' }}" readonly 
                            onclick='addName("pC1{{$i}}", "main1[varAD{{$i}}]", "dn1-{{$i}}", "postalcode");'
                            placeholder="Индекс">
                    </td>
                    <td width="220">
                        @if($reg['name'][0] != "Дирекция")
                        <input type="text" class="form-control-sm col-12" 
                            id="tN1{{$i}}" value="{{ (isset($reg['telephonenumber'][0]))?$reg['telephonenumber'][0]:'' }}" readonly 
                            onclick='addName("tN1{{$i}}", "main1[varAD{{$i}}]", "dn1-{{$i}}", "telephonenumber");'
                            placeholder="Городские телефоны">
                        @else
                        {{ (isset($reg['telephonenumber'][0]))?$reg['telephonenumber'][0]:'' }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>
<?php
    $i++;
?>
@endforeach
                    </div>
                </div>
            </div>
           
        <div class="card">
            <div class="card-header text-center alert alert-success" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        Отделы и группы
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionOne">
                <div class="card-body">

<?php
$i = 1;
?>
@foreach($ouDepartments as $dep)
    <?php
        $canName = explode("/", $dep['canonicalname'][0]);
    ?>
        <div class="depAD{{ $i }}">
            <input type="hidden" id="dn2-{{ $i }}" value="{{ $dep['dn'] }}">
            <table class="table table-striped table-bordered">
                <tr>
                    <td colspan="3"><strong>{{$dep['name'][0]}} ({{$dep['oubkid'][0]}})</strong> - {{ $canName[4] }}</td>
                </tr>
                <tr>
                    <td width="220">
                        {!! (isset($dep['postaladdress'][0]))?$dep['postaladdress'][0]:'<em>Адрес</em>' !!}
                    </td>
                    <td width="80">
                        {!! (isset($dep['postalcode'][0]))?$dep['postalcode'][0]:'<em>Индекс</em>' !!}
                    </td>
                    <td width="220">
                        @if($canName[4] == 'Дирекция')
                        <input type="text" class="form-control-sm col-12" 
                            id="tN2{{$i}}" value="{{ (isset($dep['telephonenumber'][0]))?$dep['telephonenumber'][0]:'' }}" readonly 
                            onclick='addName("tN2{{$i}}", "main2[depAD{{$i}}]", "dn2-{{$i}}", "telephonenumber");'
                            placeholder="Городские телефоны">
                        @else
                        {!! (isset($dep['telephonenumber'][0]))?$dep['telephonenumber'][0]:'<em>Телефоны</em>' !!}
                        @endif
                    </td>
                </tr>
            </table>
        </div>
<?php
    $i++;
?>
@endforeach			
                    </div>
                </div>
            </div>
              
        <div class="card">
            <div class="card-header text-center alert alert-success" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Пользователи
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionOne">
                <div class="card-body">

<?php
$i = 1;
?>
@foreach($ouPersons as $pers)
        <div class="perAD{{ $i }}">
            <input type="hidden" id="dn3-{{ $i }}" value="{{ $pers['dn'] }}">
            <table class="table table-striped table-bordered">
                <tr>
                    <td colspan="5">
                        <strong>
                            {{ $pers['name'][0] }}
                        </strong>
                        {{ (isset($pers['title'][0]))?" - ".$pers['title'][0]:'' }}
                    </td>
                </tr>
                <tr>
                    <td width="60" height="60">
                    @if (isset($pers['thumbnailphoto'][0]))
                        <img width="60" height="60" 
                        src="{{'data:image/jpeg;base64,'.base64_encode($pers['thumbnailphoto'][0])}}">
                    @else
                        <span class="personline__noimg" app-data="{{$loop->index}}">
                            Нет<wbr> Фото
                        </span>
                    @endif
                    </td>
                    <td width="140">
                        {!! (isset($pers['postaladdress'][0]))?$pers['postaladdress'][0]:'<em>Адрес</em>' !!}
                    </td>
                    <td width="80">
                        {!! (isset($pers['postalcode'][0]))?$pers['postalcode'][0]:'<em>Индекс</em>' !!}
                    </td>
                    <td width="180">
                        {!! (isset($pers['telephonenumber'][0]))?$pers['telephonenumber'][0]:'<em>Городской телефон</em>' !!}
                    </td>
                    <td width="120">
                        <input type="text" class="form-control-sm col-12" 
                            id="iN3{{$i}}" value="{{ (isset($pers['ipphone'][0]))?$pers['ipphone'][0]:'' }}" readonly 
                            onclick='addName("iN3{{$i}}", "main3[perAD{{$i}}]", "dn3-{{$i}}", "ipphone");'
                            placeholder="Внутренний телефон">
                    </td>
                </tr>
            </table>
        </div>
<?php
    $i++;
?>
@endforeach			
                    </div>
                </div>
            </div>
            
        </div>
        <br/>
        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <button type="reset" class="btn btn-secondary">Отмена</button>
            </div>
        </div>
    </form>
</article>
@endsection
