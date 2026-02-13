@extends('admin.layouts.app')

@section('title', 'Платежи')

@section('content')

    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">
                Платежи
            </div>
        </div>
        <div class="card-body p-0">
            <form action="" method="post" autocomplete="off" class="d-flex align-items-center justify-content-between p-3" onsubmit="return false">
                <input class="form-control me-2" id="datatable_search" placeholder="Поиск..." style="width:200px">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="ri-calendar-2-line"></i>
                        </div>
                        <input type="text" class="form-control me-2" id="filter_date" placeholder="Date range picker" style="width: 200px;">
                    </div>
                    <button class="btn btn-white flex-shrink-0 datatable_filters_button" type="button">
                        <i class="ri-filter-3-line"></i>
                        Фильтра
                    </button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover" id="datatable_custom">
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
            url : '{{ route('admin.api.payments.list') }}',
            limit : 30,
            prepareResponse(json){
                return json.response;
            },
            columns : [
                {
                    name : 'ID',
                    code : 'id',
                    sortable : true,
                    width: 100,
                    data(row){
                        return row.id;
                    }
                },
                {
                    name : 'Пользователь',
                    code : 'user',
                    data(row){

                        let route = "{{ route('admin.users.edit', ':param') }}".replace(':param', row.user.id);

                        return htmlTemplateUser(
                            row.user.name,
                            row.user.username || '',
                            route,
                            row.user.picture
                        );

                    }
                },
                {
                    name : 'Сумма',
                    code : 'amount',
                    sortable: true,
                    data(row){
                        return `
                            <div>
                               <a href="javascript:void(0);" class="fw-medium text-success">${ formatNumber(row.amount, 0) } RUB</a>
                               <span class="d-block text-muted fs-10">${ htmlize(row.hash) }</span>
                            </div>`
                    }
                },
                {
                    name : 'Дата',
                    code : 'created_at',
                    sortable : true,
                    data(row){

                        return htmlTemplateDate(row.created_at);

                    }
                }
            ]
        });


        initDatatableSearch(dataTable, $("#datatable_search"));
        initDatatableDateFilter(dataTable, $("#filter_date"));



    </script>
@endpush
