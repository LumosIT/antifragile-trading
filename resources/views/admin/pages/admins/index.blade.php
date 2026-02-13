@extends('admin.layouts.app')

@section('title', 'Сотрудники')

@section('content')

    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">
                Сотрудники
            </div>
            <div>
                <a href="{{ route('admin.admins.create') }}" class="btn btn-primary label-btn">
                    <i class="ri-add-line label-btn-icon me-2"></i>
                    Создать администратора
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
                            <label for="" class="fs-12">Роль</label>
                            <select class="form-control w-100" data-trigger name="choices-single-default" id="filter_role">
                                <option value="">Любая</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
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
            url : '{{ route('admin.api.admins.list') }}',
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
                    name : 'Логин',
                    code : 'login',
                    data(row){

                        return htmlize(row.login);

                    }
                },
                {
                    name : 'Роль',
                    code : 'role_id',
                    data(row){

                        return '<span class="badge bg-warning-transparent">' + htmlize(row.role.name) + '</span>';

                    }
                },
                {
                    name : '',
                    code : 'ctrl',
                    textAlign: 'right',
                    data(row){

                        let editRoute = "{{ route('admin.admins.edit', ':param') }}".replace(':param', row.id),
                            removeRoute = "{{ route('admin.api.admins.remove', ':param') }}".replace(':param', row.id);

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


        initDatatableRemoveButton(dataTable, '.js-remove-datatable-button', 'Удалить администратора?');
        initDatatableSearch(dataTable, $("#datatable_search"));
        initDatatableFilter(dataTable, 'role_id', $("#filter_role"));

    </script>
@endpush
