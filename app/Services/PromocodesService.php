<?php

namespace App\Services;

/**
 * Сервис для работы с промо-кодами
 */

use App\Consts\PromocodeTypes;
use App\Consts\TariffPeriods;
use App\Exceptions\Promocodes\PromocodeNotAvailableException;
use App\Models\Promocode;
use App\Models\Tariff;
use Illuminate\Support\Str;

class PromocodesService
{

    /**
     * Генерация уникального кода
     */
    public function generate() : string
    {

        do{
            $code = mb_substr(Str::uuid(), 0, 8);
            $code = mb_strtolower($code);
        }while(Promocode::where('code', $code)->exists());

        return $code;

    }

    /**
     * Просчет скидки
     */
    public function calculate(Promocode $promocode, float $amount) : float
    {
        if($promocode->type === PromocodeTypes::AMOUNT){
            $amount = $amount - $promocode->value;
        }elseif($promocode->type === PromocodeTypes::PERCENT){
            $amount = $amount * (1 - ($promocode->value / 100));
        }

        return max(0, $amount);

    }

    /**
     * Использование промокода
     */
    public function use(Promocode $promocode) : void
    {

        $rows = Promocode::query()
            ->where('id', $promocode->id)
            ->whereColumn('current_uses', '<', 'max_uses')
            ->where('expired_at', '>', now())
            ->increment('current_uses');

        if(!$rows){
            throw new PromocodeNotAvailableException($promocode);
        }

    }

    public function isAvailableForTariff(Promocode $promocode, Tariff $tariff) : bool
    {
        return !!$promocode->tariffs()->find($tariff->id);
    }


    public function getBonusSeconds(Promocode $promocode) : int
    {
        if(!$promocode->bonus_period || $promocode->bonus_duration){
            return 0;
        }

        $now = now();

        switch($promocode->bonus_period){

            case TariffPeriods::DAY:
                $end = $now->clone()->addDays($promocode->bonus_duration);
                break;

            case TariffPeriods::WEEK:
                $end = $now->clone()->addWeeks($promocode->bonus_duration);
                break;

            case TariffPeriods::MONTH:
                $end = $now->clone()->addMonths($promocode->bonus_duration);
                break;

            case TariffPeriods::YEAR:
                $end = $now->clone()->addYears($promocode->bonus_duration);
                break;

            default:
                throw new \Exception('Unknown bonus period');

        }

        return $now->diffInSeconds(
            $end
        );

    }

}
