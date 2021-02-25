@extends('layouts.app')
@section('title', "Системная страница")
@section('content')
<article class="container main_page top-130">
    
    <br/>
    {{RGSPortal::getEmail(getenv('REMOTE_USER'))}}
</article>
@endsection

