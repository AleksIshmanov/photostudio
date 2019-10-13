@extends("layouts.app")

@section('content')


    <div class="container">
        <div class="row text-center justify-content-center py-5">
            <div class="col-6">
                <h2>Название заказа</h2>
                <input type="text" class="form-control w-100">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-12 col-12 col-lg-4 col-md-4">

                <!-- HTML-форма, оформленная с помощью стилей Bootstrap 4 -->
                <form method="post" action="" autocomplete="off">
                    <p>Параметры выбора:</p>
                    <div class="form-group">
                        <input name="photos_all" type="number" class="form-control" placeholder="Всего фотографий">
                    </div>

                    <div class="form-group">
                        <input name="portraits_count" type="number" class="form-control" placeholder="Кол-во портретов инд. в альбом">
                    </div>

                    <div class="form-group">
                        <input name="common_ind" type="number" class="form-control" placeholder="Общих фото инд. владельцу">
                    </div>
                </form>

            </div>

            <div class="col-sm-12 col-12 col-lg-4 col-md-4 py-5 py-xs-5 py-sm-5 py-lg-0 py-md-0">
                <p>Параметры заказа:</p>
                <div class="form-group">
                    <input name="portraits_count" type="text" class="form-control" id="email" placeholder="Ссылка на фотосессию">
                </div>

                <div class="form-group">
                    <input name="portraits_count" type="number" value="2" class="form-control" id="email" placeholder="Количество дизайнов">
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

        <div class="row text-center justify-content-center">
            <div class="col-12 col-sm-12 col-xs-12 col-lg-8 col-md-8 form-group" style="height: 100%;">
                <label for="comment">Комментарий к заказу</label>
                <textarea class="form-control" rows="8" id=""></textarea>
            </div>
        </div>

        <div id="profile_form" class="row text-center justify-content-center" style="display: none;">
                <div class="col-12 col-sm-12 col-xs-12 col-lg-8 col-md-8 form-group">
                    <label for="comment">Анкета для клиента</label>
                    <textarea class="form-control" rows="8" id=""></textarea>
                </div>
        </div>

        <div class="row text-center justify-content-center">
            <div class=" col-6">
                <button type="submit" class="btn btn-success w-100">Создать заказ</button>
            </div>
        </div>

    </div>

    <script>

        function show_profile_form() {
            var chbox = document.getElementById('profile');
            var profile_form = document.getElementById('profile_form');
            profile_form.style.display = chbox.checked ? 'flex': "none";
            console.log( profile_form.style.display, chbox.checked);
        }
    </script>

@endsection
