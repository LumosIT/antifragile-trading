@php($uniqueId = Str::uuid())

<span><span id="change_balance_text_{{ $uniqueId }}">{{ rtrim(rtrim(number_format($value, 8, '.', ''), '0'), '.') }}</span> {{ $currency }}</span>
<a class="btn btn-sm btn-icon btn-primary-light rounded-pill btn-wave waves-effect waves-light ms-1 mb-1" data-bs-toggle="modal"
   href="#change_balance_modal_{{ $uniqueId }}">
    <i class="ri-pencil-line"></i>
</a>

@push('modals')
    <div class="modal effect-rotate-left" id="change_balance_modal_{{ $uniqueId }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ $route }}" class="modal-content" id="change_balance_form_{{ $uniqueId }}" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="google_auth_inactive_modalLabel">Изменить баланс</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <input type="text" name="value" id="change_balance_value_{{ $uniqueId }}" required
                               class="form form-control js-decimal-mask" value="{{ $value }}" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary label-btn me-2" type="submit">
                        <i class="ri-pencil-line label-btn-icon me-2"></i>
                        <span id="change_balance_loader_{{ $uniqueId }}" class="label-btn-icon" style="display: none">
                             <span class="spinner-border spinner-border-sm align-middle"></span>
                         </span>
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('scripts')
    <script>

        jsAjaxForm($("#change_balance_form_{{ $uniqueId }}"), (json) => {

            successNotification('Баланс успешно изменен!');

            $("#change_balance_text_{{ $uniqueId }}").text(
                $("#change_balance_value_{{ $uniqueId }}").val()
            );

            $("#change_balance_modal_{{ $uniqueId }}").modal('hide');

        });

    </script>
@endpush
