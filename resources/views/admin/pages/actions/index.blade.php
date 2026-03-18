@extends('admin.layouts.app')

@section('title', 'События в MAX')

@section('content')
<style>
    #actions_table_info, 
    #actions_table_wrapper > div:nth-child(1) > div:nth-child(2), 
    #actions_table_filter {
        display: none;
    }

    #actions_table_length > label > select {
        width: 50px;
    }
    
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 8px;
        padding: 5px 10px;
        border: 1px solid #ddd;
    }

    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px;
        padding: 5px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        margin: 0 2px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #696cff !important;
        color: #fff !important;
        border: none;
    }
</style>
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<div class="card custom-card">
    <div class="card-header justify-content-between">
        <div class="card-title">События в MAX</div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <div class="p-3 d-flex gap-2 flex-wrap">
                <input type="number" id="filter_user_id" class="form-control" placeholder="User ID" style="max-width: 150px;">

                <input type="text" id="filter_user_search" class="form-control" placeholder="Имя или юзернейм" style="max-width: 250px;">

                <select id="filter_action" class="form-select" style="max-width: 250px;">
                    <option value="">Все действия</option>
                    <option value="Получил приглашение">Получил приглашение</option>
                    <option value="Был добавлен в канал">Был добавлен в канал</option>
                    <option value="Самостоятельно покинул канал">Самостоятельно покинул канал</option>
                    <option value="Был исключён ботом из канала">Был исключён ботом из канала</option>
                </select>

                <select id="filter_channel" class="form-select" style="max-width: 200px;">
                    <option value="">Все каналы</option>
                    <option value="Вторая ступень">Вторая ступень</option>
                    <option value="Третья ступень">Третья ступень</option>
                </select>

                <input type="date" id="filter_date" class="form-control" style="max-width: 180px;" placeholder="Дата">

                <button id="apply_filters" class="btn btn-primary">Фильтр</button>
                <button id="reset_filters" class="btn btn-secondary">Сбросить фильтры</button>
            </div>

            <table class="table table-hover custom-datatables w-100 mt-2 mb-2" id="actions_table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Пользователь</th>
                        <th>Тариф</th>
                        <th>Действие</th>
                        <th>Канал</th>
                        <th>Дата</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#actions_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/admin/actions/data",
                data: function(d) {
                    d.user_id = $('#filter_user_id').val();
                    d.user_search = $('#filter_user_search').val();
                    d.action = $('#filter_action').val();
                    d.channel = $('#filter_channel').val();
                    d.date = $('#filter_date').val();
                }
            },
            dom: '<"d-flex justify-content-between align-items-center mb-2"f<"ms-auto"l>>rt<"d-flex justify-content-between mt-2"ip>',
            language: {
                processing: "Загрузка...",
                search: "Поиск:",
                lengthMenu: "Показать _MENU_ записей",
                info: "Показано _START_–_END_ из _TOTAL_",
                infoEmpty: "Нет данных",
                infoFiltered: "(отфильтровано из _MAX_)",
                loadingRecords: "Загрузка...",
                zeroRecords: "Ничего не найдено",
                emptyTable: "Данные отсутствуют",
                paginate: {
                    first: "Первая",
                    last: "Последняя",
                    next: "→",
                    previous: "←"
                }
            },
            columns: [
                {
                    data: 'user_id',
                    render: function(data) {
                        return `<u><a href="/admin/users/edit/${data}" target="_blank">${data}</a><u>`;
                    }
                },
                { 
                    data: 'user_info',
                    render: function(data) {
                        return data;
                    }
                },
                { 
                    data: 'tariff_info',
                    render: function(data) {
                        return data;
                    }
                },
                { data: 'action' },
                { data: 'channel' },
                { data: 'created_at' },
            ],

            order: [[0, 'desc']],
            pageLength: 10,
        });

         $('#actions_table').wrap('<div style="width: 100%; overflow: auto;"></div>');

         $('#apply_filters').on('click', function () {
            $('#actions_table').DataTable().ajax.reload();
        });

        $('#reset_filters').on('click', function() {
            $('#filter_user_id').val('');
            $('#filter_action').val('');
            $('#filter_channel').val('');
            $('#filter_date').val('');
            $('#filter_user_search').val('');
            $('#actions_table').DataTable().ajax.reload();
        });
    });
</script>

@endpush