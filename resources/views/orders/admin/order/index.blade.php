@extends("layouts.app")

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center py-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <th class="text-center w-25" scope="col">Название</th>
                        <th class="text-center w-5" scope="col">Прогресс</th>
                        <th class="text-center w-25" scope="col">Состояние</th>
                        </thead>

                        <tr>
                            <td class="text-center">Фотографий в обработке</td>
                            <td class="text-center">
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                        <span>{{$totalJobsOnTransfer }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($totalJobsOnTransfer!=0)
                                    <i class="fa fa-spinner fa-spin" style="color: #3490dc; font-size: 1.5em;"></i>
                                @else
                                    <i class="fa fa-check-square" style="color: #38c172; font-size: 1.5em;"></i>
                                @endif

                                    &nbsp; &nbsp;

                                    {{--                  Если файлы с предупреждениями              --}}
                                @if($totalAttempts)
                                    [
                                        <i class="fa fa-exclamation-triangle" style="color: #f39c12; font-size: 1.5em;" aria-hidden="true"></i>
                                        {{ $totalAttempts }}
                                    ]
                                @endif

                            </td>
                        </tr>
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
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Название</th>
                            <th scope="col" class="text-center">Всего фото</th>
                            <th scope="col" class="text-center">Инд. портретов</th>
                            <th scope="col" class="text-center">Общ. фото владельцу</th>
                            <th scope="col" class="text-center">Ссылка</th>
                            <th class="text-center" scope="col">Перейти</th>
                            <th scope="col" class="text-center">Изменить</th>
                            <th scope="col" class="text-center">Удалить</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($paginator as $item)
                            @php $orderUrl = env("APP_URL").'/order/'.$item->link_secret @endphp

                            @if($item->is_closed)
                                <tr class="bg-warning">
                                @else
                                <tr>
                            @endif

                                @php /** @var App\Models\Order $item */@endphp
                                <td align="center">{{$item->id}}</td>
                                <td align="center">{{$item->name}}></td>
                                <td align="center">{{$item->photo_total}}</td>
                                <td align="center">{{$item->portraits_count}}</td>
                                <td align="center">{{$item->photo_individual}}</td>
                                <td align="center">{{ $orderUrl }}</td>

                                <td align="center">
                                    <a href="{{ $orderUrl }}" class="btn bg-success w-100 h-100">
                                        <i class="fa fa-external-link-square" style="color: #fff;" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td align="center">
                                    <a href="{{route('orders.admin.order.edit', $item->id)}}" class="btn btn-primary w-100 h-100">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>
                                </td>

                                <td align="center">
                                    <form method="POST"
                                          action="{{route('orders.admin.order.destroy', $item->id)}}"
                                          onsubmit="return confirm('Вы подтверждаете, что хотите УДАЛИТЬ заказ? Восстановить выбор пользователей будет невозможно.')"
                                    >
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-outline-danger w-100 h-100" >
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

    <div class="row justify-content-center">
            {{$paginator->links('vendor.pagination.bootstrap-4')}}
    </div>


</div>

@endsection
