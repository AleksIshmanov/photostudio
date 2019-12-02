@extends("layouts.standart")

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <table class="table table-responsive-sm table-responsive-md">
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
                <input type="checkbox" class="text-center">
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
            <p>По условию заказа, студия выполняет все работы по двум наиболее популярным дизайнам. <br>Родители с наименее популярным дизайном должны либо изменить свой выбор, либо оплатить дополнительную услугу.</p>
            <hr>
        </div>
    </div>

    <table class="table table-responsive-sm table-responsive-md">
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
                <td class="text-center" scope="col">{{ $design }}</td>
                <td class="text-center" scope="col">
                    @if( !in_array($design, $mostPopularDesigns) )
                        <i class="fa fa-exclamation-triangle" style="color: #c0392b; font-size: 1.5em;"></i>
                        @else
                        <i class="fa fa-check-square" style="color: #38c172; font-size: 1.5em;"></i>
                    @endif
                </td>
                <td class="text-center" scope="col">
                    <input type="checkbox" class="text-center">
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
            <h3>В общий альбом избраны следующие фотографии</h3>
            <p>Согласно всеобщему голосованию в общий альбом отобраны следующие фотографии</p>
            <hr>
        </div>
    </div>

    <div class="row justify-content-center">
        @foreach ($groupsPhoto as $link)
            <div class="col-6 col-lg-3 nopad text-center">
                <img src="{{ $link }}" width="100%" height="100%" class="pl-2 pb-2 img-responsive" alt="">
            </div>
        @endforeach
    </div>

</section>

<section class="container">
    <div class="row pt-5">
        <div class="col-12 text-center">
            <h3>Утвеждение</h3>
            <p>Чтобы передать заказ на обработку, нужно внести подтверждение.
                <br> Ключ от заказа выдан одному из родителей, после подтверждения заказа изменить данные невозможно.</p>
            <hr>
        </div>
    </div>

{{--    <form action="{{ route('orders.client.confirm.post', $textLink) }}" method="POST">--}}
    <form>
        <input type="hidden" name="textLink" class="d-none" value="{{  $textLink }}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-4 col-12">
                <input name="confirm_key" type="text" value="" class="form-control" placeholder="Ключ утверждения заказа">
            </div>
        </div>

        <div class="row justify-content-center py-3">
            <div class="text-center col-lg-4 col-12">
                <button type="button" id="submit" class="btn Yellow-btn coolis text-white w-100 overflow-hidden" style="width: 50%;"><span>Утвердить заказ</span></button>
            </div>
        </div>

    </form>
</section>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

    $(document).ready(function() {
        $('#submit').click(function(){
            var confirm_key = $('input[name="confirm_key"]').val();
            var token = $('input[name="_token"]').val();
            var textLink = "{{ $textLink }}";

            console.log(confirm_key, token, textLink);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: "{{ route('orders.client.confirm.post', $textLink) }}",
                data: {
                    confirm_key: confirm_key,
                    token: token,
                    textLink: textLink,
                },
                dataType: 'json',
                success: function(data){
                    alert('Заказ утвержденю. В течение пару секунд вы будете перенаправлены на основную страницу заказа.');
                    setTimeout(function () {
                        window.location.href = "{{ route('orders.client.show', $textLink) }}"; //will redirect to your blog page (an ex: blog.html)
                    }, 2000); //will call the function after 2 secs.

                },
                error: function (err) {
                    console.warn(err.responseJSON);
                    alert("Неверный ключ утверждения заказа. ");
                }
            });
        });
    });

</script>

@endsection
