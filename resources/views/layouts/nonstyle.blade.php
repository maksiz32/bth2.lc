<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" /> <!-- Решило проблему IE с отображением в режиме совместимости без CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack("meta")
    <meta name="author" content="Maksim Manzulin">
    <meta name="keywords" content='Локальный портал - Филиал ПАО СК "РОСГОССТРАХ" в Брянской области'>
    <meta name="description" content='Локальный портал - Филиал ПАО СК "РОСГОССТРАХ" в Брянской области'>
    <meta name="robots" content="all">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    @stack("headup")
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.js') }}"></script>
    @stack("head")

    <title>@yield("title")</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-default navbar-mobile bootsnav fixed-top navbar-expand-lg navbar-light bg-light top-red">
            <a class="navbar-brand text-danger d-none d-md-block" href="/">
                <h1>
                    <img class="logo h60 d-inline-block align-top" src="{{asset('/img/orel.png')}}">
                    <span class="AktivGroteskCorp6 color_rgs" style="font-size: 1.3em;"><strong>РОСГОССТРАХ</strong></span>
                </h1>
            </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
        <div class="navbar-nav">
        <?php $p = request()->path(); ?>
            <ul class="nav justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Инструменты</a>
                    <div class="dropdown-menu">
                        <?php /*
                        @if(RGSPortal::canBookingCar(getenv('REMOTE_ADDR')))
                        */ ?>
                        <a href="/car" class="nav-link dropdown-item ">Заявка на автомобиль</a>
                        <?php /*
                        @endif
                        */ ?>
                        <a href="/order" class="nav-link dropdown-item ">Заказ картриджей</a>
                        <a href="/image" class="nav-link dropdown-item ">Изменить размер изображений</a>
                        <a href="/links" class="nav-link dropdown-item ">Полезные ссылки</a>
                        <a class="nav-link dropdown-item" href="/all">Дни Рождения</a>
                        <a href="/firms" class="nav-link dropdown-item ">Подразделения Филиала</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Альбомы</a>
                    <div class="dropdown-menu">
                        <a class="nav-link dropdown-item" href="/photo_album">Фотоальбомы</a>
                    <div class="dropdown-divider"></div>
                        <a class="nav-link dropdown-item" href="/all_video">Видеоальбомы</a>
                    </div>
                </li>
                
                <li class="nav-link">
                        <?php
                        /*
                        if (session()->has('aduser')) {
                            $userName = session()->get('aduser');
                            $userPhotoTh = session()->get('adphoto');
                        } else {
                        $userName = getenv('REMOTE_USER');
                        $userRealName = Adldap::search()->users()->where('samaccountname', '=', $userName)->first();
                        $userNameTMP = explode(" ", $userRealName['cn'][0]);
                        $userName = "(" . $userNameTMP[0] . " " . $userNameTMP[1] . ")";
                        $userPhotoTh = $userRealName->getThumbnailEncoded();
                        $adGroups = $userRealName->getGroupNames($recursive = true);
                        session(['aduser' => $userName,
                                'adphoto' => $userPhotoTh,
                                'roles' => $adGroups]);
                        }*/
                        ?>
                    {{ RGSPortal::getName(getenv('REMOTE_USER')) . " " }}
                </li>
                <li class="nav-link">
                    @if($userPhotoTh = RGSPortal::getTumb(getenv('REMOTE_USER')))
                    <img class="h60" src="{{ $userPhotoTh }}">
                    @endif
                </li>
                
                <!-- Authentication Links -->
                <!--
                @if (Auth::guest())
                <li><a href="{{ route('login') }}" class="nav-link ">Login</a></li>
                @else
                <li>
                    <a class="nav-link " href="{{ route('logout') }}" 
                       onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                        Logout ({{ Auth::user()->name }})
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
                @endif
                -->
                @if(RGSPortal::isEditor(getenv('REMOTE_USER')) || RGSPortal::isADAdmin(getenv('REMOTE_USER')))
                    <li><a href="/admin" class="nav-link ">Админка</a></li>
                @endif
            </ul>
        </div>
  </div>
</nav>
    </header>
    <section>
        @yield('content')
    </section>
    <footer class="footer">
      <div class="container-fluid">
          <div class="row">
              <div class="col-lg-4">
                  <span class="text-muted">
                      <strong>Филиал ПАО СК "РОСГОССТРАХ" в Брянской области</strong>
                  </span>
                      <p>
                  <span class="text-muted">
                      241007, г. Брянск, ул. 3-го Июля, д. 27
                  </span>
                      </p>
                      <span class="text-muted">
                      <b>E-mail:</b> <a href="mailto:maksim_manzulinGAVbryansk.rgsDDOTru" onclick="this.href=this.href.replace(/GAV/,'@').replace(/DDOT/,'.')">Написать нам на email</a>
                      </span>
                  <br/><br/>
              </div>
              <div class="col-lg-4">
                  <span class="text-muted"><strong>Полезные ссылки:</strong>
                      <br />
                      <a href="/passwords">
                      Сгенерировать пароль
                      </a>
                      <br />
                      <a href="/myip">
                      Узнать свой IP-адрес
                      </a>
                      <br />
                      <a href="https://rgs.alpinadigital.ru/">
                      Электронная библиотека Росгосстраха
                      </a>
                      <br />
                      @if(RGSPortal::isAdmin(getenv('REMOTE_USER')))
                      <a href="/myfonts">
                      Загруженные шрифты
                      </a>
                      <br />
                      @endif
                      <a href="https://td.rgs.ru">
                      Портал Обучения
                      </a>
                      <br />
                      <a href="https://rgs.virtusystems.ru/login.aspx">
                      ВИРТУ
                      </a>
                  </span>
              </div>
              <div class="col-lg-4">
                  <span class="text-muted">
                      <strong>Юридический адрес:</strong>
                  </span>
                      <p>
                  <span class="text-muted">
                    140002, Российская Федерация, Московская область, Люберецкий район, г. Люберцы, ул. Парковая, д. 3
                  </span>
                          <br/><br/>
                  <?php
                  $start_Year = "2017";
                  $this_Year = date('Y');
                  if ($start_Year == $this_Year) {
                      $years = $start_Year;
                  } else {
                      $years = "{$start_Year} - {$this_Year}";
                      }
                      ?>
              </div>
                      <div class="col-lg-12 align-items-center text-center">
                  <span class="text-muted Celestina" style="font-size: 1.8em;">
                      <small>
                          Локальный Портал Брянской области&nbsp;&nbsp; &copy; &nbsp;&nbsp;<?=$years?>
                      </small>
                  </span>
                      </div>
          </div>
      </div>
    </footer>
</body>
</html>
