<?php

namespace App\Http\Controllers;

use App\Consts\SubscriptionStatuses;
use App\Exceptions\Telegram\NotAllowForBannedException;
use App\Exceptions\Telegram\NotAllowForGroupsException;
use App\Jobs\Telegram\DownloadUserPicture;
use App\Models\Order;
use App\Models\Tariff;
use App\Models\User;
use App\Services\CloudPaymentsService;
use App\Services\OptionsService;
use App\Services\OrdersService;
use App\Services\StatisticService;
use App\Services\SubscriptionsService;
use App\Services\TelegramMailing\TelegramBaseService;
use App\Services\TelegramMailing\TelegramUpgradeService;
use App\Services\TelegramMailing\TelegramWelcomeService;
use App\Services\TelegramService;
use App\Services\TextsService;
use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class TelegramController extends Controller
{

    protected $userService;
    protected $textsService;
    protected $optionsService;
    protected $statisticService;
    protected $telegramService;
    protected $telegramWelcomeService;
    protected $telegramBaseService;
    protected $telegramUpgradeService;
    protected $subscriptionsService;
    protected $cloudPaymentsService;
    protected $ordersService;

    /**
     * Отправлять админу лог всех входящих сообщений
     */
    protected $mirror = false;

    protected $response = null;
    protected $responseFail = null;

    public function __construct(
        UsersService $usersService,
        TextsService $textsService,
        OptionsService $optionsService,
        StatisticService $statisticService,
        TelegramService $telegramService,
        TelegramWelcomeService $telegramWelcomeService,
        TelegramBaseService $telegramBaseService,
        TelegramUpgradeService $telegramUpgradeService,
        CloudPaymentsService $cloudPaymentsService,
        SubscriptionsService $subscriptionsService,
        OrdersService $ordersService
    )
    {
        $this->userService = $usersService;
        $this->textsService = $textsService;
        $this->optionsService = $optionsService;
        $this->statisticService = $statisticService;
        $this->telegramService = $telegramService;
        $this->telegramWelcomeService = $telegramWelcomeService;
        $this->telegramBaseService = $telegramBaseService;
        $this->cloudPaymentsService = $cloudPaymentsService;
        $this->subscriptionsService = $subscriptionsService;
        $this->telegramUpgradeService = $telegramUpgradeService;
        $this->ordersService = $ordersService;
    }

    /**
     * Точка входа Webhook
     */
    public function webhook(Request $request)
    {

        if (
            env('APP_DEBUG') ||
            $request->header('X-Telegram-Bot-Api-Secret-Token') === $this->telegramService->getAccessToken()
        ) {

            return $this->parseRequest(
                $request->json()->all()
            );

        }

        return abort(404);

    }

    /**
     * Установка Webhook
     */
    public function setWebhook(Request $request): string
    {

        $this->telegramService->setWebhook(
            route('services.telegram.webhook')
        );

        return 'DONE';

    }


    /**
     * Установка ответа Webhook
     */
    protected function setResponse(array $data): void
    {
        $this->response = $data;
    }

    /**
     * Установка ответа Webhook при ошибке
     */
    protected function setResponseFail(array $data): void
    {
        $this->responseFail = $data;
    }


    protected function getChatName(array $chat): string
    {

        $name = [];
        if (array_key_exists('first_name', $chat)) {
            $name[] = $chat['first_name'];
        }

        if (array_key_exists('last_name', $chat)) {
            $name[] = $chat['last_name'];
        }

        return implode(' ', $name);

    }

    protected function getOrCreateUser(array $chat): User
    {

        if ($chat['id'] <= 0) {
            throw new NotAllowForGroupsException;
        }

        return DB::transaction(function () use ($chat) {

            $user = User::query()
                ->where('chat', (string)$chat['id'])
                ->where('type', 'telegram')
                ->first();

            if (!$user) {

                $user = User::create([
                    'name' => $this->getChatName($chat),
                    'username' => array_key_exists('username', $chat) ? $chat['username'] : null,
                    'chat' => (string)$chat['id'],
                    'picture' => null,
                ]);

                $this->statisticService->onRegister($user);
                $this->statisticService->onActivity($user);

                DownloadUserPicture::dispatch($user)->onQueue('telegram');

            }else{

                if($user->is_banned){
                    throw new NotAllowForBannedException;
                }

                if($user->last_activity_at->format('d.m.Y') !== now()->format('d.m.Y')){
                    $this->statisticService->onActivity($user);
                }

                $user->last_activity_at = now();
                $user->is_alive = true;
                $user->died_at = null;
                $user->save();

            }



            return $user;


        });

    }

    /**
     * Отправить \Throwable админу
     */
    protected function sendErrorLog(\Throwable $e)
    {

        ob_start();

        var_dump($e);

        $err = ob_get_clean();
        $err = mb_substr($err, 0, 1000);

        $this->sendLog($err);

    }

    /**
     * Отправить сообщение админу
     */
    protected function sendLog(string $log)
    {
        $this->telegramService->bot->sendMessage(5114144112, $log);
    }

    /**
     * Обработка запроса
     */
    protected function parseRequest(array $update)
    {

        if($this->mirror){
            $this->sendLog(json_encode($update));
        }

        try {

            if (isset($update['callback_query'])) {

                $data = $update['callback_query']['data'];
                $chat = $update['callback_query']['message']['chat'];
                $message_id = (string)$update['callback_query']['message']['message_id'];
                $callback_id = (string)$update['callback_query']['id'];

                $this->setResponseFail([
                    'method' => 'answerCallbackQuery',
                    'callback_query_id' => $callback_id,
                    'text' => 'Server error',
                    'show_alert' => false
                ]);

                $this->setResponse([
                    'method' => 'answerCallbackQuery',
                    'callback_query_id' => $callback_id,
                    'show_alert' => false
                ]);

                $this->onCallbackQuery(
                    $this->getOrCreateUser($chat),
                    $data,
                    $message_id,
                    $callback_id
                );

            } elseif (isset($update['message']['text'])) {

                $text = trim($update['message']['text']);
                $chat = $update['message']['chat'];
                $message_id = $update['message']['message_id'];

                $user = $this->getOrCreateUser($chat);

                if (mb_substr($text, 0, 1) === '/') {

                    $parts = explode(' ', $text);

                    $command = mb_substr($parts[0], 1);
                    $args = array_slice($parts, 1);

                    $this->onCommandMessage($user, $command, $args, $message_id);

                } else {
                    $this->onTextMessage($user, $text, $message_id);
                }

            } elseif (isset($update['my_chat_member'])) {

                $chat = $update['my_chat_member']['chat'];
                $status = $update['my_chat_member']['new_chat_member']['status'];

                if (in_array($status, ['kicked', 'left'])) {

                    $user = $this->getOrCreateUser($chat);

                    $user->is_alive = false;
                    $user->died_at = now();
                    $user->save();

                }

            }

            if ($this->response) {
                return $this->response;
            }

        }catch (NotAllowForBannedException $e){

        }catch (NotAllowForGroupsException $e) {

        } catch (\Throwable $e) {

            if(!$this->checkNeedIgnoreThrowable($e)){

                if(env('APP_DEBUG')) {
                    $this->sendErrorLog($e);
                }

                if ($this->responseFail) {
                    return $this->responseFail;
                }

            }

        }

        return null;

    }

    protected function checkNeedIgnoreThrowable(\Throwable $e) : bool
    {
        return ($e instanceof \TelegramBot\Api\HttpException) &&
            mb_strpos($e->getMessage(), 'Connection timed out after ') !== false;
    }

    //////////////////
    ///// EVENTS /////
    //////////////////
    ///
    /**
     * Здесь обрабатываются все /команды
     */
    protected function onCommandMessage(User $user, string $command, array $args, string $mid)
    {

        if ($command === 'start') {

            if(!$user->parent_id && count($args)){

                $parent = User::query()
                    ->where('chat', $args[0])
                    ->first();

                if($parent->id !== $user->id){

                    $user->parent_id = $parent->id;
                    $user->save();

                }

            }


            if($user->wasChanged('is_alive')){
                $this->telegramBaseService->sendAliveMessage($user);
            }


            if($user->meta_is_buy){
                $this->telegramBaseService->sendMenu($user, '🏚 Главное меню');
            }else{

                if($this->optionsService->get('following_enabled')){

                    if($user->meta_is_accept_rules){
                        $this->telegramWelcomeService->sendAnnouncement($user);
                    }else{
                        $this->telegramWelcomeService->sendStartMessage($user);
                    }

                }else{

                    if($user->start_key){
                        $this->telegramWelcomeService->sendContinueQuestion($user);
                    }else{
                        $this->telegramWelcomeService->sendStartMessage($user);
                    }

                }

            }

            return true;
        }


    }

    /**
     * Здесь обрабатываются все тестовые сообщения
     */
    protected function onTextMessage(User $user, string $text, string $mid)
    {

        if($text === $this->telegramBaseService->menuButtonProfile){

            $this->telegramBaseService->sendProfile($user);
            return true;

        }

        if($text === $this->telegramBaseService->menuButtonAbout){

            $this->telegramBaseService->sendPresentation($user);
            return true;

        }

        if($text === $this->telegramBaseService->menuButtonBuy){

            if($user->tariff_id){
                $this->telegramBaseService->sendProfile($user);
            }else{
                if($this->optionsService->get('following_enabled')){
                    $this->telegramBaseService->sendTariffModes($user);
                }else{
                    $this->telegramWelcomeService->sendPreRegistrationAnnouncement($user);
                }
            }

            return true;

        }

        if($text === $this->telegramBaseService->menuButtonSignature){

            $this->telegramBaseService->sendSubscribe($user);

            return true;

        }


    }

    /**
     * Здесь обрабатываются все CallbackQuery
     */
    protected function onCallbackQuery(User $user, string $data, string $mid, string $cid)
    {

        $data = explode(",", $data);

        $method = $data[0];
        $args = array_slice($data, 1);

        if($method === 'start'){

            $this->telegramService->removeReplyMarkup($user, $mid);
            $this->telegramWelcomeService->sendStartMessage($user);

            return true;

        }

        if($method === 'conditions'){

            $user->start_key = 'conditions';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);
            $this->telegramWelcomeService->sendConditions($user);

            return true;

        }

        if($method === 'accept_conditions'){

            $this->telegramService->editReplyMarkup($user, $mid, new InlineKeyboardMarkup(
                $this->telegramWelcomeService->getConditionsLinks()
            ));

            $this->telegramBaseService->sendMenu($user, '✅ Вы приняли условия');

            if(!$user->meta_is_accept_rules){
                $user->meta_is_accept_rules = true;
                $user->save();

                $this->userService->depositBalance($user, 1000);
                $this->telegramWelcomeService->sendMoneyReward($user, 1000, 0);
            }

            $user->start_key = 'welcome';
            $user->save();

            if($this->optionsService->get('following_enabled')){
                $this->telegramWelcomeService->sendAnnouncement($user);
            }else{
                $this->telegramWelcomeService->sendWelcome($user);
            }


            return true;

        }

        if($method === 'check_list'){

            $user->start_key = 'check_list';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);

            if($user->balance < 2000){
                $this->userService->depositBalance($user, 1000);
                $this->telegramWelcomeService->sendMoneyReward($user, 1000, 1);
            }

            $this->telegramWelcomeService->sendCheckList($user);

            return true;

        }

        if($method === 'preview_lecture_1'){

            $user->start_key = 'preview_lecture_1';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);
            $this->telegramWelcomeService->sendLectureFirstPreview($user);

            return true;

        }

        if($method === 'get_lecture_1'){

            $user->start_key = 'get_lecture_1';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);
            $this->telegramWelcomeService->sendLectureFirstContent($user);

            return true;

        }

        if($method === 'read_lecture_1'){

            $user->start_key = 'read_lecture_1';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);

            if($user->balance < 3000){
                $this->userService->depositBalance($user, 1000);
                $this->telegramWelcomeService->sendMoneyReward($user, 1000, 2);
            }

            $this->telegramWelcomeService->sendLectureSecondPreview($user);

            return true;

        }

        if($method === 'get_lecture_2'){

            $user->start_key = 'get_lecture_2';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);
            $this->telegramWelcomeService->sendLectureSecondContent($user);

            return true;

        }

        if($method === 'read_lecture_2'){

            $user->start_key = 'read_lecture_2';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);

            if($user->balance < 4000){
                $this->userService->depositBalance($user, 1000);
                $this->telegramWelcomeService->sendMoneyReward($user, 1000, 3);
            }

            $this->telegramWelcomeService->sendAdvert($user);

            return true;
        }

        if($method === 'cases'){

            $user->start_key = 'cases';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);
            $this->telegramWelcomeService->sendCasesGallery($user);
            $this->telegramWelcomeService->sendCasesCaption($user);

            return true;

        }

        if($method === 'preview_lecture_3'){

            $user->start_key = 'preview_lecture_3';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);
            $this->telegramWelcomeService->sendLectureThirdPreview($user);

            return true;

        }

        if($method === 'get_lecture_3'){

            $user->start_key = 'get_lecture_3';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);
            $this->telegramWelcomeService->sendLectureThirdContent($user);

            return true;

        }

        if($method === 'read_lecture_3'){

            $user->start_key = 'read_lecture_3';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);

            if($user->balance < 5000){
                $this->userService->depositBalance($user, 1000);
                $this->telegramWelcomeService->sendMoneyReward($user, 1000, 4);
            }


            $this->telegramWelcomeService->sendBestsGallery($user);
            $this->telegramWelcomeService->sendBestsCaption($user);

            return true;

        }


        if($method === 'pre_registration_form'){

            $user->start_key = 'end';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);
            $this->telegramBaseService->sendMenu($user, '⚠️ Теперь вам доступно меню');
            $this->telegramWelcomeService->sendPreRegistrationAnnouncement($user);

            return true;

        }

        if($method === 'presentation'){

            $this->telegramService->deleteMessage($user, $mid);
            $this->telegramBaseService->sendPresentation($user, $args[0]);

            return true;

        }

        if($method === 'subscribe'){

            $this->telegramService->deleteMessage($user, $mid);
            $this->telegramBaseService->sendSubscribe($user);

            return true;

        }

        if($method === 'profile'){
            $this->telegramService->deleteMessage($user, $mid);
            $this->telegramBaseService->sendProfile($user);

            return true;
        }

        if($method === 'continue'){
            $this->telegramService->removeReplyMarkup($user, $mid);
            $this->telegramWelcomeService->sendByStartKey($user, $user->start_key);

            return true;
        }

        if($method === 'no_continue'){

            $user->start_key = 'welcome';
            $user->save();

            $this->telegramService->removeReplyMarkup($user, $mid);
            $this->telegramWelcomeService->sendByStartKey($user, $user->start_key);

            return true;

        }

        if($method === 'subscribe_renewal'){

            if(count($args)) {

                $subscription = $user->subscriptions()
                    ->orderBy('id', 'desc')
                    ->first();

                $token = $user->cloudPaymentTokens()
                    ->orderBy('id', 'desc')
                    ->first();

                if (
                    !$token || !$subscription ||
                    $user->tariff_id !== $subscription->tariff_id ||
                    $user->activeSubscription ||
                    $user->tariff_expired_at <= now() ||
                    $subscription->status !== SubscriptionStatuses::CANCELLED
                ) {
                    $this->telegramService->showAlert($cid, '❌ Сейчас это невозможно');
                    return true;
                }

                try {

                    $cloudData = $this->cloudPaymentsService->createSubscription(
                        $user,
                        $token->hash,
                        $subscription->amount,
                        $subscription->duration,
                        $this->cloudPaymentsService->subscriptionPeriodToCloudPeriod($subscription->period),
                        $user->tariff_expired_at
                    );

                } catch (\Throwable $e) {
                    $this->telegramService->showAlert($cid, '❌ Не удалось включить автопродление');
                    return true;
                }

                $this->subscriptionsService->renew($subscription, $cloudData['Model']['Id'], $user->tariff_expired_at);

                $user->refresh();

                $this->telegramService->deleteMessage($user, $mid);
                $this->telegramBaseService->sendSubscribe($user);

            }else{

                $this->telegramService->deleteMessage($user, $mid);
                $this->telegramBaseService->sendSubscribeRenewConfirmation($user);

            }

            return true;

        }

        if($method === 'subscribe_cancel'){

            if(count($args)){

                if(!$user->activeSubscription){
                    $this->telegramService->showAlert($cid, '❌ Сейчас это сделать невозможно');
                    return true;
                }

                try{

                    $this->cloudPaymentsService->cancelSubscription(
                        $user->activeSubscription->code
                    );

                }catch (\Throwable $e){
                    $this->telegramService->showAlert($cid, '❌ Не удается выключить автопродление');
                    return true;
                }

                DB::transaction(function () use ($user){
                    $this->statisticService->onCancelSubscription($user->activeSubscription);
                    $this->subscriptionsService->cancel($user->activeSubscription, false);
                });

                $user->refresh();

                $this->telegramService->deleteMessage($user, $mid);
                $this->telegramBaseService->sendSubscribe($user);

            }else{

                $this->telegramService->deleteMessage($user, $mid);
                $this->telegramBaseService->sendSubscribeCancelConfirmation($user);

            }


            return true;
        }

        if($method === 'order'){

            $this->telegramService->removeReplyMarkup($user, $mid);

            if($this->optionsService->get('payments_enabled')) {

                if($user->meta_is_buy || $this->optionsService->get('following_enabled') || count($args) > 1) {

                    $tariff = Tariff::find($args[0]);

                    if ($tariff && $tariff->is_active) {

                        $order = Order::create([
                            'code' => $this->ordersService->generateUniqueCode(),
                            'amount' => $tariff->price,
                            'tariff_id' => $tariff->id,
                            'user_id' => $user->id
                        ]);

                        $this->telegramBaseService->sendPaymentForm($user, $order);

                    }else{
                        $this->telegramBaseService->sendPaymentDenied($user);
                    }

                }else{
                    $this->telegramWelcomeService->sendPreRegistrationAnnouncement($user);
                }

            }else{
                $this->telegramBaseService->sendPaymentDenied($user);
            }

            return true;

        }

        if($method === 'buy'){

            $this->telegramService->removeReplyMarkup($user, $mid);

            if($user->meta_is_buy || $this->optionsService->get('following_enabled')) {

                if(count($args)) {
                    $this->telegramBaseService->sendTariffs($user, (string)$args[0]);
                }else{
                    $this->telegramBaseService->sendTariffModes($user);
                }

            }else{
                $this->telegramWelcomeService->sendPreRegistrationAnnouncement($user);
            }



            return true;

        }

        if($method === 'testing'){

            if($user->is_test_completed){

                $this->telegramUpgradeService->sendResult($user, true);

                return true;

            }

            $stage = 0;
            $score = 0;

            if(count($args)){

                $stage = (int)$args[0];
                $score = (int)$args[1];

                $this->telegramService->deleteMessage($user, $mid);

            }else{

                if($user->test_started_at && $user->test_started_at >= now()->subDays(30)){

                    $this->telegramService->showAlert($cid, '⚠️ Пройти тест можно раз в 30 дней');

                    return true;

                }else{
                    $user->test_started_at = now();
                    $user->save();
                }

            }

            if ($this->telegramUpgradeService->hasQuestion($stage)) {

                $this->telegramUpgradeService->sendQuestion($user, $stage, $score);

            } else {

                $success = $this->telegramUpgradeService->validateScore($score);

                if ($success) {
                    $user->is_test_completed = true;
                    $user->save();
                }

                $this->telegramUpgradeService->sendResult($user, $success);

            }

            return true;

        }



        return false;

    }




}
