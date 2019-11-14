<?php
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Choose</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

{{--<nav class="nav nav-pills nav-justified">--}}
{{--    <a class="nav-item nav-link active" href="#">Active</a>--}}
{{--    <a class="nav-item nav-link" href="#">Link</a>--}}
{{--    <a class="nav-item nav-link" href="#">Link</a>--}}
{{--    <a class="nav-item nav-link disabled" href="#">Disabled</a>--}}
{{--</nav>--}}


<ul class="nav nav-pills nav-justified" id="myTab" role="tablist">
    <li class="nav-item w-100 alert alert-info">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
            <h4 class="text-center font-weight-bold">
                Введите имя и фамилию
            </h4>
        </a>
    </li>
    <li class="nav-item w-100 alert alert-info" style="display: none">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
            <h4 class="text-center font-weight-bold">
                Выберите главное портретное фото
            </h4>
        </a>
    </li>
    <li class="nav-item w-100 alert alert-info" style="display: none">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
            <h4 class="text-center font-weight-bold" style="font-size: 20px;">
                Выберите {{ $order->portraits_count }} дополнительных портретных фото
            </h4>
        </a>
    </li>

    <li class="nav-item w-100 alert alert-info" style="display: none">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#next" role="tab" aria-controls="contact" aria-selected="false">
            <h4 class="text-center font-weight-bold">
                Выберите {{$order->photo_common}} фотографий в общий альбом
            </h4>
        </a>
    </li>

    <li class="nav-item w-100 alert alert-info" style="display: none">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#designs" role="tab" aria-controls="contact" aria-selected="false">
            <h4 class="text-center font-weight-bold">
                Выберите понравившейся дизайн
            </h4>
        </a>
    </li>

    <li class="nav-item w-100 alert alert-info" style="display: none">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="contact" aria-selected="false">
            <h4 class="text-center font-weight-bold">
                Загрузить фотографии?
            </h4>
        </a>
    </li>

    <li class="nav-item w-100 alert alert-info" style="display: none">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#quastion" role="tab" aria-controls="contact" aria-selected="false">
            <h4 class="text-center font-weight-bold">
                Ответьте на вопросы анкеты
            </h4>
        </a>
    </li>

    <li class="nav-item w-100 alert alert-info" style="display: none">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#final" role="tab" aria-controls="contact" aria-selected="false">
            <h4 class="text-center font-weight-bold">
                Сохранить выбор
            </h4>
        </a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
</div>

</body>
</html>

{{--    @foreach ($portraitsPhoto as $link)--}}
{{--        string with links from Yandex Disk --}}

{{--    @endforeach--}}
