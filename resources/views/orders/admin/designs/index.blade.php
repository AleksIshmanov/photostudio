@extends("layouts.app")

@section('content')

    @if($errors->any())
        <div class="contrainer py-3">
            <div class="row justify-content-center">
                <div class="col-8 bg-danger text-center py-2 border rounded-top text-white">
                    <ol>
                        @foreach($errors->all() as $error)
                            <li class="Probabo-inquit-sic-a">{{ $error }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    @endif

{{--    Если проводили обновление дизайнов route('orders.admin.designs.sync') --}}
    @if( isset($count) )
        <div class="container">
            <div class="row justify-content-center py-3">
                <div class="col-8 alert-info">
                    <h3>На диске было обнаружено {{ $totalDesigns }}, на обработку добавлено {{ $count }} папок</h3>
                </div>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">

            <div class="card col-8 m-0 p-0">

                <div class="card-header text-center">
                    <h3>Параметры папки с дизайнами</h3>
                </div>

                <div class="container">
                    <div class="row justify-content-center py-3">
                        <div class="w-100 bg-success text-center  py-2 border rounded-top text-white">
                            <h5>{{ env('YANDEX_DESIGN_DIR') }}</h5>
                        </div>
                    </div>

                    <div class="card-body ">
                            <div class="form-group w-100">
                                <form onsubmit="return confirm('Вы точно уверены, что хотите изменить папку с дизайнами?')" action="{{ route('orders.admin.designs.config') }}" method="POST" class="justify-content-center">
                                    @csrf
                                    <input type="text" name="designDir" class="col-12 text-center" placeholder="Введите новую папку">
                                    <button type="submit" class="btn py-1 bg-danger col text-white">Изменить папку</button>
                                </form>
                            </div>
                        </div>

                        <div class="row justify-content-center py-3">
                            <div class="form-group col-6 m-0 p-0">
                                <form onsubmit="return confirm('Вы точно уверены, что хотите обновить дизайны')" action="{{ route('orders.admin.designs.sync') }}" method="POST" class="justify-content-center">
                                    @csrf
                                    <button type="submit" class="btn btn-lg bg-info w-100 text-white">Обновить дизайны</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @if(isset($designs))
            @foreach($designs as $designName=>$photoUrlArray)
                <div class="row py-2">
                    <div class="card">
                        <h3 class="card-header text-center"> Дизайн #{{ $designName }}</h3>
                        <div class="card-body row">
                            @php $blockSize = 12 / count($photoUrlArray); @endphp
                            @foreach($photoUrlArray as $photoUrl)
                                <div class="col-lg-{{ $blockSize }} col-12">
                                    <img src="{{ $photoUrl }}" width="100%" height="100%" alt="{{ $designName }} photo" class="border border-dark rounded">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

@endsection
