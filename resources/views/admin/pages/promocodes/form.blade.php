@extends('admin.layouts.app')

@isset($promocode)
    @php($title = 'Редактирование промокода ' . $promocode->name)
@else
    @php($title = 'Создание промокода')
@endisset

@section('title', $title);

@php($types = [
    \App\Consts\PromocodeTypes::AMOUNT => 'RUB',
    \App\Consts\PromocodeTypes::PERCENT => '%'
])

@section('content')

    @include('components.other.breadcrumbs', [
        'items' => [
            'Управление' => '#',
            'Промокоды' => route('admin.promocodes'),
            $title
        ]
    ])

    <div class="row">
        <div class="col-12">
            <form id="my_form" action="{{ isset($promocode) ? route('admin.api.promocodes.edit', $promocode->id) : route('admin.api.promocodes.create') }}" class="card" method="post" autocomplete="off">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                       {{ $title }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">Код</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ri-hashtag"></i></div>
                                    <input type="text" class="form-control border-dashed text-uppercase" required name="code" value="{{ isset($promocode) ? $promocode->code : mb_substr(mb_strtoupper(Str::uuid()), 0, 8) }}" placeholder="Новичок">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">Скидка</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ri-discount-percent-fill"></i></div>
                                    <input type="text" class="form-control border-dashed js-int-mask" required name="value" value="{{ isset($promocode) ? $promocode->value : 1 }}" placeholder="1">
                                    <select name="type" class="form-control" required id="">
                                        @foreach($types as $k => $v)
                                            <option @if(isset($promocode) && $k === $promocode->type) selected @endif value="{{ $k }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input form-checked-primary" type="checkbox" role="switch" name="only_first_payment" value="1"
                                           id="flexSwitchCheckDefaultTariff_only_first_payment" @if(isset($promocode) && $promocode->only_first_payment) checked @endif autocomplete="off">
                                    <label class="form-check-label" for="flexSwitchCheckDefaultTariff_only_first_payment">Только на первую оплату</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">Тарифы</label>
                                @foreach($tariffs as $tariff)
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input form-checked-success" type="checkbox" role="switch" name="tariffs[]" value="{{ $tariff->id }}"
                                               id="flexSwitchCheckDefaultTariff_{{ $tariff->id }}" @if(!isset($promocode) || $promocode->tariffs->firstWhere('id', $tariff->id)) checked @endif autocomplete="off">
                                        <label class="form-check-label" for="flexSwitchCheckDefaultTariff_{{ $tariff->id }}">{{ $tariff->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">Максимально использований</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ri-sort-asc"></i></div>
                                    <input type="text" class="form-control border-dashed js-mask-int" required name="max_uses" value="{{ isset($promocode) ? $promocode->max_uses : 1 }}" placeholder="Новичок">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">Действителен до</label>
                                <div class="d-flex align-items-center justify-content-end">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="ri-calendar-2-line"></i>
                                        </div>
                                        <input type="text" class="form-control me-2 js-date-picker" placeholder="Выбрать" style="width: 200px;" value="{{ isset($promocode) ? $promocode->expired_at->format('d.m.Y') : now()->addWeek()->format('d.m.Y') }}" name="expired_at">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mb-4">
                                <label for="" class="form-label fs-14 text-dark">Бонус подписки</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ri-time-line"></i></div>
                                    <input type="text" class="form-control border-dashed js-int-mask" required name="bonus_duration" value="{{ isset($promocode) ? $promocode->bonus_duration : 0 }}" placeholder="0">
                                    <div style="width: 100px;">
                                        <select id="" class="form-control w-100" name="bonus_period" required>

                                            @php($periods = [
                                                \App\Consts\PromocodeBonusPeriods::DAY => 'дн.',
                                                \App\Consts\PromocodeBonusPeriods::WEEK => 'нед.',
                                                \App\Consts\PromocodeBonusPeriods::MONTH => 'мес.',
                                                \App\Consts\PromocodeBonusPeriods::YEAR => 'г.',
                                            ])

                                            @foreach($periods as $key => $text)
                                                <option @if(isset($promocode) && $promocode->bonus_period === $key) selected @endif value="{{ $key }}">{{ $text }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        @isset($promocode)
                            <button type="submit" class="btn btn-primary label-btn">
                                <i class="ri-save-2-fill label-btn-icon me-2"></i>
                                <span class="label-btn-icon" style="display: none">
                                         <span class="spinner-border spinner-border-sm align-middle"></span>
                                    </span>
                                Сохранить
                            </button>
                        @else
                            <button type="submit" class="btn btn-primary label-btn">
                                <i class="ri-add-line label-btn-icon me-2"></i>
                                <span class="label-btn-icon" style="display: none">
                                         <span class="spinner-border spinner-border-sm align-middle"></span>
                                    </span>
                                Создать промокод
                            </button>
                        @endisset
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('scripts')
    <script>

        jsAjaxForm($("#my_form"), (json) => {

            @isset($promocode)
                successNotification('Промокод успешно сохранен');
            @else

                successNotification('Промокод успешно создан!');

                setTimeout(() => {
                    location.href = "{{ route('admin.promocodes.edit', ':param') }}".replace(':param', json.response.id);
                }, 500);

            @endisset

        });

    </script>
@endpush
