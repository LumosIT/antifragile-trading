<a class="btn btn-primary label-btn me-2" data-bs-toggle="modal"
   href="#change_password_modal">
    <i class="ri-lock-2-fill label-btn-icon me-2"></i>
    Сменить пароль
</a>

@push('modals')
    <div class="modal effect-rotate-left" id="change_password_modal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ $route }}" class="modal-content" id="change_password_form" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="google_auth_inactive_modalLabel">Сменить пароль</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="user-secret-code" class="form-label fs-14 text-dark">Новый пароль</label>
                        <input type="password" name="password" required
                               class="form form-control" placeholder="От 3 символов">
                    </div>
                    <div class="form-group mb-2">
                        <label for="user-secret-code" class="form-label fs-14 text-dark">Новый пароль еще раз</label>
                        <input type="password" name="password_confirmation" required
                               class="form form-control" placeholder="Введите повторно">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary label-btn me-2" type="submit">
                        <i class="ri-lock-2-fill label-btn-icon me-2"></i>
                        <span id="change_password_loader" class="label-btn-icon" style="display: none">
                             <span class="spinner-border spinner-border-sm align-middle"></span>
                         </span>
                        Подтвердить
                    </button>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('scripts')
    <script>

        jsAjaxForm($("#change_password_form"), (json) => {

            successNotification('Пароль успешно изменен!');

            $("#change_password_modal").modal('hide');

        });

    </script>
@endpush
