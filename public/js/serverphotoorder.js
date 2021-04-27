//Скрыть блок кнопок при нажатии на Загрузить
document.getElementById('formBtn').onclick = function() {
    let btnBlock = document.getElementById('btnBlock');
    btnBlock.classList.add('hide');
}

//Показать блок кнопок при нажатии на input=file
document.getElementById('file').onclick = function() {
    let btnBlock = document.getElementById('btnBlock');
    btnBlock.classList.remove('hide');
}

//Получить значение View и обновить данные при смене типа
document.getElementById('chngView').onchange = function(ev) {
    var location = window.location.origin;
    let target = ev.target;
    const selView = target.options[target.selectedIndex].value;

    let request = new XMLHttpRequest();
    request.open('GET', location + '/api/serverimg/' + selView, false);
    request.send();
    // console.warn(request.responseText);

    let arrResp = JSON.parse(request.responseText);
    const countPhoto = parseInt(arrResp.count);

    const letterBlock = document.getElementById('form_block')
    letterBlock.innerText = selView;
    const countBlock = letterBlock.nextElementSibling;
    countBlock.innerText = countPhoto;
    arrImgs = arrResp.imgs.map(function(index) {
        return '<img src="'+location+'/img/server/'+index.path+
            '" width="80" class="serverform-top-pic__img">';
    });
    document.getElementById('imgsBlock').innerHTML = arrImgs.join(' ');
}