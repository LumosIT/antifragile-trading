@extends('admin.layouts.app')

@section('title', 'Пользователи')

@section('content')

    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">Пользователи</div>
            <div class="text-muted fs-13">
                На странице отображено <span id="users_count_page" style="font-weight: bold">0</span> из <b>{{ App\Models\User::query()->count() }}</b> пользователей
            </div>
        </div>
        <div class="card-body p-0">
            <form action="" method="post" autocomplete="off"
                class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center justify-content-between gap-2 p-3"
                onsubmit="return false">

                {{-- Левая часть --}}
                <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-lg-auto">
                    <input class="form-control" type="number" id="filter_user_id" placeholder="ID пользователя">
                    <input class="form-control" id="datatable_search" placeholder="Поиск...">
                </div>

                {{-- Правая часть --}}
                <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2 w-100 w-lg-auto">

                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="ri-calendar-2-line"></i>
                        </div>
                        <input type="text" class="form-control" id="filter_date" placeholder="Date range picker">
                    </div>

                    <button class="btn btn-white flex-shrink-0 datatable_filters_button" type="button">
                        <i class="ri-filter-3-line"></i>
                        Фильтр
                    </button>
                </div>

                {{-- Скрытые фильтры --}}
                <div class="d-none">
                    <div class="py-2 datatable_filters w-100">

                        <div class="form-group mb-3">
                            <label class="fs-12">Платформа</label>
                            <select class="form-control w-100" id="filter_type">
                                <option value="">Не важно</option>
                                <option value="telegram">Telegram</option>
                                <option value="max">MAX</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fs-12">Заблокирован</label>
                            <select class="form-control w-100" id="filter_banned">
                                <option value="">Не важно</option>
                                <option value="1">Есть</option>
                                <option value="0">Нет</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fs-12">Статус</label>
                            <select class="form-control w-100" id="filter_alive">
                                <option value="">Не важно</option>
                                <option value="1">Активен</option>
                                <option value="0">Ушёл</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fs-12">Сегмент</label>
                            <select class="form-control w-100" id="filter_stage">
                                <option value="">Не важно</option>
                                @foreach(App\Consts\UserStages::getTitles() as $code => $title)
                                    <option value="{{ $code }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fs-12">Тарифы</label>
                            <select class="form-control w-100" id="filter_tariff_id">
                                <option value="">Не важно</option>
                                @foreach($tariffs as $tariff)
                                    <option value="{{ $tariff->id }}">{{ $tariff->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
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
            url : "{{ route('admin.api.users.list') }}",
            limit : 30,
            prepareResponse(json){
                let resp = json.response;
                $("#users_count_page").text(resp.items.length);

                return resp;
            },
            columns : [
                {
                    name : 'ID',
                    code : 'id',
                    sortable : true,
                    width: 100,
                    data(row) {
                        return row.id;
                    }
                },
                {
                    name : 'Тип',
                    code : 'type',
                    sortable : true,
                    width: 100,
                    data(row) {
                        let html = '';

                        if (/^\d+$/.test(row.chat)) {
                            html += '<div>Telegram</div>';
                        }

                        if(row.max_chat) {
                            html += '<div>MAX</div>'
                        }

                        return html;
                    }
                },
                {
                    name: 'Админ',
                    code: 'stage',
                    sortable : true,
                    width: 100,
                    data(row) {
                        if(row.stage == 100) {
                            return '<u style="cursor: pointer" class="btn btn-success btn-sm toggle-admin-stage" data-target="remove" data-id="'+row.id+'">Админ</u>';
                        } else {
                            return '<u style="cursor: pointer" class="btn btn-light btn-sm toggle-admin-stage" data-target="get" data-id="'+row.id+'">Пользователь</u>';
                        }
                    }
                },
                {
                    name : 'Пользователь',
                    code : 'user',
                    data(row){

                        let route = "{{ route('admin.users.edit', ':param') }}".replace(':param', row.id);

                        return htmlTemplateUser(
                            row.name,
                            row.username || '',
                            route,
                            row.picture
                        );

                    }
                },
                {
                    name : 'ФИО',
                    code : 'fio',
                    sortable : true,
                    data(row){
                        return htmlize(row.fio || 'Нет');
                    }
                },
                {
                    name : 'Контакты',
                    data(row){
                        return `
                            <div>
                               <a href="javascript:void(0);" class="fw-medium">${ htmlize(row.phone || 'Нет телефона') }</a>
                               <span class="d-block text-muted fs-10">${ htmlize(row.email || 'Нет почты') }</span>
                            </div>`
                    }
                },
                {
                    name : 'Сегмент',
                    code : 'stage',
                    data(row){

                        let colors = {
                            "{{ \App\Consts\UserStages::NOT_START }}" : 'gray-500',
                            "{{ \App\Consts\UserStages::ADMIN }}" : 'primary',
                            "{{ \App\Consts\UserStages::COMPLETE_PRE_FORM }}" : 'warning-transparent',
                            "{{ \App\Consts\UserStages::CANCEL_THIRD_PART }}" : 'danger-transparent',
                            "{{ \App\Consts\UserStages::CANCEL_SECOND_PART }}" : 'danger-transparent',
                            "{{ \App\Consts\UserStages::BUY_SECOND_PART }}" : 'success-transparent',
                            "{{ \App\Consts\UserStages::BUY_THIRD_PART }}" : 'success-transparent',
                        };

                        let titles = @json(\App\Consts\UserStages::getTitles());

                        return `<span class="badge bg-${colors[row.stage]}">${titles[row.stage]}</span>`;

                    }
                },
                {
                    name : 'Статус',
                    code : 'is_alive',
                    data(row){

                        if(!row.is_alive) {
                            return `<span class="badge bg-danger-transparent">Ушёл</span>`;
                        }else{
                            return `<span class="badge bg-success-transparent">Активен</span>`;
                        }

                    }
                },
                {
                    name : 'Тариф',
                    code : 'tariff_expired_at',
                    sortable : true,
                    data(row){

                        if(row.tariff_id){
                            return `
                                <div>
                                   <a href="javascript:void(0);" class="fw-medium">${row.tariff.name}</a>
                                   <span class="d-block text-muted fs-10">${moment(row.tariff_expired_at).format('DD.MM.yyyy')}</span>
                                </div>`
                        }else{
                            return 'Нет';
                        }

                    }
                },
                {
                    name : 'Регистрация',
                    code : 'created_at',
                    sortable : true,
                    data(row){

                        return htmlTemplateDate(row.created_at);

                    }
                },
                {
                    name : 'Активность',
                    code : 'last_activity_at',
                    sortable : true,
                    data(row){

                        return htmlTemplateDate(row.last_activity_at);

                    }
                },
                {
                    name: '',
                    code: 'ctrl',
                    textAlign: 'right',
                    width: 150,
                    data(row) {

                        let route = "{{ route('admin.users.edit', ':param') }}".replace(':param', row.id);
                        let remove = "{{ route('admin.api.users.remove', ':param') }}".replace(':param', row.id);


                        let links = `

                        `;

                        if(row.username && row.type === 'telegram') {
                            links += `<a href="https://t.me/${htmlize(row.username)}" class="btn btn-icon btn-sm btn-primary-light btn-wave waves-effect waves-light me-1" target="_blank">
                                  <i class="ri-send-plane-fill"></i>
                               </a>`;
                        }

                        links += `<a href="${route}" class="btn btn-icon btn-sm btn-warning-light btn-wave waves-effect waves-light me-1">
                                  <i class="ri-eye-line"></i>
                               </a>`;

                        links += `<a href="${remove}" class="btn btn-icon btn-sm btn-danger-light btn-wave waves-effect waves-light js-remove-datatable-button">
                                  <i class="ri-delete-bin-2-fill"></i>
                               </a>`;

                        return links;

                    }
                }
            ]
        });


        initDatatableSearch(dataTable, $("#datatable_search"));
        initDatatableDateFilter(dataTable, $("#filter_date"));
        initDatatableFilter(dataTable, 'is_banned', $("#filter_banned"));
        initDatatableFilter(dataTable, 'is_alive', $("#filter_alive"));
        initDatatableFilter(dataTable, 'stage', $("#filter_stage"));
        initDatatableFilter(dataTable, 'tariff_id', $("#filter_tariff_id"));
        initDatatableFilter(dataTable, 'type', $("#filter_type"));
        initDatatableFilter(dataTable, 'user_id', $("#filter_user_id"));

        let userIdTimer = null;
        $("#filter_user_id").on("keyup", function () {
            clearTimeout(userIdTimer);
            userIdTimer = setTimeout(() => {
                $(this).trigger("change");
            }, 400);
        });

        initDatatableRemoveButton(dataTable, '.js-remove-datatable-button', 'Удалить пользователя?');

        $(document).on('click', '.toggle-admin-stage', function (e) {
            e.preventDefault();

            let el = $(this);

            if (el.data('loading')) {
                return;
            }

            let id = el.data('id');
            let target = el.data('target');

            if (!id || !target) {
                console.error('Некорректные данные для смены статуса');
                return;
            }

            if (!['get', 'remove'].includes(target)) {
                console.error('Некорректное действие');
                return;
            }

            let confirmText = target === 'get'
                ? 'Сделать пользователя администратором?'
                : 'Убрать пользователя из администраторов?';

            if (!confirm(confirmText)) {
                return;
            }

            el.data('loading', true);

            $.ajax({
                url: "{{ route('admin.api.users.toggleStage') }}",
                method: "POST",
                data: {
                    id: id,
                    target: target,
                    _token: "{{ csrf_token() }}"
                },
                success(response) {
                    dataTable.reload();
                },
                error(xhr) {
                    alert('Ошибка при изменении статуса');
                },
                complete() {
                    el.data('loading', false);
                }
            });

        });
    </script>
@endpush
