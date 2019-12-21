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

    @if($order->is_closed)
        @php /** App/Models/Order **/  @endphp

        <div class="row justify-content-center py-3">
            <div class="card col-md-12 col-lg-6 col-12 bg-success">
                <h3 class="card-header text-white text-center ">Заказ закрыт!</h3>
                <div class="card-body text-center text-white">Все изменения зафиксированы и не подлежат корректировке.<br> Выбор можно изменить только через обращение к менеджеру.</div>
            </div>

        </div>
    @endif

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

            @if($isOrderClosed)
                <div class="btn text-white w-100 bg-success rounded-right rounded-left">Заказ закрыт</div>
                @else
                <form action="{{ route('orders.client.choose', $textLink) }}" method="GET">
                    <button type="submit" onsubmit="{{ $isOrderClosed }}" class="btn Yellow-btn coolis text-white w-100 overflow-hidden" style="border-radius: 20px;" >
                        <span>Сделать свой выбор</span>
                    </button>
                </form>
            @endif

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
                    <form method="POST" action="{{ route('orders.admin.user.destroy', $user->id) }}"
                          onsubmit="return confirm('Вы уверены, что хотите удалить ВНИМАНИЕ! *{{ ($user->name)}}*' );" >
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="Yellow-btn-table btn-danger text-white">
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

            @foreach($answers as $answer)
                 @php /** @var App/Models/OrderAnswers **/ @endphp
            <div class="card py-3">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link How-Long-Will-It-Tak" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            {{ $answer->header }}
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body Probabo-inquit-sic-a text-left">
                        {!! $answer->text !!}
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>

    <div class="py-5"></div>
</div>





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
