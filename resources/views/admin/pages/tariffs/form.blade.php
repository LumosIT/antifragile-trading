@extends('admin.layouts.app')

@isset($tariff)
    @php($title = 'Редактирование тарифа ' . $tariff->name)
@else
    @php($title = 'Создание тарифа')
@endisset

@section('title', $title)

@php($modes = [
                                          \App\Consts\TariffModes::SIMPLE => '2 ступень',
                                          \App\Consts\TariffModes::FULL => '2 и 3 ступень'
                                      ])

@php($periods = [
                                    \App\Consts\TariffPeriods::DAY => 'дн.',
                                    \App\Consts\TariffPeriods::WEEK => 'нед.',
                                    \App\Consts\TariffPeriods::MONTH => 'мес.',
                                    \App\Consts\TariffPeriods::YEAR => 'г.',

                                ])

@section('content')

    @include('components.other.breadcrumbs', [
        'items' => [
            'Управление' => '#',
            'Тарифы' => route('admin.tariffs'),
            $title
        ]
    ])

    <div class="row">
        <div class="col-6">
            <form id="my_form" action="{{ isset($tariff) ? route('admin.api.tariffs.edit', $tariff->id) : route('admin.api.tariffs.create') }}" class="card" method="post" autocomplete="off">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                       {{ $title }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label for="" class="form-label fs-14 text-dark">Название</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-book-2-line"></i></div>
                            <input type="text" class="form-control border-dashed" required name="name" value="{{ isset($tariff) ? $tariff->name : '' }}" placeholder="Новичок">
                        </div>
                    </div>
                   <div class="row">
                       <div class="col-6">
                           <div class="form-group mb-4">
                               <label for="" class="form-label fs-14 text-dark">Тип</label>
                               <div class="input-group">
                                   <div class="input-group-text"><i class="ri-ruler-2-line"></i></div>
                                   <select id="" class="form-control" name="mode" required>
                                       @foreach($modes as $key => $text)
                                           <option @if(isset($tariff) && $tariff->mode === $key) selected @endif value="{{ $key }}">{{ $text }}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                       </div>
                       <div class="col-6">
                           <div class="form-group mb-4">
                               <label for="" class="form-label fs-14 text-dark">Цена</label>
                               <div class="input-group">
                                   <div class="input-group-text"><i class="ri-price-tag-3-fill"></i></div>
                                   <input type="text" class="form-control border-dashed js-int-mask" required name="price" value="{{ isset($tariff) ? $tariff->price : '' }}" placeholder="100">
                                   <div class="input-group-text">RUB</div>
                               </div>
                           </div>
                       </div>
                   </div>

                    <div class="form-group mb-4">
                        <label for="" class="form-label fs-14 text-dark">Длительность</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-time-line"></i></div>
                            <input type="text" class="form-control border-dashed js-int-mask" required name="duration" value="{{ isset($tariff) ? $tariff->duration : '' }}" placeholder="1">
                            <div style="width: 100px;">
                                <select id="" class="form-control w-100" name="period" required>
                                    @foreach($periods as $key => $text)
                                        <option @if(isset($tariff) && $tariff->period === $key) selected @endif value="{{ $key }}">{{ $text }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        @isset($tariff)
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
                                Создать тариф
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

            @isset($tariff)
                successNotification('Тариф успешно сохранен');
            @else

                successNotification('Тариф успешно создан!');

                setTimeout(() => {
                    location.href = "{{ route('admin.tariffs.edit', ':param') }}".replace(':param', json.response.id);
                }, 500);

            @endisset

        });

    </script>
@endpush
