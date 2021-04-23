@extends('layouts.app')
@section('title', "Дополнительное меню")
@section('content')
<div class="container">
    @if(RGSPortal::isADAdmin(getenv('REMOTE_USER')))
    <div class="row justify-content-md-center">
        <div class="col-md-12 card text-white bg-primary m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">База знаний ИТ</h5>
                <p class="card-text">Раздел виден и доступен только тем, чья группа AD наследуется от Regional Admins.</p>
                <p><a href="/wiki" class="btn btn-light stretched-link">Перейти</a>
                </p>
                <a href="/wikisys" class="btn btn-light stretched-link">Создать раздел</a>
                <a href="/wikiwik" class="btn btn-light stretched-link">Создать запись в Базе Знаний</a>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-12 card text-white bg-secondary m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Картриджи и остатки</h5>
                <p class="card-text">Раздел виден и доступен только тем, чья группа AD наследуется от Regional Admins.</p>
                <p>
                    <a href="/rem" class="btn btn-light stretched-link">Bвод/редактирование остатков расходников</a>
                </p>
                <p>
                    <a href="/category" class="btn btn-light stretched-link">Создать Категорию Оргтехники</a>
                </p>
                <p>
                    <a href="/admin/suborder" class="btn btn-light stretched-link">Просмотр всех заказов</a>
                </p>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-12 card text-white bg-success m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Отчет "Фотки серверной"</h5>
                <p class="card-text">Раздел виден и доступен только тем, чья группа AD наследуется от Regional Admins.</p>
                <p>
                    <a href="/inputserv" class="btn btn-light stretched-link">Добавить и просмотреть фотки для отчета</a>
                </p>
                <p>
                    <a href="#" class="btn btn-light stretched-link">Ручная отправка отчета</a>
                </p>
            </div>
        </div>
    </div>
    @endif
    @if(RGSPortal::isAdmin(getenv('REMOTE_USER')))
    <div class="row justify-content-md-center">
        <div class="col-md-3 card text-white bg-warning m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Все необходимые ссылки на ресурсы Компании</h5>
                <p class="card-text">Создание, изменение и удаление ссылок.</p>
                <a href="/links" class="btn btn-light stretched-link">Перейти</a>
            </div>
        </div>
        <div class="col-md-3 card text-white bg-success m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Отчеты по заказанным расходным материалам</h5>
                <p class="card-text">Выгрузка по отделу, по дате, по моделе.</p>
                <a href="/ord-rep" class="btn btn-light stretched-link">Перейти</a>
            </div>
        </div>
        <div class="col-md-3 card text-white bg-primary m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Страница загрузки и ввода именинников</h5>
                <p class="card-text">Загрузить файл-эксель или ввести вручную.</p>
                <a href="/import" class="btn btn-light stretched-link">Перейти</a>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-3 card text-white bg-secondary m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Именинники. Просмотр, редактирование и отправка поздравления</h5>
                <p class="card-text">Все для поздравления. ИЗМЕНЕНИЕ АДРЕСА РАССЫЛКИ.</p>
                <a href="/all" class="btn btn-light stretched-link">Перейти</a>
            </div>
        </div>
        <div class="col-md-3 card text-white bg-info m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Техника для Заказа Картриджей</h5>
                <p class="card-text">Создать, изменить или удалить оборудование.</p>
                <a href="/tech" class="btn btn-light stretched-link">Перейти</a>
            </div>
        </div>
        <div class="col-md-3 card text-white bg-danger m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Подразделения Филиала</h5>
                <p class="card-text">Создать, изменить или удалить подразделения.</p>
                <a href="/firms" class="btn btn-light stretched-link">Перейти</a>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-5 card text-white bg-warning m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Все для раздела бронирования автомобиля</h5>
                <p class="card-text">Инструменты редактирования.</p>
                <a href="/avto" class="btn btn-light stretched-link mb-2">Добавить/ Изменить авто и водителя</a>
                <a href="/mail" class="btn btn-light stretched-link mb-2">Добавить/ Изменить mail'ы для оповещения</a>
                <a href="/carMounth" class="btn btn-light stretched-link mb-2">Изменить/ Удалить заявки</a>
                <a href="/caraccess" class="btn btn-light stretched-link mb-2 btn-sm">Добавить/ Изменить доступ подразделений к заявкам на авто</a>
            </div>
        </div>
        <div class="col-md-5 card text-white bg-success m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Active Directory</h5>
                <p class="card-text">Инструменты AD.</p>
                <a href="/ad" class="btn btn-light stretched-link mb-2">Записи для подписей почты</a>
            </div>
        </div>
    </div>
    @elseif(RGSPortal::isEditor(getenv('REMOTE_USER')))
    <div class="row justify-content-md-center">
        <div class="col-md-5 card text-white bg-warning m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Все необходимые ссылки на ресурсы Компании</h5>
                <p class="card-text">Создание, изменение и удаление ссылок.</p>
                <a href="/links" class="btn btn-light stretched-link">Перейти</a>
            </div>
        </div>
        <div class="col-md-5 card text-white bg-secondary m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Именинники. Просмотр, редактирование и отправка поздравления</h5>
                <p class="card-text">Все для поздравления. ИЗМЕНЕНИЕ АДРЕСА РАССЫЛКИ.</p>
                <a href="/all" class="btn btn-light stretched-link">Перейти</a>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-5 card text-white bg-danger m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Подразделения Филиала</h5>
                <p class="card-text">Создать, изменить или удалить подразделения.</p>
                <a href="/firms" class="btn btn-light stretched-link">Перейти</a>
            </div>
        </div>
        <div class="col-md-5 card text-white bg-warning m-3 text-center" id="adminka">
            <div class="card-body">
                <h5 class="card-title">Все для раздела бронирования автомобиля</h5>
                <p class="card-text">Инструменты редактирования.</p>
                <a href="/avto" class="btn btn-light stretched-link mb-2">Добавить/ Изменить авто и водителя</a>
                <a href="/carMounth" class="btn btn-light stretched-link mb-2">Просмотр заявок на месяц</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
