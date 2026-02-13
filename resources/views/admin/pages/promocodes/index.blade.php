@extends('admin.layouts.app')

@section('title', 'Промокоды')

@section('content')

    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">
                Промокоды
            </div>
            <div>
                <a href="{{ route('admin.promocodes.create') }}" class="btn btn-primary label-btn">
                    <i class="ri-add-line label-btn-icon me-2"></i>
                    Создать промокод
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <form action="" method="post" autocomplete="off" class="d-flex align-items-center justify-content-between p-3" onsubmit="return false">
                <input class="form-control me-2" id="datatable_search" placeholder="Поиск..." style="width:200px">
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
            url : '{{ route('admin.api.promocodes.list') }}',
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
                    name : 'Код',
                    code : 'code',
                    sortable: true,
                    data(row){

                        return htmlize(row.code.toUpperCase());

                    }
                },
                {
                    name : 'Скидка',
                    code : 'value',
                    sortable: true,
                    data(row){

                      let data = '', color = '', symbol = '';
                      if(row.type === "{{ \App\Consts\PromocodeTypes::PERCENT }}"){
                          color = 'warning';
                          symbol = '%';
                      }else{
                          color = 'primary';
                          symbol = ' RUB';
                      }

                      data += `<span class="badge bg-${color}-transparent">${ row.value + symbol }</span>`

                      if(row.only_first_payment){
                          data += `<span class="badge bg-${color}-transparent mx-1">
                              <i class="ri ri-time-fill"></i>
                          </span>`;
                      }

                      return data;

                    }
                },
                {
                    name : 'Бонус',
                    code : 'bonus_duration',
                    sortable: true,
                    data(row){

                        @php($periods = [
                                              \App\Consts\PromocodeBonusPeriods::DAY => 'дн.',
                                              \App\Consts\PromocodeBonusPeriods::WEEK => 'нед.',
                                              \App\Consts\PromocodeBonusPeriods::MONTH => 'мес.',
                                              \App\Consts\PromocodeBonusPeriods::YEAR => 'г.',
                                          ])

                        if(!row.bonus_duration){
                            return '';
                        }

                        let periods = @json($periods);

                        return `<span class="badge bg-success-transparent">${ row.bonus_duration } ${ periods[row.bonus_period] }</span>`;

                    }
                },
                {
                    name : 'Использовано',
                    code : 'current_uses',
                    sortable: true,
                    data(row){
                        return row.current_uses + '/' + row.max_uses;
                    }
                },
                {
                    name : 'Действителен до',
                    code : 'expired_at',
                    sortable: true,
                    data(row){
                        return moment(row.expired_at).format('DD.MM.yyyy');
                    }
                },
                {
                    name : 'Тарифы',
                    code : 'tariffs',
                    sortable: false,
                    data(row){

                        return row.tariffs.map(function(tariff){
                            return `<span class="badge bg-secondary-transparent me-2">${ tariff.name }</span>`;
                        }).join('');

                    }
                },
                {
                    name : '',
                    code : 'ctrl',
                    textAlign: 'right',
                    data(row){

                        let editRoute = "{{ route('admin.promocodes.edit', ':param') }}".replace(':param', row.id),
                            removeRoute = "{{ route('admin.api.promocodes.remove', ':param') }}".replace(':param', row.id);

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

    </script>
@endpush
