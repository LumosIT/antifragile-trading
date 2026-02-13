@if(!$entity->tfa_enabled)
    <div class="card bg-white border-0">
        <div class="alert custom-alert1 alert-danger">
            <div class="text-center px-3 pb-0 svg-danger pt-3">
                <svg class="custom-alert-icon" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000"><path d="M0 0h24v24H0z" fill="none"></path><path d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z"></path></svg>
                <h5>Внимание</h5>
                <p class="">У вас отключена двухфакторная аутентификация!</p>
                <div class="">
                    <a class="btn btn-success label-btn me-2" data-bs-toggle="modal"
                       href="#google_auth_active_modal" id="google_auth_active_modal_button">
                        <i class="ri-shield-check-fill label-btn-icon"></i>
                        Активировать 2FA
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card bg-white border-0">
        <div class="alert custom-alert1 alert-success">
            <div class="text-center px-3 pb-0 svg-success pt-3">
                <svg class="custom-alert-icon" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000"><path d="M0 0h24v24H0z" fill="none"></path><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                <h5>ОК!</h5>
                <p class="">У вас подключена двухфакторная аутентификация!</p>
                <div class="">
                    <a class="btn btn-danger label-btn me-2" data-bs-toggle="modal"
                       href="#google_auth_inactive_modal" >
                        <i class="ri-lock-2-fill label-btn-icon me-2"></i>
                        Отключить 2FA
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif


@push('modals')
    <div class="modal effect-rotate-left" id="google_auth_active_modal" tabindex="-1">
        <div class="modal-dialog">
            <form id="verify-google-form"  action="{{ $routes['confirm'] }}" method="post" autocomplete="off" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="google_auth_inactive_modalLabel">Активировать 2FA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="secret-code" name="secret" value="">

                    <div class="row px-2">
                        <div class="col-4">
                            <div id="qrcode" style="width: 140px;margin-top: -18px;"></div>
                            <style>#qrcode svg{max-width:100%}</style>
                            <p id="qr_tfa_secret" class="text-muted fs-10 text-center" style="margin-top: -20px;word-break: break-all;"></p>
                        </div>
                        <div class="col-8 pt-3">
                            <h6><span class="badge bg-warning-transparent me-1 mt-1">Шаг 1</span> Отсканируйте QR-код</h6>
                            <p class="text-muted">Воспользуйтесь мобильным приложением Google Authenticator</p>
                            <br>
                            <h6><span class="badge bg-primary-transparent me-1 mt-1">Шаг 2</span> Введите код</h6>
                            <p class="text-muted">Введите проверочный код для подтверждения</p>
                            <div class="form-group">
                                <label for="user-secret-code" class="form-label fs-14 text-dark">Введите ваш код</label>
                                <input type="text" id="user-secret-code" name="code" required
                                       class="form form-control js-numeric-mask" maxlength="6">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success label-btn me-2">
                        <i class="ri-shield-check-fill label-btn-icon"></i>
                        <span id="google_auth_active_loader" class="label-btn-icon" style="display: none">
                             <span class="spinner-border spinner-border-sm align-middle"></span>
                         </span>
                        Активировать 2FA
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal effect-rotate-left" id="google_auth_inactive_modal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ $routes['remove'] }}" class="modal-content" id="disable_2fa_form" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="google_auth_inactive_modalLabel">Отключить 2FA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user-secret-code" class="form-label fs-14 text-dark">Введите ваш код</label>
                        <input type="text" name="code" required
                               class="form form-control js-numeric-mask" maxlength="6">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger label-btn me-2">
                        <i class="ri-lock-2-fill label-btn-icon me-2"></i>
                        <span id="google_auth_inactive_loader" class="label-btn-icon" style="display: none">
                             <span class="spinner-border spinner-border-sm align-middle"></span>
                         </span>
                        Отключить 2FA
                    </button>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('scripts')

    <script>


        $('#google_auth_active_modal_button').on('click', function (e) {

            e.preventDefault();

            $.post("{{ $routes['generate'] }}")
            .done(function(json){

                if(json.status) {
                    $('#secret-code').val(json.response.secret);
                    $("#qr_tfa_secret").text(json.response.secret);
                    $("#secret-code-text").text(json.response.secret);
                    $('#qrcode').html(json.response.qr);
                }else{
                    errorNotification(json.error);
                }

            });

        });

        jsAjaxForm($('#verify-google-form'), () => {

            successNotification('Двухфакторная проверка подключена!');

            location.reload();

        });

        jsAjaxForm($("#disable_2fa_form"), () => {

            successNotification('Двухфакторная проверка отключена!');

            location.reload();

        })

    </script>

@endpush
