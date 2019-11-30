<!DOCTYPE html>
<html lang="ru">

@php
    /* массив имен инпутов,
     * также используется JS функции подсчета выбранных фото
    */

    /** @var App\Models\Order $order */
    $names = ["mainPhoto", "altMainPhotos", "commonPhotos", "designChoice"];
    $countsForNames = [1, $order->portraits_count, $order->photo_common, 1];
@endphp
@php $textLink = basename($_SERVER['REQUEST_URI']) @endphp


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.8/css/mdb.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/fonts.css') }}" rel="stylesheet">

</head>
<body>

<div class="container">
    <div class="row">
        @if ($errors->any())
        <div class="alert alert-danger col-12">
            <h3 class="text-center">При заполнении формы были допущены ошибки: </h3>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="Probabo-inquit-sic-a">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 Mask justify-content-center text-center d-flex flex-center">
            <h1>{{ $order->name  }}</h1>
        </div>
    </div>

    <div class="row py-5">
        <div class="col-12 text-center">
            <h3 class="">Комментарий от менеджера</h3>
            <p class="This-is-a-big-one-a">{{$order->comment}}</p>
            <hr>
        </div>
    </div>

</div>

<div class="container pb-5">
    <div class="row pb-5">
        <div class="col-12 text-center">
            <h3>Инструкция</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-4 flex-center">

            <div class="row">
                <div class="col-12">
                    <div class="Background text-center flex-center d-flex">
                        <p class="Number">1</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-4 flex-center">
            <div class="Background text-center flex-center d-flex">
                <p class="Number">2</p>
            </div>
        </div>

        <div class="col-4 flex-center">
            <div class="Background text-center flex-center d-flex">
                <p class="Number">3</p>
            </div>
        </div>

        <div class="col-12">
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-12">
            <p class="Instruct-h">
                <span class="d-lg-none ">Этап 1: </span>
                Фотосессия
            </p>

            <p class="Probabo-inquit-sic-a">
                Просмотрите фотографии с фотосессии и выберите наиболее понравившееся.
            </p>

            <hr class="d-lg-none ">
        </div>

        <div class="col-lg-4 col-12">
            <p class="Instruct-h">
                <span class="d-lg-none ">Этап 2: </span>
                Выберите фотографии
            </p>

            <p class="Probabo-inquit-sic-a">
                Создайте пользователя и выберите фотографии, которые будут использоваться в альбоме.
            </p>

            <hr class="d-lg-none ">
        </div>

        <div class="col-lg-4 col-12">
            <p class="Instruct-h text-center">
                <span class="d-lg-none ">Этап 3: </span>Подтверждение заказа
            </p>

            <p class="Probabo-inquit-sic-a">
                У одного родителя имеется ключ подтверждения. После голосования родитель ключом подтверждает заказ.
            </p>

            <hr class="d-lg-none ">
        </div>
    </div>
</div>


<div class="container Mask flex-center mb-5">
    <div class="row w-100">
        <div class="col-lg-3 col-12 col-sm-12 col-xs-12 text-center m-lg-0 m-2">
            <h3>Фотосессия</h3>
        </div>

        <div class="col-lg-6 col-sm-12 col-12 m-lg-0 m-2">
            <div class="Link-bg text-center flex-center">
                <p><b>{{$order->photos_link}}</b></p>
            </div>
        </div>

        <div class="col-lg-3 col-12 col-sm-12 m-lg-0 m-2">
            <a href="{{$order->photos_link}}">
                <button class="Yellow-btn text-center flex-center text-white coolis overflow-hidden">
                    <span>Перейти</span>
                </button>
            </a>
        </div>
    </div>
</div>

<hr>

