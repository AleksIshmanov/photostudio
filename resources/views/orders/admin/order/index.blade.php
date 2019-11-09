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
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Название</th>
                            <th scope="col" class="text-center">Всего фото</th>
                            <th scope="col" class="text-center">Инд. портретов</th>
                            <th scope="col" class="text-center">Общ. фото владельцу</th>
                            <th scope="col" class="text-center">Ссылка</th>
                            <th scope="col" class="text-center">Изменить</th>
                            <th scope="col" class="text-center">Удалить</th>
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
                                <td align="center">
                                    {{ env("APP_URL").'/order/'.$item->link_secret}}
                                </td>
                                <td align="center">
                                    <a href="{{route('orders.admin.order.edit', $item->id)}}" class="btn btn-primary w-100 h-100">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>
                                </td>

                                <td align="center">
                                    <form method="POST" action="{{route('orders.admin.order.destroy', $item->id)}}">
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
