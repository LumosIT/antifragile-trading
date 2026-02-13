@extends('admin.layouts.app')

@section('title', 'Роли')

@section('content')

    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">
                Роли
            </div>
            <div>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary label-btn">
                    <i class="ri-add-line label-btn-icon me-2"></i>
                    Создать роль
                </a>
            </div>
        </div>
        <div class="card-body p-0">
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

        let titles = @json(Permissions::getTitles());

        let dataTable = $("#datatable_custom").CustomDataTables({
            url : '{{ route('admin.api.roles.list') }}',
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
                    data(row){

                        return htmlize(row.name);

                    }
                },
                {
                    name : 'Права',
                    code : 'permissions',
                    data(row){

                        return `<div style="white-space: normal">` + row.permissions.map(permission => {

                            return `<span class="badge bg-primary-transparent me-1 mb-1">${ htmlize(titles[permission]) }</span>`;

                        }).join('') + `</div>`;

                    }
                },
                {
                    name : '',
                    code : 'ctrl',
                    textAlign: 'right',
                    data(row){

                        let editRoute = "{{ route('admin.roles.edit', ':param') }}".replace(':param', row.id),
                            removeRoute = "{{ route('admin.api.roles.remove', ':param') }}".replace(':param', row.id);

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

    </script>
@endpush
