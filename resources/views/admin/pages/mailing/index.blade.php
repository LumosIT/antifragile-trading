@extends('admin.layouts.app')

@section('title', 'Рассылки')

@section('content')

    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">
                Рассылки
            </div>
            <div>
                <a href="{{ route('admin.mailing.create') }}" class="btn btn-primary label-btn">
                    <i class="ri-add-line label-btn-icon me-2"></i>
                    Создать рассылку
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
            url : '{{ route('admin.api.mailing.list') }}',
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
                    name : 'Отпр.',
                    code : 'messages_count',
                    width: 150,
                    sortable: true,
                    data(row){

                        return `<span class="text-success">${row.messages_count}</span>/<span class="text-danger">${row.errors_count}</span> из <span>${row.users_count}</span>`;

                    }
                },
                {
                    name : 'Сегменты',
                    code : 'stages',
                    data(row){

                        let colors = {
                            "{{ \App\Consts\UserStages::NOT_START }}" : 'gray-500',
                            "{{ \App\Consts\UserStages::CANCEL_THIRD_PART }}" : 'danger-transparent',
                            "{{ \App\Consts\UserStages::CANCEL_SECOND_PART }}" : 'danger-transparent',
                            "{{ \App\Consts\UserStages::BUY_SECOND_PART }}" : 'success-transparent',
                            "{{ \App\Consts\UserStages::BUY_THIRD_PART }}" : 'success-transparent',
                        };

                        let titles = @json(\App\Consts\UserStages::getTitles());

                        return row.stages.map(function(stage){
                            return `<span class="badge badge-sm mb-1 bg-${colors[stage]}">${titles[stage]}</span>`
                        }).join('<br>')


                    }
                },
                {
                    name : 'Прогресс',
                    code : 'messages_count',
                    sortable: true,
                    width: 100,
                    data(row){

                       let colors = {
                            "{{ \App\Consts\MailingStatuses::IN_PROGRESS }}" : 'primary',
                           "{{ \App\Consts\MailingStatuses::PAUSED }}" : 'warning',
                           "{{ \App\Consts\MailingStatuses::STOPPED }}" : 'danger',
                           "{{ \App\Consts\MailingStatuses::FINISHED }}" : 'success',
                           "{{ \App\Consts\MailingStatuses::CREATED }}" : 'primary',
                       };

                       let value = ((row.messages_count + row.errors_count) / row.users_count * 100).toFixed(2);


                        return `  <div class="progress progress-xs"><div class="progress-bar bg-${colors[row.status]} progress-bar-striped progress-bar-animated" role="progressbar" style="width: ${value}%" aria-valuenow="${value}" aria-valuemin="0" aria-valuemax="100"></div></div>`;;

                    }
                },

                {
                    name : 'Текст',
                    code : 'text',
                    sortable: true,
                    data(row){

                        return `<pre class="bg-gray-100 p-2 rounded-3" style="word-break: break-all;white-space: break-spaces;">` + row.text + `</pre>`;

                    }
                },
                {
                    name : 'Статус',
                    code : 'status',
                    sortable: true,
                    data(row){

                        switch(row.status) {
                            case "{{ \App\Consts\MailingStatuses::CREATED }}":
                                return `<span class="badge bg-primary-transparent">Инициализация</span>`;

                            case "{{ \App\Consts\MailingStatuses::IN_PROGRESS }}":
                                return `<span class="badge bg-primary-transparent">В процессе</span>`;

                            case "{{ \App\Consts\MailingStatuses::PAUSED }}":
                                return `<span class="badge bg-warning-transparent">На паузе</span>`;

                            case "{{ \App\Consts\MailingStatuses::FINISHED }}":
                                return `<span class="badge bg-success-transparent">Завершена</span>`;

                            case "{{ \App\Consts\MailingStatuses::STOPPED }}":
                                return `<span class="badge bg-danger-transparent">Остановлена</span>`;

                        }

                    }
                },
                {
                    name : 'Дата',
                    code : 'created_at',
                    sortable: true,
                    data(row){
                        return htmlTemplateDate(row.created_at);
                    }
                },
                {
                    name : '',
                    code : 'ctrl',
                    textAlign: 'right',
                    data(row){

                        let stopRoute = "{{ route('admin.api.mailing.stop', ':param') }}".replace(':param', row.id);
                        let playRoute = "{{ route('admin.api.mailing.play', ':param') }}".replace(':param', row.id);
                        let pauseRoute = "{{ route('admin.api.mailing.pause', ':param') }}".replace(':param', row.id);


                        let html = '';

                        if(row.status === "{{ \App\Consts\MailingStatuses::PAUSED }}"){

                            html += `  <a href="${playRoute}" class="btn btn-icon btn-sm btn-primary-light btn-wave waves-effect waves-light js-play-datatable-button">
                                  <i class="ri-play-fill"></i>
                               </a>`;


                        }else if(row.status === "{{ \App\Consts\MailingStatuses::IN_PROGRESS }}"){

                            html += `  <a href="${pauseRoute}" class="btn btn-icon btn-sm btn-warning-light btn-wave waves-effect waves-light js-pause-datatable-button">
                                  <i class="ri-pause-fill"></i>
                               </a>`;

                        }

                        if(row.status !== "{{ \App\Consts\MailingStatuses::FINISHED }}" && row.status !== "{{ \App\Consts\MailingStatuses::STOPPED }}"){
                            html += `
                                  <a href="${stopRoute}" class="btn btn-icon btn-sm btn-danger-light btn-wave waves-effect waves-light js-stop-datatable-button">
                                      <i class="ri-stop-fill"></i>
                                   </a>
                           `;
                        }

                        return html;

                    }
                }
            ]
        });


        initDatatableRemoveButton(dataTable, '.js-stop-datatable-button', 'Остановить рассылку?');
        initDatatableRemoveButton(dataTable, '.js-play-datatable-button', 'Продолжить рассылку?');
        initDatatableRemoveButton(dataTable, '.js-pause-datatable-button', 'Приостановить рассылку?');

        initDatatableSearch(dataTable, $("#datatable_search"));

    </script>
@endpush