<div class="container Mask-round-only  pb-5">
    <div class="row justify-content-center py-3 pb-0">
        <div class="col-6">

            <div class="text-center">
                <h3>Выбор пользователей</h3>

            </div>

            <form action="{{ route('orders.client.choose', $textLink) }}" method="GET">
                <button type="submit" class="btn Yellow-btn coolis text-white w-100 overflow-hidden" style="border-radius: 20px;" >
                    <span>Сделать свой выбор</span>
                </button>
            </form>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col" class="text-center">Имя</th>
            <th scope="col" class="text-center">Просмотреть</th>
            <th scope="col" class="text-center">Удалить</th>
        </tr>
        </thead>

        <tbody>

        @php $count = 1; @endphp
        @foreach($users as $user)
            @php /** @var App\Models\Order $item */@endphp

            <tr>
                <th scope="row">{{$count}}</th>
                <td class="Table-text text-center">{{$user->name}}</td>
                <td>
                    <form method="GET" action="{{ route('orders.client.user.demo', [$textLink, $user->id]) }}">
                        <button type="submit" class="Blue-btn-table text-white text-">
                            <i class="fa fa-eye  px-2" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline">Просмотреть</span>
                        </button>
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{ route('orders.admin.user.destroy', $user->id) }}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="Yellow-btn-table btn-danger text-white"
                                onsubmit="return confirm('Вы уверены, что хотите удалить ВНИМАНИЕ! *{{ ($user->name)}}*' );" >
                            <i class="fa fa-trash px-2" aria-hidden="true"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @php $count++; @endphp
        @endforeach
        </tbody>

    </table>
</div>

<div class="container pb-5">
    <div class="row">
        <div class="col-12 text-center">
            <h3>Топ 3 дизайна по количеству голосов</h3>
            <hr>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-12 col-lg-3 my-2 Votes-rctg">
            <div class="row  justify-content-center mt-5">
                <div class="Orange-rctg text-white flex-center">
                    <p class="Percents">
                        @if( isset($designs[0]->c) )
                            {{ $designs[0]->c }}
                        @else
                            #
                        @endif
                    </p>
                </div>
            </div>

            <div class="row  justify-content-center py-3">
                <p class="Votes-text">
                    @if( isset( $designs[0]->design ) )
                        Дизайн {{ $designs[0]->design }}
                    @else
                        Еще не проголосовали
                    @endif

                </p>
            </div>
        </div>

        <div class="col-lg-1 my-2 d-md-none d-lg-block"></div>

        <div class="col-12 col-md-12 col-lg-3 my-2 Votes-rctg">
            <div class="row  justify-content-center mt-5">
                <div class="Orange-rctg Purple text-white flex-center">
                    <p class="Percents">
                        @if( isset($designs[1]->c ) )
                            {{ $designs[1]->c }}
                        @else
                            #
                        @endif
                    </p>
                </div>
            </div>

            <div class="row justify-content-center py-3">
                <p class="Votes-text">
                    @if( isset( $designs[1]->design ) )
                        Дизайн {{ $designs[1]->design }}
                    @else
                        Еще не проголосовали
                    @endif
                </p>
            </div>
        </div>

        <div class="col-lg-1 d-md-none d-lg-block"></div>

        <div class="col-12 col-md-12 col-lg-3 my-2 Votes-rctg">
            <div class="row  justify-content-center mt-5">
                <div class="Orange-rctg Blue text-white flex-center">
                    <p class="Percents">
                        @if( isset($designs[2]->c ) )
                            {{ $designs[2]->c }}
                        @else
                            #
                        @endif
                    </p>
                </div>
            </div>

            <div class="row  justify-content-center py-3">
                <p class="Votes-text">
                    @if( isset( $designs[2]->design ) )
                        Дизайн {{ $designs[2]->design }}
                    @else
                        Еще не проголосовали
                    @endif
                </p>
            </div>
        </div>

    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-12 text-center">
            <h3>FAQ/Инструкции</h3>
            <p class="Probabo-inquit-sic-a">
                Ответы на наиболее популярные вопросы и проблемы.
            </p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="accordion col-lg-10 col-12" id="accordionExample">
            <div class="card py-3">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link How-Long-Will-It-Tak" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            What is my Problem?
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body Probabo-inquit-sic-a text-left">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>

            <div class="card py-3">
                <div class="card-header" id="heading-2">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed How-Long-Will-It-Tak" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Is it hard to understand?
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="heading-2" data-parent="#accordionExample">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>

            <div class="card py-3">
                <div class="card-header" id="heading-3">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed  How-Long-Will-It-Tak" type="button" data-toggle="collapse" data-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                            Hmm....
                        </button>
                    </h5>
                </div>
                <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#accordionExample">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>

            <div class="card py-3">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed  How-Long-Will-It-Tak" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            What else?
                        </button>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{--<div class="modal fade" onblur="setName();setSurname();" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}

