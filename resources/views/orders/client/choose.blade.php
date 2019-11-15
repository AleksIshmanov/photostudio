@php

    /** @var App\Models\Order $order */
    $names = ["mainPhoto", "altMainPhotos", "commonPhotos", "designChoice"]; //массив названий фото, используется в input для определения фото
    $countsForNames = [1, $order->portraits_count, $order->photo_common, 1]; //применяется в JS для подсчета количества выбранных
@endphp

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

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/fonts.css') }}" rel="stylesheet">
</head>
<body>

<ul class="nav nav-tabs nav-justified navbar navbar-dark bg-dark" id="myTab" role="tablist">
    <li class="nav-item">
        <a class=" nav-link active font-weight-bold" id="pills-home-tab" data-toggle="tab" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                Введите имя и фамилию
        </a>
    </li>

    <li class="nav-item">
        <a class=" nav-link font-weight-bold" id="pills-portraits-tab" data-toggle="tab" href="#pills-portraits" role="tab" aria-controls="pills-portraits" aria-selected="true">
            Портретные фото
        </a>
    </li>

    <li class="nav-item">
        <a class=" nav-link font-weight-bold" id="groups-tab" data-toggle="tab" href="#groups" role="tab" aria-controls="pills-groups" aria-selected="true">
            Общие фото
        </a>
    </li>

    <li class="nav-item">
        <a class=" nav-link font-weight-bold" id="design-tab" data-toggle="tab" href="#designs" role="tab" aria-controls="home" aria-selected="true">
            Дизайн
        </a>
    </li>

    <li class="nav-item">
        <a class=" nav-link font-weight-bold" id="anket-tab" data-toggle="tab" href="#anket" role="tab" aria-controls="home" aria-selected="true">
            Анкета
        </a>
    </li>
</ul>

<div class=" py-5">
    <div class="tab-content">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="row justify-content-center">
                <div class="form-group name-input col-12 col-lg-7 ">
                    <input type="text" onchange="tmpName=this.value" name="userName" placeholder="Имя" class="form-control" id="recipient-name">
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="form-group name-input col-12 col-lg-7">
                    <input placeholder="Фамилия" onchange="tmpSurname=this.value" name="userSurname" class="form-control" id="recipient-surname">
                </div>
            </div>

            <div class="row py-3 justify-content-center">
                <div class="col-lg-7 col-12">
                    <div class="card">
                        <div class="card-header alert-danger text-center">
                            <h3>Внимание!</h3>
                        </div>

                        <div class="card-body">
                            <h5>
                                <ul class="fa-ul">
                                    <li><i class="fa fa-li fa-check-circle text-warning"></i> Вводите имя в точности, каким оно будет в альбоме</li>
                                    <li><i class="fa fa-li fa-check-circle text-warning"></i> Буквы Е/Ё И/Й имеют разницу, </li>
                                    <li><i class="fa fa-li fa-check-circle text-warning"></i> Не допускайте ошибок в имени и фамилии.</li>
                                </ul>
                            </h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-portraits" role="tabpanel" aria-labelledby="pills-portraits-tab">
            <div class="container-fluid">
                <div class="row">
                    @for($i=0; $i<10;$i++)
                        <div class="col-6 col-lg-3 nopad">
                            <label class="image-checkbox">
                                <img data-name="{{ $names[0] }}" src="{{ asset('storage/img/img.jpg') }}" width="100%" height="100%" class="pl-2 pb-2 img-responsive" alt="">
                                <input type="checkbox" name="{{$names[0] }}[{{$i}}]">
                                <i class="fa fa-check d-none"></i>
                            </label>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="groups" role="tabpanel" aria-labelledby="profile-tab">

            <div class="container-fluid">
                <div class="row">

{{--                    @php var_dump($portraitsPhoto)@endphp--}}
                    @foreach ($portraitsPhoto as $link)
                        <div class="col-6 col-lg-3 nopad">
                            <label class="image-checkbox">
                                <img data-name="{{$names[2]}}" src="{{ $link }}" width="100%" height="100%" class="pl-2 pb-2 img-responsive" alt="">
                                <input type="checkbox" name="{{$names[2]}}[{{$i}}]" value="" />
                                <i class="fa fa-check d-none"></i>
                            </label>
                        </div>

                    @endforeach

                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="designs" role="tabpanel" aria-labelledby="profile-tab">
            <div class="container-fluid">
                <div class="row">

                    @for($i=0; $i<10;$i++)

                        <div  class="col-6 col-lg-3 nopad">
                            <label class="image-checkbox">
                                <img data-name="{{$names[3]}}" src="{{ asset('storage/img/img.jpg') }}" width="100%" height="100%" class="pl-2 pb-2 img-responsive" alt="">
                                <input type="checkbox" name="{{$names[3]}}[{{$i}}]" value="" />
                                <i class="fa fa-check d-none"></i>
                            </label>
                        </div>

                    @endfor

                </div>
            </div>
        </div>


        <div class="tab-pane fade flex-center" id="anket" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row justify-content-center">
                <div class="col-md-7 col-12">
                    <div class="text-area">
                        <p class="modal-text px-3 py-2">{{ 'php comment output' }}</p>
                    </div>

                    <div class="form-group">
                        <label for="comment">Ответ:</label>
                        <textarea name="userQuestionsAnswer" class="form-control" rows="5" id="comment"></textarea>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.8/js/mdb.min.js"></script>



<script>
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
            $('.nav-tabs').find('.active').css({'backgroud-color:': 'red'});
        }
    }

    function hideChoiceComplete(){
        $("#choiceDone").hide();
        $("#inputFormContent").show();
    }
</script>

</body>
</html>

{{--    @foreach ($portraitsPhoto as $link)--}}
{{--        string with links from Yandex Disk --}}

{{--    @endforeach--}}
