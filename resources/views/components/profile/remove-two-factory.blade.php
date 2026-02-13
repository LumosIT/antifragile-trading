@if($entity->tfa_enabled)
    <div class="card bg-white border-0">
        <div class="alert custom-alert1 alert-success">
            <div class="text-center px-3 pb-0 svg-success pt-3">
                <svg class="custom-alert-icon" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000"><path d="M0 0h24v24H0z" fill="none"></path><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                <h5>ОК!</h5>
                <p class="">Подключена двухфакторная аутентификация!</p>
                <div class="">
                    <button type="button" class="btn btn-danger label-btn me-2" id="remove-two-factory-button">
                        <i class="ri-lock-2-fill label-btn-icon me-2"></i>
                        Отключить 2FA
                    </button>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card bg-white border-0">
        <div class="alert custom-alert1 alert-danger">
            <div class="text-center px-3 pb-0 svg-danger pt-3">
                <svg class="custom-alert-icon" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000"><path d="M0 0h24v24H0z" fill="none"></path><path d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z"></path></svg>
                <h5>Внимание</h5>
                <p class="">Отключена двухфакторная аутентификация!</p>
            </div>
        </div>
    </div>
@endif

@push('scripts')

    <script>

        $("#remove-two-factory-button").on('click', function(e){

            e.preventDefault();

            ajaxConfirmationModal("{{ $route }}", 'Отключить двухфакторку?', () => {
                location.reload();
            })

        });

    </script>

@endpush
