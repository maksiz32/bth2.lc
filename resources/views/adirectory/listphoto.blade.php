@extends('layouts.nolinks')
@section('title', "Редактирование фото")
@section('content')
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
<?php
$i = 0;
?>
@foreach($ouPersons as $pers)
        <input type="hidden" id="dn3-{{ $i }}" value="{{ $pers['dn'] }}">
            <table class="table table-striped table-bordered">
                <tr>
                    <td colspan="4">
                        <strong>
                            {{ $pers['name'][0] }}
                        </strong>
                        {{ (isset($pers['title'][0]))?" - ".$pers['title'][0]:'' }}
                    </td>
                </tr>
            </table>
<?php
    $i++;
?>
@endforeach
        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <button type="reset" class="btn btn-secondary">Отмена</button>
            </div>
        </div>
    </form>
</article>
@endsection
