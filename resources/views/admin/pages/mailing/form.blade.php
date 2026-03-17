@extends('admin.layouts.app')

@php($title = 'Создание рассылки')

@section('title', $title)

@section('content')

    @include('components.other.breadcrumbs', [
        'items' => [
            'Управление' => '#',
            'Рассылки' => route('admin.mailing'),
            $title
        ]
    ])

    <div class="row">
        <form id="my_form" action="{{  route('admin.api.mailing.create') }}" class="card" method="post" autocomplete="off">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    {{ $title }}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div class="form-group mb-4">
                            <label for="" class="mb-2">Текст (HTML)</label>
                            <textarea name="text" cols="30" required rows="10" class="form-control" id="mail_textarea"></textarea>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <label for="" class="mb-2">Медиа-файы</label>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    @include('components.forms.telegram-file-picker', [
                                        'placeholder' => '',
                                        'name' => 'file_ids[]',
                                        'accept' => '.jpeg,.jpg,.png,.mp4,.doc,.txt,.xls,.ppt,.pptx,.docx,.xlsx'
                                    ])
                                </div>
                                <div class="form-group mb-2">
                                    @include('components.forms.telegram-file-picker', [
                                        'placeholder' => '',
                                        'name' => 'file_ids[]',
                                        'accept' => '.jpeg,.jpg,.png,.mp4,.doc,.txt,.xls,.ppt,.pptx,.docx,.xlsx'
                                    ])
                                </div>
                                <div class="form-group mb-2">
                                    @include('components.forms.telegram-file-picker', [
                                        'placeholder' => '',
                                        'name' => 'file_ids[]',
                                        'accept' => '.jpeg,.jpg,.png,.mp4,.doc,.txt,.xls,.ppt,.pptx,.docx,.xlsx'
                                    ])
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    @include('components.forms.telegram-file-picker', [
                                        'placeholder' => '',
                                        'name' => 'file_ids[]',
                                        'accept' => '.jpeg,.jpg,.png,.mp4,.doc,.txt,.xls,.ppt,.pptx,.docx,.xlsx'
                                    ])
                                </div>
                                <div class="form-group mb-2">
                                    @include('components.forms.telegram-file-picker', [
                                        'placeholder' => '',
                                        'name' => 'file_ids[]',
                                        'accept' => '.jpeg,.jpg,.png,.mp4,.doc,.txt,.xls,.ppt,.pptx,.docx,.xlsx'
                                    ])
                                </div>
                                <div class="form-group mb-2">
                                    @include('components.forms.telegram-file-picker', [
                                        'placeholder' => '',
                                        'name' => 'file_ids[]',
                                        'accept' => '.jpeg,.jpg,.png,.mp4,.doc,.txt,.xls,.ppt,.pptx,.docx,.xlsx'
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <div class="form-group mb-4">
                            <label for="" class="form-label fs-14 text-dark">Сегменты</label>
                            @foreach(\App\Consts\UserStages::getTitles() as $code => $title)
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" role="switch" name="stages[]" value="{{ $code }}"
                                            id="flexSwitchCheckDefault_{{ $code }}" checked autocomplete="off">
                                    <label class="form-check-label" for="flexSwitchCheckDefault_{{ $code }}">{{ $title }} ({{ $stages_count->get($code, 0) }})</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group mb-4">
                            <label for="" class="form-label fs-14 text-dark">Тарифы</label>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input form-checked-success" type="checkbox" role="switch" name="tariffs[]" value="0"
                                        id="flexSwitchCheckDefaultTariff_0" checked autocomplete="off">
                                <label class="form-check-label" for="flexSwitchCheckDefaultTariff_0">Без тарифа ({{ $without_tariff_count }})</label>
                            </div>
                            @foreach($tariffs as $tariff)
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input form-checked-success" type="checkbox" role="switch" name="tariffs[]" value="{{ $tariff->id }}"
                                            id="flexSwitchCheckDefaultTariff_{{ $tariff->id }}" checked autocomplete="off">
                                    <label class="form-check-label" for="flexSwitchCheckDefaultTariff_{{ $tariff->id }}">{{ $tariff->name }} ({{ $tariff->users_count }})</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group mb-4">
                            <label for="" class="form-label fs-14 text-dark">Кнопки</label>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input form-checked-danger" type="checkbox" role="switch" name="buttons[]" value="buy2"
                                        id="flexSwitchCheckDefaultTariff_buy2" autocomplete="off">
                                <label class="form-check-label" for="flexSwitchCheckDefaultTariff_buy2">Купить 2 ступень</label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input form-checked-danger" type="checkbox" role="switch" name="buttons[]" value="test3"
                                        id="flexSwitchCheckDefaultTariff_test3" autocomplete="off">
                                <label class="form-check-label" for="flexSwitchCheckDefaultTariff_test3">Тестирование 3 ступень</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <label class="form-label">Тип платформы</label>
                        <select class="form-control" name="type" id="type">
                            <option value="all" selected>Все платформы</option>
                            <option value="telegram">Telegram</option>
                            <option value="max">MAX</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <label class="form-label">Запуск рассылки</label>
                        <select class="form-control" name="start_type" id="start_type">
                            <option value="now" selected>Запустить сейчас</option>
                            <option value="delayed">Отложенный запуск</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3 d-none" id="delayed_block">
                    <div class="col-3">
                        <label class="form-label">Текущее время сервера</label>
                        <input type="text" class="form-control" id="server_time" value="{{ now() }}" disabled>
                    </div>

                    <div class="col-3">
                        <label class="form-label">Время запуска</label>
                        <input type="datetime-local" class="form-control" name="start_at">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex align-items-center justify-content-end">
                    <button type="submit" class="btn btn-primary label-btn">
                        <i class="ri-play-fill label-btn-icon me-2"></i>
                        <span class="label-btn-icon" style="display: none">
                                        <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                        Запустить
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection
@push('scripts')
    <script>
        let serverTime = new Date("{{ now()->format('Y-m-d H:i:s') }}".replace(' ', 'T'));

        function updateServerTime() {

            serverTime.setSeconds(serverTime.getSeconds() + 1);

            let y = serverTime.getFullYear();
            let m = String(serverTime.getMonth() + 1).padStart(2, '0');
            let d = String(serverTime.getDate()).padStart(2, '0');

            let h = String(serverTime.getHours()).padStart(2, '0');
            let i = String(serverTime.getMinutes()).padStart(2, '0');
            let s = String(serverTime.getSeconds()).padStart(2, '0');

            $("#server_time").val(`${y}-${m}-${d} ${h}:${i}:${s}`);
        }

        setInterval(updateServerTime, 1000);

        $("#start_type").on("change", function () {
            if ($(this).val() === "delayed") {
                $("#delayed_block").removeClass("d-none");
            } else {
                $("#delayed_block").addClass("d-none");
            }
        });

        jsAjaxForm($("#my_form"), (json) => {
            successNotification('Рассылка создана!');
            setTimeout(() => {
                location.href = "{{ route('admin.mailing') }}";
            }, 500);
        });

        $(window).on('load', () => {
            $("#mail_textarea").summernote({
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['link'],
                    ['view', ['codeview']]
                ],
                allowedTags: [
                    'b', 'strong',
                    'i', 'em',
                    'u', 'ins',
                    's', 'strike', 'del',
                    'code', 'pre',
                    'a'
                ],
                allowedAttributes: {
                    'a': ['href']
                },
                height: 400,
                disableDragAndDrop: true,
                shortcuts: false
            });
        });

    </script>
@endpush
