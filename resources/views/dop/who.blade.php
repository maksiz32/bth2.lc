@extends('layouts.app')
@section('title', "Загрузка именинников")
@section('content')
@push('head')
<script type="text/javascript">
  function doVis(cb, mat, par0, par1, par2, par3, par4, par5) {
        cb = document.getElementById(cb);
        mat = document.getElementById(mat);
        par0 = document.getElementById(par0);
        par1 = document.getElementById(par1);
        par2 = document.getElementById(par2);
        par3 = document.getElementById(par3);
        par4 = document.getElementById(par4);
        par5 = document.getElementById(par5);
    if (cb.checked) {
		mat.setAttribute('style', 'display:none');
                cb.removeAttribute('name');
                par0.removeAttribute('name');
                par1.removeAttribute('name');
                par2.removeAttribute('name');
                par3.removeAttribute('name');
                par4.removeAttribute('name');
                par5.removeAttribute('name');
	} else {
		mat.setAttribute('style', 'display:block');
	}
  }
</script>
@endpush
<div class="container">
    <div class="row">
        @if (isset($arrErr))
        <div class="alert alert-danger">
            Данные о:<br/>
            @foreach ($arrErr as $arrErr2)
            - {{ $arrErr2['nameF'] }} {{ $arrErr2['nameN'] }}<br/>
            @endforeach
            <br/>
            не внесены, т.к. они уже были в базе.
        </div>
        @endif
        <form action="{{ action('InputController@save') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="alert alert-danger">
                <h2>Отметь сотрудников, которых НЕ НАДО загружать</h2>
            </div>
    <table class="table table-striped table-bordered">
        <caption>Список загрузки</caption>
        <thead class="thead-dark">
            <tr>
                <th scope="col">Выбор</th>
                <th scope="col">Фамилия</th>
                <th scope="col">Имя</th>
                <th scope="col">Отчество</th>
                <th scope="col">Должность</th>
                <th scope="col">Компания</th>
                <th scope="col">Дата рождения</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;
            $data_dolzh = array();
            foreach ($dataInp as $key=>$arr) {
                $data_dolzh[$key] = $arr['dolzh'];
            }
            array_multisort($data_dolzh, SORT_STRING, SORT_DESC, $dataInp);
            //dd($dataInp);?>
    <?php foreach ($dataInp as $key=>$data) { ?>
            <tr id="bbth<?=$i?>">
                <th scope="row">
                    <input class="switch-input" id="bth<?=$i?>" type="checkbox" name="sw<?=$i?>" onchange='doVis("bth<?=$i?>",
                                "bbth<?=$i?>", "fam<?=$i?>", "name<?=$i?>", "otch<?=$i?>", "dolzh<?=$i?>", "work<?=$i?>",
                                "date<?=$i?>");'></th>
                <th><?=$data['nameF']?>
                    <input type="hidden" id="fam<?=$i?>" name="fam[]" value="<?=$data['nameF']?>"></th>
                <th><?=$data['nameN']?>
                    <input type="hidden" id="name<?=$i?>" name="name[]" value="<?=$data['nameN']?>"></th>
                <th><?=$data['nameOt']?>
                    <input type="hidden" id="otch<?=$i?>" name="otch[]" value="<?=$data['nameOt']?>"></th>
                <th><?=$data['dolzh']?>
                    <input type="hidden" id="dolzh<?=$i?>" name="dolzh[]" value="<?=$data['dolzh']?>"></th>
                <th><?=$data['work']?>
                    <input type="hidden" id="work<?=$i?>" name="work[]" value="<?=$data['work']?>"></th>
                <th><?=date('d-m-Y', strtotime($data['date']))?>
                    <input type="hidden" id="date<?=$i?>" name="date[]" value="<?=date('d-m-Y', strtotime($data['date']))?>"></th>
            </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="#" class="btn btn-secondary" onClick="window.location.reload();">Отмена</a>
        </form>
</div>
</div>
@endsection
