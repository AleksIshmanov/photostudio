@extends("layouts.standart")

@section('content')

<section class="container">
    <div class="row">
        <div class="col-12 Mask justify-content-center text-center d-flex flex-center">
            <h1 class="align-self-center">Финальное утверждение заказа</h1>
        </div>
    </div>

    <div class="row py-5">
        <div class="col-12 text-center">
            <h3 class="">Инструкция</h3>
            <p class="This-is-a-big-one-a">Все данные строго зафиксированы. <br>Если родитель хочет изменить выбор фотографий, то ему следует на странице заказа удалить свое имя и вновь сделать свой выбор с самого начала.</p>
            <hr>
        </div>
    </div>
</section>

<section class="container">
    <div class="row pt-5">
        <div class="col-12 text-center">
            <h3>Проверьте корректность имени, фамилии и выбора</h3>
            <p>Данные имена будут указаны в альбоме, поэтому проверьте корректность всех имен и фамилий. <br>В последующем изменения невозможны.</p>
            <hr>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th  scope="col" class="text-center">#</th>
            <th  scope="col" class="text-center">Имя</th>
            <th  scope="col" class="text-center">Страница пользователя</th>
            <th  scope="col" class="text-center">Подтверждение</th>
        </tr>
        </thead>

        <tbody>

        @php $i=1 @endphp
        @foreach($usersNames as $user)
            {{-- App/Models/OrderUser --}}
        <tr>
            <td class="text-center" scope="col">{{ $i }}</td>
            <td class="text-center" scope="col">{{ $user->name }}</td>
            <td class="text-center" scope="col">
                <form method="GET" action="{{ route('orders.client.user.demo', [$textLink, $user->id]) }}">
                    <button type="submit" class="Blue-btn-table text-white text-">
                        <i class="fa fa-eye  px-2" aria-hidden="true"></i>
                        <span class="d-none d-lg-inline">Просмотреть</span>
                    </button>
                </form>
            </td>
            <td class="text-center" scope="col">
                <input type="checkbox" class="form-check-input text-center">
            </td>
        </tr>
        @php $i++ @endphp
        @endforeach

        </tbody>
    </table>
</section>

<section class="container">
    <div class="row pt-5">
        <div class="col-12 text-center">
            <h3>Пользователи выбрали следующие дизайны</h3>
            <p>Данные фотографии будут утверждены в альбом <br>В последующем изменения невозможны.</p>
            <hr>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th  scope="col" class="text-center">#</th>
            <th  scope="col" class="text-center">Пользователь</th>
            <th  scope="col" class="text-center">Выбранный дизайн</th>
            <th  scope="col" class="text-center">Статус</th>
            <th  scope="col" class="text-center">Подтверждение</th>
        </tr>
        </thead>

        <tbody>

        @php $i=1 @endphp
        @foreach($usersDesigns as $user=>$design)
            {{-- array ( (string) userName => array ('design', 'design') ) --}}
            <tr>
                <td class="text-center" scope="col">{{ $i }}</td>
                <td class="text-center" scope="col">{{ $user }}</td>
                <td class="text-center" scope="col">{{ implode( ' ', $design) }}</td>
                <td class="text-center" scope="col">
                    @if(  )
                        <i class="fa fa-exclamation-triangle" style="color: #3490dc; font-size: 1.5em;"></i>
                        @else
                        <i class="fa fa-check-square" style="color: #38c172; font-size: 1.5em;"></i>
                    @endif
                </td>
                <td class="text-center" scope="col">
                    <input type="checkbox" class="form-check-input">
                 </td>
            </tr>
            @php $i++ @endphp
        @endforeach

        </tbody>
    </table>
</section>

@endsection