{{--    <div class="container-fluid">--}}

{{--        <button type="button" class="text-white align-self-center Back-Lg-btn d-none d-sm-none d-md-none d-lg-block modal-back">--}}
{{--            <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>--}}
{{--        </button>--}}

{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content Custom-modal">--}}

{{--                <div id="choiceDone" class="container-fluid flex-center" style="display: none;">--}}
{{--                    <div class="row d-flex">--}}
{{--                        <div class="col-12 text-center">--}}
{{--                            <i class="fa fa-check-circle" style="font-size: 5em; color: #82c91e;" aria-hidden="true"></i>--}}
{{--                        </div>--}}
{{--                        <div class="col-12 text-center">--}}
{{--                            <p class="Probabo-inquit-sic-a">Изображения выбраны, перейдите к следующему этапу</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                @php $textLink = basename($_SERVER['REQUEST_URI']) @endphp--}}
{{--                <form id="inputFormContent" method="POST" action="{{ route('orders.client.store') }}" autocomplete="off">--}}
{{--                            @csrf--}}

{{--                            <input type="hidden" name="textLink" class="d-none" value="{{  $textLink }}">--}}

{{--                            <!-- modal header!-->--}}
{{--                            <div class="modal-header py-1 justify-content-center container-fluid">--}}
{{--                                <div class="col-11 text-center justify-content-center">--}}

{{--                                    <div class="alert alert-success w-100 d-none">--}}
{{--                                        <h4 class="text-center font-weight-bold">--}}
{{--                                            Фотографии выбраны - можете продолжить--}}
{{--                                        </h4>--}}
{{--                                    </div>--}}

{{--                                    <ul class="nav nav-tabs" id="myTab" role="tablist">--}}

{{--                                        <li class="nav-item w-100 alert alert-info">--}}
{{--                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">--}}
{{--                                                <h4 class="text-center font-weight-bold">--}}
{{--                                                    Введите имя и фамилию--}}
{{--                                                </h4>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li class="nav-item w-100 alert alert-info" style="display: none">--}}
{{--                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">--}}
{{--                                                <h4 class="text-center font-weight-bold">--}}
{{--                                                    Выберите главное портретное фото--}}
{{--                                                </h4>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li class="nav-item w-100 alert alert-info" style="display: none">--}}
{{--                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">--}}
{{--                                                <h4 class="text-center font-weight-bold" style="font-size: 20px;">--}}
{{--                                                    Выберите {{ $order->portraits_count }} дополнительных портретных фото--}}
{{--                                                </h4>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}

{{--                                        <li class="nav-item w-100 alert alert-info" style="display: none">--}}
{{--                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#next" role="tab" aria-controls="contact" aria-selected="false">--}}
{{--                                                <h4 class="text-center font-weight-bold">--}}
{{--                                                    Выберите {{$order->photo_common}} фотографий в общий альбом--}}
{{--                                                </h4>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}

{{--                                        <li class="nav-item w-100 alert alert-info" style="display: none">--}}
{{--                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#designs" role="tab" aria-controls="contact" aria-selected="false">--}}
{{--                                                <h4 class="text-center font-weight-bold">--}}
{{--                                                    Выберите понравившейся дизайн--}}
{{--                                                </h4>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}

{{--                                        <li class="nav-item w-100 alert alert-info" style="display: none">--}}
{{--                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="contact" aria-selected="false">--}}
{{--                                                <h4 class="text-center font-weight-bold">--}}
{{--                                                    Загрузить фотографии?--}}
{{--                                                </h4>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}

{{--                                        <li class="nav-item w-100 alert alert-info" style="display: none">--}}
{{--                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#quastion" role="tab" aria-controls="contact" aria-selected="false">--}}
{{--                                                <h4 class="text-center font-weight-bold">--}}
{{--                                                    Ответьте на вопросы анкеты--}}
{{--                                                </h4>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}

{{--                                        <li class="nav-item w-100 alert alert-info" style="display: none">--}}
{{--                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#final" role="tab" aria-controls="contact" aria-selected="false">--}}
{{--                                                <h4 class="text-center font-weight-bold">--}}
{{--                                                    Сохранить выбор--}}
{{--                                                </h4>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}

{{--                                    --}}{{--     отображается если выбрано достаточное количество фотографий в разделе--}}
{{--                                    <div class="alert d-none">--}}
{{--                                        <div class="alert-success" id="">--}}
{{--                                            <h3 class="text-center"> Можете переходить к следующему выбору</h3>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="col-1 text-center d-flex flex-center align-self-center">--}}
{{--                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                        <i class="fa fa-window-close" aria-hidden="true"></i>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!-- modal body!-->--}}
{{--                            <div class="modal-body">--}}
{{--                                <div class="tab-content" id="myTabContent">--}}

{{--                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">--}}
{{--                                            <div class="form-group name-input">--}}
{{--                                                <input type="text" onchange="tmpName=this.value" name="userName" placeholder="Имя" class="form-control" id="recipient-name">--}}
{{--                                            </div>--}}

{{--                                            <div class="form-group name-input">--}}
{{--                                                <input placeholder="Фамилия" onchange="tmpSurname=this.value" name="userSurname" class="form-control" id="recipient-surname">--}}
{{--                                            </div>--}}

{{--                                            <div class="alert alert-danger">--}}
{{--                                                <h4 class="text-center font-weight-bold">--}}
{{--                                                    Внимание!<br>--}}
{{--                                                    Вводите имя точно так, как оно будет записано в альбом.--}}
{{--                                                    Буквы Е/Ё имеют разницу, не допускайте ошибок в написании имени и фамилии.--}}
{{--                                                </h4>--}}

{{--                                                <p class="text-center">--}}
{{--                                                    <u>Перепроверьте корректность имени и фамилии перед продолжением</u>--}}
{{--                                                </p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">--}}

{{--                                            <div class="container-fluid">--}}
{{--                                                <div class="row">--}}
{{--                                                    @for($i=0; $i<10;$i++)--}}
{{--                                                        <div class="col-6 nopad">--}}
{{--                                                            <label class="image-checkbox">--}}
{{--                                                                <img data-name="{{ $names[0] }}" src="{{ asset('storage/img/img.jpg') }}" width="100%" height="100%" class="pl-2 pb-2 img-responsive" alt="">--}}
{{--                                                                <input type="checkbox" name="{{$names[0] }}[{{$i}}]">--}}
{{--                                                                <i class="fa fa-check d-none"></i>--}}
{{--                                                            </label>--}}
{{--                                                        </div>--}}
{{--                                                    @endfor--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">--}}

{{--                                            <div class="container-fluid">--}}
{{--                                                <div class="row">--}}

{{--                                                    @for($i=0; $i<10;$i++)--}}

{{--                                                        <div class="col-6 nopad">--}}
{{--                                                            <label class="image-checkbox">--}}
{{--                                                                <img data-name="{{$names[1]}}" src="{{ asset('storage/img/img.jpg') }}" width="100%" height="100%" class="pl-2 pb-2 img-responsive" alt="">--}}
{{--                                                                <input type="checkbox" name="{{$names[1]}}[{{$i}}]" value="" />--}}
{{--                                                                <i class="fa fa-check d-none"></i>--}}
{{--                                                            </label>--}}
{{--                                                        </div>--}}

{{--                                                    @endfor--}}

{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}

{{--                                        <div class="tab-pane fade" id="next" role="tabpanel" aria-labelledby="profile-tab">--}}

{{--                                            <div class="container-fluid">--}}
{{--                                                <div class="row">--}}

{{--                                                    @for($i=0; $i<10;$i++)--}}
{{--                                                        <div class="col-6 nopad">--}}
{{--                                                            <label class="image-checkbox">--}}
{{--                                                                <img data-name="{{$names[2]}}" src="{{ asset('storage/img/img.jpg') }}" width="100%" height="100%" class="pl-2 pb-2 img-responsive" alt="">--}}
{{--                                                                <input type="checkbox" name="{{$names[2]}}[{{$i}}]" value="" />--}}
{{--                                                                <i class="fa fa-check d-none"></i>--}}
{{--                                                            </label>--}}
{{--                                                        </div>--}}

{{--                                                    @endfor--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="tab-pane fade" id="designs" role="tabpanel" aria-labelledby="profile-tab">--}}
{{--                                            <div class="container-fluid">--}}
{{--                                                <div class="row">--}}

{{--                                                    @for($i=0; $i<10;$i++)--}}

{{--                                                        <div class="col-6 nopad">--}}
{{--                                                            <label class="image-checkbox">--}}
{{--                                                                <img data-name="{{$names[3]}}" src="{{ asset('storage/img/img.jpg') }}" width="100%" height="100%" class="pl-2 pb-2 img-responsive" alt="">--}}
{{--                                                                <input type="checkbox" name="{{$names[3]}}[{{$i}}]" value="" />--}}
{{--                                                                <i class="fa fa-check d-none"></i>--}}
{{--                                                            </label>--}}
{{--                                                        </div>--}}

{{--                                                    @endfor--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="tab-pane fade flex-center" id="upload" role="tabpanel" aria-labelledby="profile-tab">--}}

{{--                                            <div>--}}
{{--                                                <div class="custom-file px-5">--}}
{{--                                                    <input type="file" name="userFiles[]" accept="image/jpeg,image/png" multiple class="custom-file-input" id="files" lang="ru">--}}
{{--                                                    <label for="customFileLang" class="custom-file-label">Загрузить фотографии</label>--}}
{{--                                                </div>--}}
{{--                                                <p class="Probabo-inquit-sic-a py-5"><u>Если файлы загружать не нужно - пропустите данный этап</u></p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="tab-pane fade flex-center" id="quastion" role="tabpanel" aria-labelledby="profile-tab">--}}
{{--                                            <div>--}}
{{--                                                <div class="text-area">--}}
{{--                                                    <p class="modal-text px-3 py-2">{{ 'php comment output' }}</p>--}}
{{--                                                </div>--}}

{{--                                                <div class="form-group">--}}
{{--                                                    <label for="comment">Ответ:</label>--}}
{{--                                                    <textarea name="userQuestionsAnswer" class="form-control" rows="5" id="comment"></textarea>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="tab-pane fade flex-center" id="final" role="tabpanel" aria-labelledby="profile-tab">--}}
{{--                                        <div class="flex-center">--}}
{{--                                            <button type="submit" class="btn Yellow-btn coolis text-white w-100 overflow-hidden" style="width: 50%;"><span>Подтвердить свой выбор</span></button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}

{{--                    <!-- modal footer-->--}}
{{--                    <div class="modal-footer w-100 d-lg-none py-5">--}}
{{--                        <div class="col-4">--}}
{{--                            <button type="button" class="btn Yellow-btn text-white modal-back">--}}
{{--                                <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>--}}
{{--                            </button>--}}
{{--                        </div>--}}

{{--                        <div class="col-4">--}}
{{--                        </div>--}}

{{--                        <div class="col-4">--}}
{{--                            <button type="button" class="btn Yellow-btn text-white modal-next">--}}
{{--                                <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>--}}
{{--                            </button>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--            </div>--}}
{{--        </div>--}}


{{--        <button type="button" class="text-white align-self-center Next-Lg-btn d-sm-none d-none d-md-none d-lg-block modal-next">--}}
{{--            <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>--}}
{{--        </button>--}}

{{--    </div>--}}

{{--</div>--}}




    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.8/js/mdb.min.js"></script>


    <script type="text/javascript">


        //------------------ back/next button functions

        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            //            modal.find('.modal-title').text('New message to ' + recipient)
            modal.find('.modal-body input').val(recipient)
        });

        $('.modal-next').click(function () {
            $('.nav-tabs').find('.active').parent().next('li').find('a').trigger('click');
            hideNotActive();
            hideChoiceComplete();
        });

        $('.modal-back').click(function () {
            $('.nav-tabs .active').parent().prev('li').find('a').trigger('click');
            hideNotActive();
            hideChoiceComplete();
        });

        function hideNotActive() {
            $('.nav-link').parent().hide();
            $(' .nav-link.active').parent().show();
        }

        // если пользователь закрыл модальное окно - input не должны забывать ФИО
        let tmpName="";
        let tmpSurname="";
        function setName(){
            document.getElementById('recipient-name').value = tmpName;
        }

        function setSurname(){
            document.getElementById('recipient-surname').value = tmpSurname;
        }


        //---------------- image gallery functions----------

        // init the state from the input
        $(".image-checkbox").each(function () {
            if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
                $(this).addClass('image-checkbox-checked');
            } else {
                $(this).removeClass('image-checkbox-checked');
            }
        });

        // sync the state to the input
        $(".image-checkbox").on("click", function (e) {
            $(this).toggleClass('image-checkbox-checked');
            var $checkbox = $(this).find('input[type="checkbox"]');
            $checkbox.prop("checked", !$checkbox.prop("checked"));

           var dataNameString= $(this).find('img').attr('data-name');
            //Если изображение выбрано -> отнимаем от максимума, иначе возвращаем
            $checkbox.prop("checked") ? countImgInput('-', dataNameString): countImgInput('+', dataNameString);

            e.preventDefault();
        });

        //$names - PHP массив с именами для всех инпутов
        //$countsForNames - ограничители для каждого выбора
        //создаем объект, чтобы JS передавал значения переменных по ссылкам
        var names = {
            {{$names[0]}}Count : {{$countsForNames[0]}},
            {{$names[1]}}Count  : {{$countsForNames[1]}},
            {{$names[2]}}Count : {{$countsForNames[2]}},
            {{$names[3]}}Count : {{$countsForNames[3]}}
        };

        //Ищет от какой именно секции пришел запрос
        //Изображения отличаются в атрибуте "data-name",
        // по нему отличаем секции выбора
        function countImgInput( mathAction, nameString) {
            switch (nameString)
            {
                case '{{$names[0]}}':
                    names.{{$names[0]}}Count += mathAction==="+" ? 1 : -1;
                    showChoiceComplete(names.{{$names[0]}}Count);
                    break;

                case '{{$names[1]}}':
                    names.{{$names[1]}}Count += mathAction==="+" ? 1 : -1;
                    showChoiceComplete(names.{{$names[1]}}Count);
                    break;

                case '{{$names[2]}}':
                    names.{{$names[2]}}Count += mathAction==="+" ? 1 : -1;
                    showChoiceComplete(names.{{$names[2]}}Count);
                    break;

                case '{{$names[3]}}':
                    names.{{$names[3]}}Count += mathAction==="+" ? 1 : -1;
                    showChoiceComplete(names.{{$names[3]}}Count);
                    break;
            }
        }

        //Внимание! При выборе картинки мы от максимума отнимаем один, при отмене выбора добавляем
        //Поэтому вывод достигается при countVar==0
        function showChoiceComplete(countVar){
            console.log(countVar);
            if(countVar===0){
                $("#inputFormContent").fadeOut(50);
                $("#choiceDone").fadeIn(50);
            }
        }

        function hideChoiceComplete(){
            $("#choiceDone").hide();
            $("#inputFormContent").show();
        }


        //-----------------------Files------------------------------------
        //multiply input file upload
        $('input#files').change(function(){
            var files = this.files; //это массив файлов
            var form = new FormData();
            for(var i=0;i<files.length;i++){
                form.append("file["+i+"]", files[i]);
            }
        });

        //-----------------------------------------------------
        function confirmDelete(){
            return confirm("Вы уверены, что хотите удалить пользователя");
        }

    </script>

</body>

</html>
