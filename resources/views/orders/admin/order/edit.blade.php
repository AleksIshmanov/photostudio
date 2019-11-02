@extends("layouts.app")

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center py-3">
        <div class="col-sm-12 col-lg-6 col-12 col-md-6">

            <h2 class="text-center">
                Выбор пользователей
            </h2>

            <div class="card">
                <div class="card-body table-responsive table">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center" >Вариант</th>
                            <th class="text-center" >Кол-во голосов</th>
                        </tr>
                        </thead>

                        <tbody>

                        @php $count = 0 @endphp
                        @while($count < count($data[1]) )
                        <tr>
                                <td class="text-center">{{ array_keys($data[1])[$count] }}</td>
                                <td class="text-center">{{ array_values($data[1])[$count] }}</td>
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
                            <th>Изменить</th>
                            <th>Удалить</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $i=0@endphp
                        @foreach($data[0] as $user)
                            <tr>
                                @php
                                    /**
                                    * get the array with [0=>?$user; 1=>numbers]
                                    * @var App\Models\OrderUser $user
                                    * @var numbers
                                    */
                                    $i++;
                                @endphp
                                <td align="center">{{$i}}</td>
                                <td align="center">{{$user->name}}</td>
                                <td align="center">{{$user->portrait_main }}</td>
                                <td align="center">{{ implode( ' ',json_decode($user->portraits, true)['nums']) }}</td>
                                <td align="center">{{ implode( ' ',json_decode($user->common_photos, true)['nums']) }}</td>
                                <td align="center">
                                    <a href="{{route('orders.admin.user.edit', $user->id)}}" class="btn btn-primary w-100 h-100"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                </td>

                                <td align="center">
                                    <a href="{{route('orders.admin.user.destroy', $user->id)}}" class="btn btn-outline-danger w-100 h-100"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">

        <ul class="pagination mt-2 justify-content-end">
                {{$data[0]->links('vendor.pagination.bootstrap-4')}}
        </ul>

    </div>
</div>

@endsection
