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

        <!-- HTML-форма, оформленная с помощью стилей Bootstrap 4 -->
        <form method="POST" action="{{ route('orders.admin.order.store') }}" autocomplete="off">
            @csrf

        <div class="row text-center justify-content-center py-5">
            <div class="col-6">
                <h2>Название заказа</h2>
                <input type="text" name="taskName" value="{{ old(('taskName'))  }}" class="form-control w-100">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-12 col-12 col-lg-4 col-md-4">
                    <p>Параметры выбора:</p>
                    <div class="form-group">
                        <input name="photosAll" type="number" class="form-control" value="{{ old('photosAll') }}" placeholder="Всего фотографий">
                    </div>

                    <div class="form-group">
                        <input name="individualPhotosCount" type="number" value="{{ old('individualPhotosCount') }}" class="form-control" placeholder="Кол-во портретов инд. в альбом">
                    </div>

                    <div class="form-group">
                        <input name="commonPhotosToCustomer" type="number" value="{{ old('commonPhotosToCustomer') }}" class="form-control" placeholder="Общих фото инд. владельцу">
                    </div>
            </div>

            <div class="col-sm-12 col-12 col-lg-4 col-md-4 py-5 py-xs-5 py-sm-5 py-lg-0 py-md-0">
                <p>Параметры заказа:</p>
                <div class="form-group">
                    <input name="photoAlbumLink" type="text" value="{{ old('photoAlbumLink') }}" class="form-control" placeholder="Ссылка на фотосессию: https://yadi.sk/d/3PUt8S">
                </div>

                <div class="form-group">
                    <input name="designsCount" type="number" value="1" class="form-control" placeholder="Количество дизайнов">
                </div>

                <div class="form-group py-2">
                    <div class="custom-control custom-radio">
                        <div class="custom-control custom-checkbox">
                            <input onchange="show_profile_form();" type="checkbox" class="custom-control-input" id="profile">
                            <label class="custom-control-label" for="profile">Добавить анкету</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row justify-content-center">
            <div class="form-group py-2 col-8">
                <input type="text" name="dirName" id="dirName"  value="{{ old('dirName') }}" class="form-control" placeholder="Введите назвавние папки на Яндекс Диске">
            </div>
        </div>

        <div class="row text-center justify-content-center">
            <div class="col-12 col-sm-12 col-xs-12 col-lg-8 col-md-8 form-group" style="height: 100%;">
                <label for="comment">Комментарий к заказу</label>
                <textarea name="comment" class="form-control" rows="8" id="">{{ old('comment') }}</textarea>
            </div>
        </div>

        <div id="profile_form" class="row text-center justify-content-center" style="display: none;">
                <div class="col-12 col-sm-12 col-xs-12 col-lg-8 col-md-8 form-group">
                    <label for="comment">Анкета для клиента</label>
                    <textarea name="questionnaire" class="form-control" rows="8" id="">{{ old('questionnaire') }}</textarea>
                </div>
        </div>

        <div class="row text-center justify-content-center">
            <div class=" col-6">
                <input type="submit" class="btn btn-success w-100">
            </div>
        </div>

        </form>

    </div>

    <script>

        function show_profile_form() {
            var chbox = document.getElementById('profile');
            var profile_form = document.getElementById('profile_form');
            profile_form.style.display = chbox.checked ? 'flex': "none";
        }

    </script>

@endsection
