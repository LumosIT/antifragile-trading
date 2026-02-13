<?php

namespace App\Http\Controllers\Admin;

use App\Consts\PromocodeBonusPeriods;
use App\Consts\PromocodeTypes;
use App\Models\Promocode;
use App\Models\PromocodeTariff;
use App\Utilits\Prepare\AdminPrepare;
use App\Utilits\TableGenerator\Modern\ModernPerfectPaginator;
use App\Utilits\TableGenerator\PerfectPaginatorResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PromocodesController extends Controller
{

    public function list(Request $request) : PerfectPaginatorResponse
    {

        $promocodes = Promocode::query()
            ->with('tariffs');

        $paginator = new ModernPerfectPaginator($promocodes);
        $paginator->setAllowedSearchColumns(['code']);
        $paginator->setAllowedSortColumns([
            'id',
            'code',
            'current_uses',
            'max_uses',
            'expired_at',
            'value',
            'bonus_duration'
        ]);

        return $paginator->build($request)->map(function ($promocode) {
            return AdminPrepare::promocode($promocode);
        });

    }

    protected function validateData(Request $request, ?Promocode $promocode = null) : array
    {
        $unique = Rule::unique('promocodes', 'code');

        if($promocode){
            $unique->ignore($promocode->id);
        }

        $types = Rule::in([PromocodeTypes::PERCENT, PromocodeTypes::AMOUNT]);
        $bonusPeriods = Rule::in([PromocodeBonusPeriods::DAY, PromocodeBonusPeriods::WEEK, PromocodeBonusPeriods::MONTH, PromocodeBonusPeriods::YEAR]);

        return $request->validate([
            'code' => ['required', 'string', 'max:255', $unique],
            'value' => ['required', 'integer', 'min:0'],
            'type' => ['required', 'string', $types],
            'expired_at' => ['required', 'date'],
            'max_uses' => ['required', 'integer', 'min:1'],
            'tariffs' => ['required', 'array'],
            'tariffs.*' => ['required', 'integer', 'exists:tariffs,id'],
            'only_first_payment' => ['nullable', 'boolean'],
            'bonus_duration' => ['required', 'integer', 'min:0'],
            'bonus_period' => ['required', 'string', $bonusPeriods],
        ], [
            'code.unique' => 'Такой промокод уже существует',
            'value.min' => 'Скидка не может быть отрицательной',
            'max_uses.min' => 'Слишком мало доступных использований',
            'bonus_duration.min' => 'Бонус в днях не может быть отрицательный'
        ]);
    }

    public function create(Request $request) : array
    {

        $data = $this->validateData($request);

        $promocode = DB::transaction(function () use ($data) {

            $promocode = Promocode::create([
                'code' => $data['code'],
                'value' => $data['value'],
                'type' => $data['type'],
                'expired_at' => $data['expired_at'],
                'max_uses' => $data['max_uses'],
                'bonus_duration' => $data['bonus_duration'],
                'bonus_period' => $data['bonus_period'],
                'only_first_payment' => Arr::get($data, 'only_first_payment') ?: false
            ]);

            $promocode->tariffs()->sync($data['tariffs']);

            return $promocode;

        });

        return AdminPrepare::promocode($promocode);

    }

    public function edit(Request $request, Promocode $promocode) : array
    {

        $data = $this->validateData($request, $promocode);

        DB::transaction(function () use ($promocode, $data) {

            $promocode->code = $data['code'];
            $promocode->value = $data['value'];
            $promocode->type = $data['type'];
            $promocode->expired_at = $data['expired_at'];
            $promocode->max_uses = $data['max_uses'];
            $promocode->bonus_duration = $data['bonus_duration'];
            $promocode->bonus_period = $data['bonus_period'];
            $promocode->only_first_payment = Arr::get($data, 'only_first_payment') ?: false;
            $promocode->save();

            $promocode->tariffs()->sync($data['tariffs']);

            return $promocode;

        });

        return AdminPrepare::promocode($promocode);

    }

    public function remove(Request $request, Promocode $promocode) : void
    {
        $promocode->delete();
    }

}
