@extends('admin.layouts.auth', [
	'title' => 'Авторизация'
])

@section('content')
    <form action="{{ route('admin.api.auth.login') }}" autocomplete="on" method="post" id="login_form" class="rounded my-4 bg-white basic-page">
        <div class="basicpage-border"></div>
        <div class="basicpage-border1"></div>
        <div class="card-body p-5">
            <p class="h4 fw-semibold mb-2 text-center">Admin auth</p>
            <p class="mb-4 text-muted fw-normal text-center">Welcome, bro!</p>
            <div class="row gy-3">
                <div class="col-xl-12">
                    <label for="signin-username" class="form-label text-default">Login</label>
                    <input type="text" class="form-control" id="signin-username" name="login" placeholder="Your login">
                </div>
                <div class="col-xl-12">
                    <label for="signin-password" class="form-label text-default d-block">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="signin-password" placeholder="password" name="password">
                        <a href="javascript:void(0);" class="input-group-text text-muted" onclick="createpassword('signin-password',this)"><i class="ri-eye-off-line align-middle"></i></a>
                    </div>
                </div>
                <div class="col-xl-12" id="tfa_block" style="display: none">
                    <label for="signup-password" class="form-label text-default">2FA Code</label>
                    <input type="text" class="form-control" name="code" placeholder="123456" maxlength="6">
                </div>
                <p class="mt-2 mb-0 small text-danger" style="display: none" id="error">Неверный логин или пароль</p>
            </div>
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">
                     <span id="auth_loader" style="display: none">
                         <span class="spinner-border spinner-border-sm align-middle me-1 mb-1"></span>
                     </span>
                    Authorize
                </button>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script type="text/javascript">

        !function(){

            $("#login_form").on('submit', function(e){

                e.preventDefault();

                $("#error").hide();
                $("#auth_loader").show();

                $.post(this.action, $(this).serialize())
                    .done(function(json){

                        if(json.status){

                            setTimeout(function(){
                                location.href = '{{ session('login_redirect', route('admin')) }}';
                            }, 500);

                        }else{

                            $("#auth_loader").hide();

                            switch(json.code){

                                case 403:
                                    $("#error").show().text('Неверный логин или пароль');
                                    break;

                                case 401:
                                    $("#tfa_block").show();
                                    break;

                                case 405:
                                    $("#tfa_block input").val('');
                                    $("#error").show().text('Неверный код 2FA');
                                    break;

                                default:
                                    $("#error").show().text(json.error);
                                    break;


                            }

                        }


                    })
                    .fail(function(){
                        $("#error").show().text('Ошибка сервера');

                        $("#auth_loader").hide();
                    });

            });

        }();


    </script>
@endsection
