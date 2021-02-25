@extends('layouts.app')
@section('title', "База знаний ИТ - ".$system->system)
@section('content')
<article class="container-fluid main_page top-130">
            <div class="breadcr text-mono" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/wiki">База знаний</a></li>
                    <li class="breadcrumb-item">{{$system->system}}</li>
                </ol>
            </div>
    @foreach($wiki as $wik)
    <p class="ml-5">
    <a href="{{action('WikiController@wikiOne',['id' => $wik->id])}}">
    {{$loop->iteration.": ".$wik->error." (Раздел: \"".$wik->system."\")"}}
    </a>
    </p>
    @endforeach
</article>
@endsection
