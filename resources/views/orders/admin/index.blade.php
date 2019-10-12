@extends("layouts.app")

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Всего фото</th>
                            <th>Инд. портретов</th>
                            <th>Общ. фото владельцу</th>
                            <th>Ссылка</th>
                            <th>Изменить</th>
                            <th>Удалить</th>
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
                                    <a href="{{route('orders.admin.order.destroy', $item->id)}}" class="btn btn-outline-danger w-100 h-100"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                {{$paginator->links('vendor.pagination.bootstrap-4')}}
        </ul>

    </div>
</div>

@endsection
