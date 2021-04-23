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
    let target = ev.target;
    let selView = target.options[target.selectedIndex].value;

    const location = window.location.origin;
    let request = new XMLHttpRequest();
    request.open('GET', location + '/serverimg/' + selView, false);
    request.send();
    console.log(request.responseText);
    let arrResp = JSON.parse(request.responseText);
    console.log(arrResp);
}