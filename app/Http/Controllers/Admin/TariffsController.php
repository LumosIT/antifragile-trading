<?php

namespace App\Http\Controllers\Admin;

use App\Consts\TariffModes;
use App\Consts\TariffPeriods;
use App\Models\Tariff;
use App\Utilits\Api\ApiError;
use App\Utilits\Prepare\AdminPrepare;
use App\Utilits\TableGenerator\Modern\ModernPerfectPaginator;
use App\Utilits\TableGenerator\PerfectPaginatorResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TariffsController extends Controller
{

    public function list(Request $request) : PerfectPaginatorResponse
    {

        $data = $request->validate([
            'is_active' => ['nullable', 'integer'],
            'mode' => ['nullable', 'string']
        ]);

        $tariffs = Tariff::query();

        if(Arr::has($data, 'mode')) {
            $tariffs->where('mode', $data['mode']);
        }

        if(Arr::has($data, 'is_active')) {
            $tariffs->where('is_active', (bool)(int)$data['is_active']);
        }

        $paginator = new ModernPerfectPaginator($tariffs);
        $paginator->setAllowedSearchColumns(['name']);
        $paginator->setAllowedSortColumns([
            'id',
            'name',
            'is_active',
            'period',
            'duration',
            'price',
            'mode'
        ]);

        return $paginator->build($request)->map(function ($tariff) {
            return AdminPrepare::tariff($tariff);
        });

    }

    public function setActive(Request $request, Tariff $tariff) : void
    {

        $data = $request->validate([
            'is_active' => ['required', 'integer']
        ]);

        $tariff->is_active = (int)$data['is_active'];
        $tariff->save();

    }

    protected function validateData(Request $request) : array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'integer', 'min:1'],
            'period' => ['required', 'string', Rule::in([TariffPeriods::DAY, TariffPeriods::WEEK, TariffPeriods::MONTH, TariffPeriods::YEAR])],
            'mode' => ['required', 'string', Rule::in([TariffModes::FULL, TariffModes::SIMPLE])],
            'price' => ['required', 'integer', 'min:30']
        ], [
            'duration.min' => 'Слишком малый срок действия тарифа',
            'price.min' => 'Слишком маленькая цена'
        ]);
    }

    public function create(Request $request) : array
    {

        $data = $this->validateData($request);

        $tariff = Tariff::create([
            'name' => $data['name'],
            'mode' => $data['mode'],
            'period' => $data['period'],
            'duration' => $data['duration'],
            'price' => $data['price'],
        ]);

        return AdminPrepare::tariff($tariff);

    }

    public function edit(Request $request, Tariff $tariff) : array
    {

        $data = $this->validateData($request);

        $tariff->name = $data['name'];
        $tariff->mode = $data['mode'];
        $tariff->period = $data['period'];
        $tariff->duration = $data['duration'];
        $tariff->price = $data['price'];
        $tariff->save();

        return AdminPrepare::tariff($tariff);

    }

    public function remove(Request $request, Tariff $tariff) : void
    {

        try {
            $tariff->delete();
        }catch (QueryException $e){
            throw new ApiError('Нельзя удалить данный тариф, им пользуются пользователи');
        }

    }

}
