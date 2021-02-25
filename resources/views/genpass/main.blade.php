@extends('layouts.app')
@section('title', "Генерация паролей")
@section('content')
@push("head")
<script type="text/javascript">
    function addName(cb, cat) {
        cb = document.getElementById(cb);
        cat = document.getElementById(cat);
	cb.setAttribute('style', 'display:none;');
	cat.setAttribute('style', 'display:block;');
	}
</script>
@endpush
<div class="container">
<?php
    function generate_password_char() {
            $arr[] = [
                    'a','b','c','d','e','f','g','h','i','j','k',
                    'm','n','o','p','q','r','s','t','u','v',
                    'w','x','y','z'
                ];
            $arr[] = [
                    'A','B','C','D','E','F','G','H','J','K',
                    'L','M','N','P','Q','R','S','T','U','V',
                    'W','X','Y','Z'
                ];
            $arr[] = [
                    '1','2','3','4','5','6','7','8','9'
                ];
            $arr[] = [
                    '!','@','#','$','%','&','-','_','=','+'
                ];
            $pass = '';
            for ($i=0;$i<4;$i++){
                    $index = rand(0, count($arr[$i])-1);
                    $pass .= $arr[$i][$index];                
            }
            for ($i=0;$i<4;$i++){
                    $numA = rand(0, 3);
                    $index = rand(0, count($arr[$numA])-1);
                    $pass .= $arr[$numA][$index];                
            }
            return $pass;
	}
    function generate_password() {
            $arr[] = [
                    'a','b','c','d','e','f','g','h','i','j','k',
                    'm','n','o','p','q','r','s','t','u','v',
                    'w','x','y','z'
                ];
            $arr[] = [
                    'A','B','C','D','E','F','G','H','J','K',
                    'L','M','N','P','Q','R','S','T','U','V',
                    'W','X','Y','Z'
                ];
            $arr[] = [
                    '1','2','3','4','5','6','7','8','9'
                ];            
            $pass = '';
            for ($i=0;$i<3;$i++){
                    $index = rand(0, count($arr[$i])-1);
                    $pass .= $arr[$i][$index];                
            }
            for ($i=0;$i<5;$i++){
                    $numA = rand(0, 2);
                    $index = rand(0, count($arr[$numA])-1);
                    $pass .= $arr[$numA][$index];                
            }
            return $pass;
	}
?>
    
    <div class="panel panel-primary alert alert-success">
    <div class="row">
        <div class="col-lg-12" id="forview" style="display:none;">
            <p><h3>
        <?php echo generate_password_char();?>
            </h3></p>
	<a href="javascript:history.go();">
		<div class="button" id="back">
		<b>Назад</b>
		</div>
        </a>
        </div>
        <div class="col-lg-12" id="forview1" style="display:none;">
            <p><h3>
        <?php echo generate_password();?>
            </h3></p>
	<a href="javascript:history.go();">
		<div class="button" id="back">
		<b>Назад</b>
		</div>
        </a>
        </div>
    </div>
    <div class="row" id="forhide">
            <div class="form-group col-lg-6">
                <button type="submit" class="btn btn-primary" onclick='addName("forhide","forview")'>Сгенерировать пароль со спец-символами</button>
            </div>
            <div class="form-group col-lg-6">
                <button type="submit" class="btn btn-primary" onclick='addName("forhide","forview1")'>Сгенерировать пароль</button>
            </div>
    </div>
    </div>
</div>
@endsection
