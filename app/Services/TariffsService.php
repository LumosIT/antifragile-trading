<?php

namespace App\Services;

use App\Consts\TariffPeriods;
use App\Models\Tariff;
use Carbon\Carbon;

class TariffsService
{

    public function __construct()
    {

    }


    /**
     * Methods
     */
    public function getEndTime(Tariff $tariff, Carbon $date) : Carbon
    {

        switch($tariff->period){

            case TariffPeriods::DAY:
                return $date->clone()->addDays($tariff->duration);

            case TariffPeriods::WEEK:
                return $date->clone()->addWeeks($tariff->duration);

            case TariffPeriods::MONTH:
                return $date->clone()->addMonths($tariff->duration);

            case TariffPeriods::YEAR:
                return $date->clone()->addYears($tariff->duration);

        }

        throw new \Exception('Undefined tariff period value');

    }

    public function getDurationSeconds(Tariff $tariff) : int
    {

        $now = now();

        return $now->diffInSeconds(
            $this->getEndTime($tariff, $now)
        );

    }

//    public function getDurationText(Tariff $tariff) : string
//    {
//
//        switch($tariff->period){
//            case TariffPeriods::DAY:
//                return \morphos\Russian\pluralize($tariff->duration, 'день');
//            case TariffPeriods::WEEK:
//                return \morphos\Russian\pluralize($tariff->duration, 'неделя');
//            case TariffPeriods::MONTH:
//                return \morphos\Russian\pluralize($tariff->duration, 'месяц');
//            case TariffPeriods::YEAR:
//                return \morphos\Russian\pluralize($tariff->duration, 'год');
//
//        }
//
//    }


}
