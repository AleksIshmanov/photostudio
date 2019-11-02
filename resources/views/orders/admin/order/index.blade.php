@extends("layouts.app")

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="card">
{{--                <div class="card-title">--}}
{{--                    <div class="row justify-content-center text-center">--}}
{{--                        <div class="col-12">--}}
{{--                            <a href="{{ route("orders.admin.order.create") }}" role="button" class="btn btn-success py-2">--}}
{{--                                <i class="fa fa-plus d-lg-inline d-sm-inline d-md-block d-none"></i> Добавить--}}
{{--                            </a>--}}
{{--                            <a href="{{ route("orders.admin.order.index") }}"  role="button" class="btn btn-primary py-2">--}}
{{--                                <i class="fa fa-book d-lg-inline d-sm-inline d-md-block d-none"></i> Просмотреть--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th style="text-align: center;">#</th>
                            <th style="text-align: center;">Название</th>
                            <th style="text-align: center;">Всего фото</th>
                            <th style="text-align: center;">Инд. портретов</th>
                            <th style="text-align: center;">Общ. фото владельцу</th>
                            <th style="text-align: center;">Ссылка</th>
                            <th style="text-align: center;">Изменить</th>
                            <th style="text-align: center;">Удалить</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($paginator as $item)
                            <tr>
                                @php /** @var App\Models\Order $item */@endphp
                                <td align="center">{{$item->id}}</td>
                                <td align="center">{{$item->name}}></td>
                                <td align="center">{{$item->photo_common}}</td>
                                <td align="center">{{$item->portraits_count}}</td>
                                <td align="center">{{$item->photo_individual}}</td>
                                <td align="center">{{env('APP_URL').'/order/'. $item->link_secret}}</td>
                                <td align="center">
                                    <a href="{{route('orders.admin.order.edit', $item->id)}}" class="btn btn-primary w-100 h-100"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                </td>

                                <td align="center">
                                    <a method="DELETE" href="{{route('orders.admin.order.destroy', $item->id)}}" class="btn btn-outline-danger w-100 h-100"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
