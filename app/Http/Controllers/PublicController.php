<?php
namespace App\Http\Controllers;

use App\Consts\OrderStatuses;
use App\Consts\UserStages;
use App\Jobs\Telegram\SavePreRegistrationForm;
use App\Models\Application;
use App\Models\Order;
use App\Models\Promocode;
use App\Models\Tariff;
use App\Services\CloudPaymentsService;
use App\Services\OptionsService;
use App\Services\PromocodesService;
use App\Services\TelegramMailing\TelegramWelcomeService;
use App\Services\TelegramService;
use App\Utilits\Traits\Auth\UserGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{

    use UserGuard;

    protected $telegramService;
    protected $telegramWelcomeService;
    protected $cloudPaymentsService;
    protected $optionsService;
    protected $promocodesService;

    public function __construct(
        TelegramService $telegramService,
        TelegramWelcomeService $telegramWelcomeService,
        OptionsService $optionsService,
        CloudPaymentsService $cloudPaymentsService,
        PromocodesService $promocodesService
    )
    {
        $this->telegramService = $telegramService;
        $this->telegramWelcomeService = $telegramWelcomeService;
        $this->optionsService = $optionsService;
        $this->cloudPaymentsService = $cloudPaymentsService;
        $this->promocodesService = $promocodesService;
    }

    protected function isPaymentsEnabled() : bool
    {
        return $this->optionsService->get('payments_enabled');
    }

    protected function isFollowingEnabled() : bool
    {
        return $this->optionsService->get('following_enabled');
    }

    protected function prepareCustomText(string $text) : string
    {
        return preg_replace('/[^A-Za-z0-9А-Яа-я_. \'\-@]/u', '', $text);
    }

    protected function searchPromocode(string $code, Tariff $tariff) : ?Promocode
    {

        $promocode = Promocode::where('code', $code)->first();

        if(
            $promocode &&
            $promocode->is_available &&
            $this->promocodesService->isAvailableForTariff($promocode, $tariff)
        ) {
            return $promocode;
        }

        return null;

    }

    public function preRegistration() : View
    {

        return view('public.pre-registration', [
            'user' => $this->user()
        ]);

    }

    public function preRegistrationForm(Request $request) : RedirectResponse
    {

        $user = $this->user();

        $data = $request->validate([
            'fio' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'profit' => ['required', 'string', 'max:255'],
            'capital' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'string', 'max:255']
        ]);

        if(!$user->meta_is_pre_form_filled){

            $fio = $this->prepareCustomText($data['fio']);
            $email = $this->prepareCustomText($data['email']);
            $phone = $this->prepareCustomText($data['phone']);
            $profit = $this->prepareCustomText($data['profit']);
            $capital = $this->prepareCustomText($data['capital']);
            $duration = $this->prepareCustomText($data['duration']);

            DB::transaction(function () use ($user, $email, $phone, $profit, $capital, $duration, $fio) {

                $user->fio = $fio;
                $user->email = $email;
                $user->phone = $phone;
                $user->stage = UserStages::COMPLETE_PRE_FORM;
                $user->meta_is_pre_form_filled = true;
                $user->save();

                $application = Application::create([
                    'profit' => $profit,
                    'capital' => $capital,
                    'duration' => $duration,
                    'user_id' => $user->id
                ]);

                SavePreRegistrationForm::dispatch($application)->onQueue('telegram');

            });


        }

        return redirect()->back();

    }

    public function pay(Order $order) : View
    {

        $user = $this->user();

        if($order->status !== OrderStatuses::ACTIVE){
            return abort(404);
        }

        return view('public.pay', [
            'order' => $order,
            'tariff' => $order->tariff,
            'user' => $this->user(),
            'payments_enabled' => $this->isPaymentsEnabled() //&& ($this->isFollowingEnabled() || $user->meta_is_buy)
        ]);
    }

    public function payForm(Request $request, Order $order)
    {

        $user = $this->user();

        $data = $request->validate([
            'fio' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'promocode' => ['nullable', 'string', 'max:255'],
        ]);

        if(!$this->isPaymentsEnabled() /*|| !($this->isFollowingEnabled() || $user->meta_is_buy)*/) {
            return redirect()->back();
        }

        if($order->status !== OrderStatuses::ACTIVE || $order->user_id !== $user->id){
            return abort(404);
        }

        /**
         * Сохраним данные пользователя
         */
        $fio = $this->prepareCustomText($data['fio']);
        $email = $this->prepareCustomText($data['email']);
        $phone = $this->prepareCustomText($data['phone']);

        $user->fio = $fio;
        $user->email = $email;
        $user->phone = $phone;
        $user->save();

        /**
         * Вычисляем скидку промокод
         */
        $promocode = Arr::get($data, 'promocode') ?: null;
        if($promocode) {

            $promocode = $this->searchPromocode($promocode, $order->tariff);

            if ($promocode) {

                $amount = $this->promocodesService->calculate($promocode, $order->tariff->price);
                $amount = max(10, $amount);
                $amount = (int)$amount;

                $order->amount = $amount;
                $order->promocode_id = $promocode->id;
                $order->save();

            }

        }

        return view('public.pay-redirect', [
            'order' => $order,
            'tariff' => $order->tariff,
            'user' => $user,
            'public_id' => $this->cloudPaymentsService->getPublic()
        ]);

    }

    public function redirect()
    {

        $username = $this->telegramService->getUsername();

        return redirect()->to(
            'https://t.me/' . $username
        );

    }


}
