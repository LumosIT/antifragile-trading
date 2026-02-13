@extends('admin.layouts.app')

@section('title', 'Тарифы')

@php($periods = [
                          \App\Consts\TariffPeriods::DAY => 'дн.',
                          \App\Consts\TariffPeriods::WEEK => 'нед.',
                          \App\Consts\TariffPeriods::MONTH => 'мес.',
                          \App\Consts\TariffPeriods::YEAR => 'г.'
                      ])

@php($modes = [
                                          \App\Consts\TariffModes::SIMPLE => '2 ступень',
                                          \App\Consts\TariffModes::FULL => '2 и 3 ступень'
                                      ])

@section('content')

    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">
                Тарифы
            </div>
            <div>
                <a href="{{ route('admin.tariffs.create') }}" class="btn btn-primary label-btn">
                    <i class="ri-add-line label-btn-icon me-2"></i>
                    Создать тариф
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <form action="" method="post" autocomplete="off" class="d-flex align-items-center justify-content-between p-3" onsubmit="return false">
                <input class="form-control me-2" id="datatable_search" placeholder="Поиск..." style="width:200px">
                <div class="d-flex align-items-center justify-content-end">
                    <button class="btn btn-white flex-shrink-0 datatable_filters_button" type="button">
                        <i class="ri-filter-3-line"></i>
                        Фильтра
                    </button>
                </div>
                <div class="d-none">
                    <div id="" class="py-2 datatable_filters" style="width: 200px;">
                        <div class="form-group mb-3">
                            <label for="" class="fs-12">Тип</label>
                            <select class="form-control w-100" data-trigger name="choices-single-default" id="filter_mode">
                                <option value="">Любая</option>
                                @foreach($modes as $k => $v)
                                    <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="fs-12">Активен</label>
                            <select class="form-control w-100" data-trigger name="choices-single-default" id="filter_is_active">
                                <option value="">Любая</option>
                                <option value="1">Да</option>
                                <option value="0">Нет</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table text-nowrap table-hover" id="datatable_custom">
                    <thead></thead>
                    <tbody>
                        <tr>
                            <td colspan="20" class="text-center py-3 text-muted">Загрузка данных...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        let dataTable = $("#datatable_custom").CustomDataTables({
            url : '{{ route('admin.api.tariffs.list') }}',
            limit : 30,
            prepareResponse(json){
                return json.response;
            },
            columns : [
                {
                    name : 'ID',
                    code : 'id',
                    sortable : true,
                    width: 150,
                    data(row){
                        return row.id;
                    }
                },
                {
                    name : 'Название',
                    code : 'name',
                    sortable: true,
                    data(row){

                        return htmlize(row.name);

                    }
                },
                {
                    name : 'Тип',
                    code : 'mode',
                    sortable: true,
                    data(row){

                      if(row.mode === "{{ \App\Consts\TariffModes::FULL }}"){
                          return `<span class="badge bg-warning-transparent">2 и 3 ступень</span>`;
                      }else{
                          return `<span class="badge bg-primary-transparent">2 ступень</span>`;
                      }

                    }
                },
                {
                    name : 'Длительность',
                    code : 'duration',
                    sortable: true,
                    data(row){

                        let periods = @json($periods)

                       return row.duration + ' ' + periods[row.period];

                    }
                },
                {
                    name : 'Активен',
                    code : 'is_active',
                    sortable: true,
                    data(row){

                        let route = "{{ route('admin.api.tariffs.set-active', ':param') }}".replace(':param', row.id);

                        return htmlTemplateSwitch({
                            className : "js-tariff-is-active",
                            value : route,
                            checked : row.is_active
                        });

                    }
                },
                {
                    name : '',
                    code : 'ctrl',
                    textAlign: 'right',
                    data(row){

                        let editRoute = "{{ route('admin.tariffs.edit', ':param') }}".replace(':param', row.id),
                            removeRoute = "{{ route('admin.api.tariffs.remove', ':param') }}".replace(':param', row.id);

                        return `
                             <a href="${editRoute}" class="btn btn-icon btn-sm btn-info-light btn-wave waves-effect waves-light">
                                  <i class="ri-pencil-line"></i>
                               </a>
                              <a href="${removeRoute}" class="btn btn-icon btn-sm btn-danger-light btn-wave waves-effect waves-light js-remove-datatable-button">
                                  <i class="ri-delete-bin-2-line"></i>
                               </a>
                        `;

                    }
                }
            ]
        });


        initDatatableRemoveButton(dataTable, '.js-remove-datatable-button', 'Удалить роль?');
        initDatatableSearch(dataTable, $("#datatable_search"));
        initDatatableFilter(dataTable, 'mode', $("#filter_mode"));
        initDatatableFilter(dataTable, 'is_active', $("#filter_is_active"));

    </script>
    <script>

        $(document).on('change', '.js-tariff-is-active', function(){

            $.post(this.value, {
                is_active : +this.checked
            });

        });

    </script>
@endpush
