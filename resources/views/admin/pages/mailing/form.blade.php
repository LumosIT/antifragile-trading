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
