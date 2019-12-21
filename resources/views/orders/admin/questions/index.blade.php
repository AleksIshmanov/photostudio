@extends("layouts.app")

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            @if ($errors->any())
                <div class="alert alert-danger col-8">
                    <h3 class="text-center">При заполнении формы были допущены ошибки: </h3>
                    <ol>
                        @foreach ($errors->all() as $error)
                            <li class="Probabo-inquit-sic-a">{{ $error }}</li>
                        @endforeach
                    </ol>
                </div>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">

            <div class="card col-8">
                <div class="card-header">
                    <h3>Создать новый вопрос</h3>
                </div>

                <div class="card-body">
                    <div class="row justify-content-center py-3">
                        <div class="form-group col-12">

                            <form action="{{ route('orders.answers.store') }}" method="POST">
                                @csrf
                                <div class="pb-3 input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width: 150px">Введите название</span>
                                    </div>
                                    <input type="text" name="header" class="form-control">
                                </div>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width: 150px">Ответ на вопрос</span>
                                    </div>
                                    <textarea class="form-control col-12" name="text" rows="10" aria-label="Введите ответ на вопрос"></textarea>
                                </div>
                                
                                <div class="pt-3 text-center">
                                    <button type="submit" class="btn btn-primary w-25 text-center py-2">Создать</button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>



            </div>

        </div>

        <div class="row justify-content-center py-3">
            <div class="col-lg-8 col-12">

                <h3 class="text-center py-2">Текущий ответы для пользователей: </h3>

                @php $count = 0;@endphp
                @foreach($answers as $answer)
                    @php $count++ @endphp
                <div class="card my-3">
                    <div class="card-header">
                        <h3 class="text-center">{{ $answer->header }}</h3>
                    </div>

                    <div class="card-body">
                        <p class="text-left">
                                {!! $answer->text !!}
                        </p>
                    </div>
                    
                    <div class="card-footer">
                        <form action="{{ route('orders.answers.destroy', $answer->id) }}" method="POST" onsubmit="return alert('Вы действительно хотите удалить этот ответ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger text-center">Удалить</button>
                        </form>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>


@endsection