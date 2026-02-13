@extends('admin.layouts.app')

@section('title', 'Статистика')

@section('content')

    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">
                Статистика
            </div>
        </div>
        <div class="card-body p-0">
            <form action="" method="post" autocomplete="off" class="d-flex align-items-center justify-content-between p-3" onsubmit="return false">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="ri-calendar-2-line"></i>
                        </div>
                        <input type="text" class="form-control me-2" id="filter_date" placeholder="Date range picker" style="width: 200px;">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card custom-card">
        <div class="card-body p-0">

            <table class="table">
                <tr>
                    <td>Регистрации</td>
                    <td id="stat_registers"></td>
                </tr>
                <tr>
                    <td>Активность (средняя)</td>
                    <td id="stat_activities"></td>
                </tr>
                <tr>
                    <td>Продажи (всего)</td>
                    <td id="stat_sells"></td>
                </tr>
                <tr>
                    <td>Продажи (новые)</td>
                    <td id="stat_sells_new"></td>
                </tr>
                <tr>
                    <td>Продажи (продления)</td>
                    <td id="stat_sells_continues"></td>
                </tr>
                <tr>
                    <td>Продажи (первые продления)</td>
                    <td id="stat_sells_continues_first"></td>
                </tr>
                <tr>
                    <td>Продажи (вернулся после отмены)</td>
                    <td id="stat_sells_after_cancel"></td>
                </tr>
                <tr>
                    <td>Отмена подписки</td>
                    <td id="stat_cancels"></td>
                </tr>
                <tr>
                    <td>Цель: принял правила</td>
                    <td id="stat_meta_is_accept_rules"></td>
                </tr>
                <tr>
                    <td>Цель: приобрел тариф</td>
                    <td id="stat_meta_is_buy"></td>
                </tr>
                <tr>
                    <td>Среднее время жизни клиента</td>
                    <td><span id="stat_died_time"></span> дн.</td>
                </tr>
                <tr>
                    <td>Среднее время до покупки</td>
                    <td><span id="stat_first_payment_time"></span> дн.</td>
                </tr>
            </table>

        </div>
    </div>

@endsection


@push('scripts')
    <script>

        !function(){

            function reloadStatistic() {
                $.post("{{ route('admin.api.statistic.global') }}", {from, to}).done(json => {

                    json = json.response;

                    function z(x) {

                        let z = x / json.count;
                        z = z || 0;
                        z = z * 100;
                        z = z.toFixed(2);

                        return z + '%';
                    }

                    $("#stat_registers").text(json.registers || 0);
                    $("#stat_activities").text(parseInt(json.activities || 0));
                    $("#stat_sells").text(json.sells || 0);
                    $("#stat_sells_new").text(json.sells_new || 0);
                    $("#stat_sells_continues").text(json.sells_continues || 0);
                    $("#stat_sells_continues_first").text(json.sells_continues_first || 0);
                    $("#stat_sells_after_cancel").text(json.sells_after_cancel || 0);
                    $("#stat_cancels").text(json.cancels || 0);

                    $("#stat_meta_is_accept_rules").text(z(json.meta_is_accept_rules || 0));
                    $("#stat_meta_is_buy").text(z(json.meta_is_buy || 0));

                    $("#stat_died_time").text((+json.died_time || 0).toFixed(2));
                    $("#stat_first_payment_time").text((+json.first_payment_time || 0).toFixed(2));

                });
            }

            let from = moment().subtract(1, 'months').format('DD.MM.yyyy');
            let to = moment().add(1, 'days').format('DD.MM.yyyy')

            flatpickr($('#filter_date').get(0), {
                mode: "range",
                dateFormat: "d.m.Y",
                disableMobile: true,
                defaultDate : [
                    from, to
                ],
                onChange(selectedDates, str, instance){

                    if(selectedDates.length > 1) {
                        from = instance.formatDate(selectedDates[0], "d.m.Y");
                        to = instance.formatDate(selectedDates[1], "d.m.Y");
                    }

                    reloadStatistic();

                }
            });

            reloadStatistic();

        }();
    </script>
@endpush
