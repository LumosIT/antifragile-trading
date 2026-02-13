@extends('admin.layouts.app')

@php($title = 'Пользователь ' . $user->name)

@section('title', $title);

@php($periods = [
                          \App\Consts\SubscriptionPeriods::DAY => 'дн.',
                          \App\Consts\SubscriptionPeriods::WEEK => 'нед.',
                          \App\Consts\SubscriptionPeriods::MONTH => 'мес.',
                          \App\Consts\SubscriptionPeriods::YEAR => 'г.'
                      ])

@section('content')

    @include('components.other.breadcrumbs', [
        'items' => [
            'Платежная система' => '#',
            'Пользователи' => route('admin.users'),
            $title
        ]
    ])

    <div class="row">
        <div class="col-10">
            <div class="card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        {{ $title }}
                    </div>
                    <div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            @if($user->is_banned)
                                <div class="ribbon-2 ribbon-danger ribbon-right">Заблокирован</div>
                            @elseif($user->is_alive)
                                <div class="ribbon-2 ribbon-success ribbon-right">Активен</div>
                            @else
                                <div class="ribbon-2 ribbon-danger ribbon-right">Ушёл</div>
                            @endif
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">Имя профиля</label>
                                <div class="input-group position-relative">
                                    <div class="input-group-text"><i class="ri-send-plane-fill"></i></div>
                                    <input type="text" class="form-control border-dashed" readonly value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">Юзернейм профиля</label>
                                <div class="input-group position-relative">
                                    <div class="input-group-text">@</div>
                                    <input type="text" class="form-control border-dashed" readonly value="{{ $user->username }}">
                                </div>
                            </div>
                                <div class="form-group mt-3">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input form-checked-success" type="checkbox" role="switch" value="1"
                                               id="flexSwitchCheckDefault_is_test_completed" @if($user->is_test_completed) checked @endif autocomplete="off">
                                        <label class="form-check-label" for="flexSwitchCheckDefault_is_test_completed">Доступна 3 ступень</label>
                                    </div>
                                </div>
                            <div class="form-group mt-3">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input form-checked-danger" type="checkbox" role="switch" value="1"
                                           id="flexSwitchCheckDefault_is_banned" @if($user->is_banned) checked @endif autocomplete="off">
                                    <label class="form-check-label" for="flexSwitchCheckDefault_is_banned">Заблокировать</label>
                                </div>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">ФИО</label>
                                <div class="input-group position-relative">
                                    <div class="input-group-text"><i class="ri-user-2-line"></i></div>
                                    <input type="text" class="form-control border-dashed" readonly value="{{ $user->fio }}" placeholder="Отсутствует">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">Телефон</label>
                                <div class="input-group position-relative">
                                    <div class="input-group-text"><i class="ri-phone-line"></i></div>
                                    <input type="text" class="form-control border-dashed" readonly value="{{ $user->phone }}" placeholder="Отсутствует">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">Почта</label>
                                <div class="input-group position-relative">
                                    <div class="input-group-text"><i class="ri-mail-add-line"></i></div>
                                    <input type="text" class="form-control border-dashed" readonly value="{{ $user->email }}" placeholder="Отсутствует">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-primary label-btn dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="ri-send-plane-fill me-2"></i>
                                Выдать приглашение
                            </button>
                            <ul class="dropdown-menu">
                                <a href="{{ route('admin.api.users.invite-second-stair', $user->id) }}" class="dropdown-item js-send-invite">Канал 2 ступень</a>
                                <a href="{{ route('admin.api.users.invite-third-stair', $user->id) }}" class="dropdown-item js-send-invite">Канал 3 ступень</a>
                                <a href="{{ route('admin.api.users.invite-third-stair-testing', $user->id) }}" class="dropdown-item js-send-invite">Тестирование 3 ступень</a>
                            </ul>
                        </div>
                        <a data-bs-toggle="modal" href="#offer_modal" class="btn label-btn btn-warning me-2">
                            <i class="ri-exchange-dollar-fill label-btn-icon me-2"></i>
                            Выдать оффер
                        </a>
                        <button type="button" class="btn btn-danger label-btn" id="kick" data-href="{{ route('admin.api.users.kick', $user->id) }}">
                            <i class="ri-kick-fill label-btn-icon me-2"></i>
                            <span class="label-btn-icon" style="display: none">
                                         <span class="spinner-border spinner-border-sm align-middle"></span>
                                    </span>
                            Исключить из каналов
                        </button>
                    </div>
                </div>
            </div>
            <form id="my_form" action="{{ route('admin.api.users.edit', $user->id) }}" class="card" method="post" autocomplete="off">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Тариф
                    </div>
                    <div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">Тариф</label>
                                <div class="input-group position-relative">
                                    <select class="form-control" name="tariff_id">
                                        <option value="">Нет</option>
                                        @foreach($tariffs as $tariff)
                                            <option @if($user->tariff_id === $tariff->id) selected @endif value="{{ $tariff->id }}">{{ $tariff->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">Дата окончания</label>
                                <div class="d-flex align-items-center justify-content-end">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="ri-calendar-2-line"></i>
                                        </div>
                                        <input type="text" class="form-control me-2 js-datetime-picker" placeholder="Выбрать" style="width: 200px;" value="{{ $user->tariff_expired_at ? $user->tariff_expired_at->format('d.m.Y H:i') : now()->format('d.m.Y H:i') }}" name="tariff_expired_at">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary label-btn">
                            <i class="ri-save-2-fill label-btn-icon me-2"></i>
                            <span class="label-btn-icon" style="display: none">
                                         <span class="spinner-border spinner-border-sm align-middle"></span>
                                    </span>
                            Сохранить
                        </button>
                    </div>
                </div>
            </form>
            @if($user->activeSubscription)
                <form id="my_form_subscription" action="{{ route('admin.api.subscriptions.edit', $user->activeSubscription->id) }}" class="card" method="post" autocomplete="off">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Автоматическая оплата
                        </div>
                        <div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group mb-4">
                                    <label for="" class="form-label fs-14 text-dark">Сумма</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control js-int-mask" name="amount" value="{{ $user->activeSubscription->amount }}" required>
                                        <span class="input-group-text">
                                            RUB
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-4">
                                    <label for="" class="form-label fs-14 text-dark">Период</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control js-int-mask" name="duration" value="{{ $user->activeSubscription->duration }}" required>
                                        <div style="width: 100px">
                                            <select name="period" id="" class="form-control">
                                                @foreach($periods as $k => $v)
                                                    <option value="{{ $k }}" @if($user->activeSubscription->period === $k) selected @endif>{{ $v }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-4">
                                    <label for="" class="form-label fs-14 text-dark">Дата следующего списания</label>
                                    <div class="d-flex align-items-center justify-content-end">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <i class="ri-calendar-2-line"></i>
                                            </div>
                                            <input type="text" class="form-control me-2 js-datetime-picker" placeholder="Выбрать" style="width: 200px;" value="{{ $user->activeSubscription->next_payment_at->format('d.m.Y H:i')}}" name="next_payment_at">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-end">
                            <button type="submit" class="btn btn-primary label-btn me-2">
                                <i class="ri-save-2-fill label-btn-icon me-2"></i>
                                <span class="label-btn-icon" style="display: none">
                                         <span class="spinner-border spinner-border-sm align-middle"></span>
                                    </span>
                                Сохранить
                            </button>
                            <button type="button" class="btn btn-danger label-btn" id="cancel_subscription" data-href="{{ route('admin.api.subscriptions.cancel', $user->activeSubscription->id) }}">
                                <i class="ri-close-large-fill label-btn-icon me-2"></i>
                                <span class="label-btn-icon" style="display: none">
                                         <span class="spinner-border spinner-border-sm align-middle"></span>
                                    </span>
                                Отменить
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
@push('modals')
    <div class="modal effect-rotate-left" id="offer_modal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.api.users.send-offer', $user->id) }}" class="modal-content" id="change_password_form" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="google_auth_inactive_modalLabel">Отправить оффер</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="user-secret-code" class="form-label fs-14 text-dark">Тариф</label>
                        <select name="tariff_id" class="form-control">
                            @foreach($tariffs as $tariff)
                                <option value="{{ $tariff->id }}">{{ $tariff->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary label-btn me-2" type="submit">
                        <i class="ri-exchange-dollar-fill label-btn-icon me-2"></i>
                        <span id="change_password_loader" class="label-btn-icon" style="display: none">
                             <span class="spinner-border spinner-border-sm align-middle"></span>
                         </span>
                        Отправить
                    </button>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('scripts')
    <script>

        jsAjaxForm($("#offer_modal form"), (json) => {

            successNotification('Оффер успешно отправлен!');

            $("#offer_modal").modal('hide');

        });

    </script>
    <script>


        $("#flexSwitchCheckDefault_is_banned").on('change', function(e){

            $.post("{{ route('admin.api.users.set-banned', $user->id) }}", {
                is_banned : +this.checked
            }).done(function(json){

                if(json.status){
                    successNotification('Успешно сохранено!');
                }else{
                    errorNotification(json.error);
                }

            });

        });

        $("#flexSwitchCheckDefault_is_test_completed").on('change', function(e){

            $.post("{{ route('admin.api.users.set-test-completed', $user->id) }}", {
                is_test_completed : +this.checked
            }).done(function(json){

                if(json.status){
                    successNotification('Успешно сохранено!');
                }else{
                    errorNotification(json.error);
                }

            });

        });



        jsAjaxForm($("#my_form"), (json) => {
            successNotification('Данные успешно сохранены');
        });

        jsAjaxForm($("#my_form_subscription"), (json) => {
            successNotification('Данные успешно сохранены');
        });

        $("#cancel_subscription").on('click', function(e){

            e.preventDefault();

            ajaxConfirmationModal(this.getAttribute('data-href'), 'Отменить подписку?', (m) => {

                successNotification('Подписка успешно отключена');

                location.reload();

            })


        });

        $(".js-send-invite").on('click', function(e){

            e.preventDefault();

            ajaxConfirmationModal(this.href, 'Отправить приглашение?', (m) => {
                successNotification('Приглашение успешно отправлено!');
                m.hide();
            });

        });

        $('#kick').on('click', function(e){

            e.preventDefault();

            ajaxConfirmationModal(this.getAttribute('data-href'), 'Исключить из каналов?', (m) => {
                successNotification('Пользователь исключен из каналов!');
                m.hide();
            });

        });


    </script>
@endpush
