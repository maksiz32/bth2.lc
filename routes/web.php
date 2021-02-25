<?php
Route::get('/login', function () {
    return view('auth.login');
});

// Authentication Routes...
Route::get('login', [
  'as' => 'login',
  'uses' => 'Auth\LoginController@showLoginForm'
]);
Route::post('login', [
  'as' => '',
  'uses' => 'Auth\LoginController@login'
]);
Route::post('logout', [
  'as' => 'logout',
  'uses' => 'Auth\LoginController@logout'
]);

// Password Reset Routes...
Route::post('password/email', [
  'as' => 'password.email',
  'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('password/reset', [
  'as' => 'password.request',
  'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/reset', [
  'as' => '',
  'uses' => 'Auth\ResetPasswordController@reset'
]);
Route::get('password/reset/{token}', [
  'as' => 'password.reset',
  'uses' => 'Auth\ResetPasswordController@showResetForm'
]);

// Registration Routes...
Route::get('register', [
  'as' => 'register',
  'uses' => 'Auth\RegisterController@showRegistrationForm'
]);
Route::post('register', [
  'as' => '',
  'uses' => 'Auth\RegisterController@register'
]);

//Блок для БД пользователей для Дней Рождения
Route::get('user/{id}', 'Auth\RegisterController@edit');
Route::match(["post", "put"], '/saveone', 'Auth\RegisterController@saveOne');
Route::get('/allusers', 'Auth\RegisterController@allUsers');
Route::get('/pass/{id}', 'Auth\RegisterController@chPass');
Route::post('/user/credentials', 'Auth\RegisterController@postCredentials');
Route::get('/delusr/{id}', 'Auth\RegisterController@delete');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/admin', 'HomeController@menuBth');
Route::get('/nogroup', 'HomeController@noGroupAccess');

//Здесь контроллер одного действия. Использую __invoke в контроллере
Route::get('/all', 'AllController');
Route::get('/all/{mounth}', 'AllController');

//Здесь контроллер одного действия. Использую __invoke в контроллере
Route::get('/passwords', 'GeneratePasswordsController');

//Контроллер одного действия через invoke для определения и выдачи ip-адреса клиента
Route::get('/myip', 'MyipController');
//Контроллер для работы со шрифтами
Route::get('/myfonts', 'FontsController');

//Контроллер для работы с фотоальбомами
Route::get('/photo_album', 'AlbumController@allphotos');
Route::get('/new_album/{id?}', 'AlbumController@editPhotoAlbum');
//Не будет удаления Альбома - только через его сокрытие Route::get('/del_album/{id}', 'AlbumController@delPhotoAlbum');
Route::match(["post", "put"], '/photoAlbum/save', 'AlbumController@savePhotoAlbum');
Route::get('/album/{id}/{countPhotosOnPage?}/{page?}', 'AlbumController@album');
Route::get('/input-photo/{id}', 'AlbumController@addInAlbum');
Route::match(["post", "put"], '/photo/save', 'AlbumController@savePhotos');
Route::get('/delphoto/{id}/{countPhotosOnPage?}/{page?}', 'AlbumController@deletePhoto');
Route::get('/action-photo/{action}/{id}/{num?}/{countPhotosOnPage?}/{page?}', 'AlbumController@actionPhoto');
Route::get('/watermark/{id}/{countPhotosOnPage?}/{page?}', 'AlbumController@watermark');

//Контроллер для работы с видеоальбомами
Route::get('/all_video', 'AlbumController@video');
Route::get('/new_video/{id?}', 'AlbumController@inputVideo');
Route::match(["post", "put"], '/video/save', 'AlbumController@saveVideo');
Route::get('/del_video/{id}', 'AlbumController@deleteVideo');
Route::post('/svideo', 'AlbumController@searchVideo');
//Route::get('/sql/{id}', 'AlbumController@goSQL');//Временный метод для переноса данных из старых альбомов, которые были без использования БД

Route::get('/order', 'OrderController@index');
Route::match(["post", "put"], '/order/do', 'OrderController@store');
Route::get('/ord-rep', 'OrderController@viewRep');
Route::get('/byfirm', 'OrderController@byFirm');
Route::get('/bydate', 'OrderController@byDate');
Route::get('/bytech', 'OrderController@byTech');
Route::match(["post", "get"],'/order/bf/{what}', 'OrderController@getByFirm');
//Route::get('/order/send', 'OrderController@sendmail');

Route::resource('/firms', 'FirmController', ['except' => ['update', 'edit', 'show']]);
Route::get('/firms/{id}/edit', 'FirmController@create');
Route::match(["post", "put"], '/firms', 'FirmController@store');
Route::get('/firms/all', 'FirmController@all');
Route::get('/firms/no-all', 'FirmController@noall');

//Контроллер для операций с техникой и заказами расходников
Route::resource('/tech', 'TechController', ['except' => ['update', 'edit', 'show']]);
Route::get('/tech/{id}/edit', 'TechController@create');
Route::match(["post", "put"], '/tech', 'TechController@store');
Route::get('/category', 'TechController@viewCategory');
Route::get('/category/{id?}', 'TechController@makeCategory');

Route::get('/links', 'LinkController@links');
Route::get('/new_link', 'LinkController@new_link');
Route::get('/new_link/{id}', 'LinkController@edit_link');
Route::match(["post", "put"], "/saveLink", "LinkController@save");
Route::get('/del_link/{id}', 'LinkController@delete');
//Все это можно заменить 
//Route::resource('links', 'LinkController');
//Или
//Route::resource('links', 'LinkController', ['only' => ['index', 'show', 'create', 'edit', 'destroy']]);
//Или
//Route::resource('links', 'LinkController', ['except' => ['store', 'update']]);

Route::get('/email', 'AddrEmailController@index');
Route::get('/mail', 'AddrEmailController@main');
Route::match(["post", "put"], "/chmail", "AddrEmailController@save")->name("chmail");
Route::get("/mail/edit/{id}", "AddrEmailController@edit");
Route::get("/mail/delete/{id}", 'AddrEmailController@delete');
Route::match(["post", "put"], "/mail/saveMail", "AddrEmailController@saveNew");

Route::get('/import', 'InputController@import');
Route::get('/edit/{id}', 'InputController@editOne');
Route::post('/importExcel', 'InputController@importExcel');
Route::match(["post", "put"], "/inp", "InputController@save");
Route::match(["post", "put"], "/saveMe", "InputController@saveOne");
Route::get('/go/{id}', 'InputController@goPDF');
Route::get('/sm/{id}', 'InputController@sendmail');
Route::get('/del/{id}', 'InputController@delOne');
Route::match(["post", "put"], '/input', 'InputController@inputOne');
Route::post('/search', 'InputController@search');

//Route::get('/yes', 'InputController@yes');

//Контроллер для внутренних нужд
Route::get('/skk', 'MySystemController@skk');
Route::get('/namenew', 'MySystemController@innewbase');
Route::get('/test', 'MySystemController@test');
Route::get('/arm', function () {
    return view('mysystemutil.arm');
});

//Контроллер для работы с записями ActiveDirectory
//Route::get('/adldapt', 'AdWorkController@adldapt');
Route::get('/ad', 'AdWorkController@adldapView');
Route::match(["get", "post", "put"], '/adlist', 'AdWorkController@adViewEdit');
Route::match(["get", "post", "put"], '/admod', 'AdWorkController@adModify');

//Контроллер для работы с изображениями (resize)
Route::get('/image', 'ImageController@input');
Route::match(['post', 'get'], '/resize', 'ImageController@resize');

//Контроллер заявок на автомобиль
Route::get('/car/create/{date?}', 'CarController@inputBook');
Route::match(['post', 'put'], '/avto/plusAvto', 'CarController@saveAvto');
Route::post('/car/plusBooking', 'CarController@saveBook');
Route::get('/avto/{id?}', 'CarController@inputAvto');
Route::get('/carMounth/{dateMain?}', 'CarController@allByMounth');
Route::get('/car/{dateMain?}', 'CarController@main');
Route::get('/car/{id}/delete', 'CarController@delete');

//Контроллер регулирования доступа к разделам по ip-адресам
Route::get('/caraccess/', 'AccessIpController@index');
Route::post('/caraccess/enable', 'AccessIpController@save');
Route::get('/caraccess/{id}/disable', 'AccessIpController@destroy');

//Контроллер для Базы Знаний ИТ
Route::get('/wiki', 'WikiController@main');
Route::get('/wiki/{id}', 'WikiController@wikiOne');
Route::get('/wikisys/{id?}', 'WikiController@viewSys');
Route::get('/wikisystems/{id}', 'WikiController@systemOne');
Route::match(['post', 'put'], '/wikiSystemIn', 'WikiController@inputSys');
Route::get('/wikiwik/{id?}', 'WikiController@viewWiki');
Route::get('/wikiwik/{id}/del', 'WikiController@delFile');
Route::match(['post', 'put'], '/wikiWikIn', 'WikiController@inputWiki');
Route::post('/wikisearch', 'WikiController@search');

