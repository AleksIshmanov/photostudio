@extends("layouts.app")

@section('content')
<div class="container-fluid">

    @if($order->is_closed)
        @php /** App/Models/Order **/  @endphp
        <div class="row justify-content-center py-3">
            <div class="card col-md-6 col-lg-6 col-12 bg-success">
                <h3 class="card-header text-white text-center">Заказ закрыт!</h3>
            </div>

        </div>
    @endif

    <div class="row justify-content-center py-3">

        <div class="col-sm-12 col-lg-6 col-12 col-md-6 card">
            <h3 class="card-header text-center"> Код подтверждения: {{ $order->confirm_key }}</h3>
            <div class="card-body">
                <h3 class="text-center"><u>Ссылка для контрольного родителя:</u> <br><br> {{ route('orders.client.confirm', $order->link_secret) }}</h3>
            </div>
        </div>
    </div>

    <div class="row justify-content-center py-3">
        <div class="col-sm-12 col-lg-6 col-12 col-md-6">

            <h2 class="text-center">
                Выбор пользователей в общий альбом
                <hr>
            </h2>

            <div class="card">
                <div class="card-body table-responsive table">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center" >Фотография в общ. альбом</th>
                            <th class="text-center" >Кол-во голосов</th>
                        </tr>
                        </thead>

                        <tbody>

                        @php $count = 0 @endphp
                        @while($count < count($choice) )

                            <tr class="bg-warning">
                                <td class="text-center">{{ array_keys($choice)[$count] }}</td>
                                <td class="text-center">{{ array_values($choice)[$count] }}</td>
                            </tr>

                        @php $count+=1 @endphp
                        @endwhile
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-12">

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th style="text-align:center">#</th>
                            <th style="text-align:center">Имя пользователя</th>
                            <th style="text-align:center">Главный портрет</th>
                            <th style="text-align:center">Выбор портетов</th>
                            <th style="text-align:center">Выбор в альбом</th>
                            <th style="text-align:center">Дизайн</th>
                            <th>Удалить</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $i=0@endphp
                        @foreach($users as $user)
                            <tr>
                                @php
                                    /**
                                    * get the array with [0=>?$user; 1=>numbers]
                                    * @var App\Models\OrderUser $user
                                    * @var numbers
                                    */
                                    $i++;
                                    $portraits = json_decode($user->portraits, true);
                                    $commonPhotos = json_decode($user->common_photos, true);
                                @endphp

                                <td align="center">{{$i}}</td>
                                <td align="center">{{$user->name}}</td>
                                <td align="center">{{$user->portrait_main }}</td>
                                <td align="center">
                                    @if(isset($portraits['nums']))
                                        @php echo implode( "<br>", $portraits['nums']) @endphp
                                    @else
                                        No choice
                                    @endif
                                </td>
                                <td align="center">
                                    @if(isset($commonPhotos['nums']))
                                        @php echo implode( "<br>", $commonPhotos['nums']) @endphp
                                    @else
                                        No choice
                                    @endif
                                </td>
                                <td align="center">
                                    {{ $user->design }}
                                </td>

                                <td align="center">
                                    <form action="{{route('orders.admin.user.destroy', $user->id)}}"
                                          method="POST"
                                          onsubmit="return confirm('Вы уверены, что хотите удалить ВНИМАНИЕ! *{{ ($user->name)}}*' );"
                                    >
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit"
                                                class="btn btn-outline-danger w-100 h-100"
                                        >
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>

                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <section class="container-fluid">
        <div class="row pt-5">
            <div class="col-12 text-center">
                <h3>Комментарии пользователей</h3>
                <p>Вопросы от менеджера:<br>
                    <u>{{ $order_question }}</u>
                </p>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="card col-12">
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th  scope="col" class="text-center">#</th>
                            <th  scope="col" class="text-center">Пользователь</th>
                            <th  scope="col" class="text-center">Комментарий</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $i = 0 @endphp
                        @foreach( $users as $user)
                            @php $i++; @endphp
                            <tr>
                                <td class="text-center" scope="col">{{ $i }}</td>
                                <td class="text-center" scope="col">{{ $user->name }}</td>
                                <td class="text-center" scope="col">{{ $user->comment }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

</div>

@endsection
