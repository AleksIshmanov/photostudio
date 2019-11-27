@php

    function getDesignName($textLink) {
        //Получим имя файла из его полной ссылки
        $designName = explode('/', $textLink);
        $designName = array_pop($designName);

        //удаляем расширение файла
        $designName =  preg_replace('/.(?:jpg|png|gif)$/i', '', $designName);
        return $designName;
    }
@endphp


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Демонстрация</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.8/css/mdb.min.css" rel="stylesheet">--}}

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/fonts.css') }}" rel="stylesheet">
</head>
<body>

<section id="commonSection" class="container">
    <div class="row">
        <div class="col-12 Mask justify-content-center text-center d-flex flex-center">
            <h1 class="align-self-center">{{ $user->name  }}</h1>
        </div>
    </div>

    <div class="row pt-5">
        <div class="col-12 text-center">
            <h3>Выбранные общие фотографии</h3>
            <hr>
        </div>
    </div>

    <div class="row justify-content-center">
        @foreach ($groupsPhoto as $link)
            <div class="col-6 col-lg-3 nopad text-center">
                <img src="{{ $link }}" width="100%" height="100%" class="pl-2 pb-2 img-responsive" alt="">
            </div>
        @endforeach
    </div>
</section>


<section id="portraitSection" class="container  py-5">
    <div class="row">
        <div class="col-12 text-center">
            <h3>Выбранные портретные фотографии</h3>
            <hr>
        </div>
    </div>

    <div class="row justify-content-center">
        @php $blockSize = 12 / count($portraitsPhoto); @endphp
        @foreach ($portraitsPhoto as $link)
            <div class="col-6 col-lg-3 nopad text-center">
                <img src="{{ $link }}" width="100%" height="100%" class="pl-2 pb-2 img-responsive" alt="">
            </div>
        @endforeach
    </div>
</section>

<section class="container ">

    <div class="row">
        <div class="col-12 text-center">
            <h3>Выбранные Варианты дизайна</h3>
            <hr>
        </div>
    </div>

    @foreach($designs as $designName=>$photoUrlArray)
        <div class="row py-2">
            <div class="card">
                <h3 class="card-header text-center"> Дизайн #{{ $designName }}</h3>
                <div class="card-body row">
                    @php $blockSize = 12 / count($photoUrlArray); @endphp
                    @foreach($photoUrlArray as $photoUrl)
                        <div class="col-lg-{{ $blockSize }} col-12">
                            <img src="{{ $photoUrl }}" width="100%" height="100%" alt="{{ $designName }} photo" class="border border-dark rounded">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</section>

</body>
</html>
