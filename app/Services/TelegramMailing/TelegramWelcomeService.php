<?php

namespace App\Services\TelegramMailing;

/**
 * Сервис содержит части Telegram-бота, связанные с вступительным контентом
 */

use App\Consts\FileTypes;
use App\Models\Post;
use App\Models\User;
use App\Services\PostsService;
use App\Services\TelegramService;
use App\Services\TextsService;
use App\Services\UsersService;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\InputMedia\ArrayOfInputMedia;
use TelegramBot\Api\Types\InputMedia\InputMediaPhoto;
use TelegramBot\Api\Types\Message;

class TelegramWelcomeService
{

    protected $telegramService;
    protected $telegramBaseService;
    protected $textsService;
    protected $usersService;
    protected $postsService;

    public function __construct(
        TelegramService $telegramService,
        TextsService $textsService,
        TelegramBaseService $telegramBaseService,
        UsersService  $usersService,
        PostsService $postsService
    )
    {
        $this->telegramService = $telegramService;
        $this->textsService = $textsService;
        $this->telegramBaseService = $telegramBaseService;
        $this->usersService = $usersService;
        $this->postsService = $postsService;
    }

    public function getStartKeysChain() : array
    {

        return [
            'start',
            'conditions',
            'welcome',
            'check_list',
            'preview_lecture_1',
            'get_lecture_1',
            'read_lecture_1',
            'get_lecture_2',
            'read_lecture_2',
            'cases',
            'preview_lecture_3',
            'get_lecture_3',
            'read_lecture_3',
            'end'
        ];

    }

    public function getNextStartKey(?string $key) : string
    {

        $full = $this->getStartKeysChain();

        if($key) {
            $index = (int)array_search($key, $full);
            $index = $index + 1;
            $index = min($index, count($full) - 1);
        }else{
            $index = 1;
        }

        return $full[$index];

    }

    public function sendByStartKey(User $user, ?string $key) : void
    {

        /**
         * Я хуй знает как это еще сделать
         */
        switch($key) {

            case 'conditions':
                $this->sendConditions($user);
                break;

            case 'welcome':
                $this->sendWelcome($user);
                break;

            case 'check_list':
                $this->sendCheckList($user);
                break;

            case 'preview_lecture_1':
                $this->sendLectureFirstPreview($user);
                break;

            case 'get_lecture_1':
                $this->sendLectureFirstContent($user);
                break;

            case 'read_lecture_1':
                $this->sendLectureSecondPreview($user);
                break;

            case 'get_lecture_2':
                $this->sendLectureSecondContent($user);
                break;

            case 'read_lecture_2':
                $this->sendAdvert($user);
                break;

            case 'cases':
                $this->sendCasesGallery($user);
                $this->sendCasesCaption($user);
                break;

            case 'preview_lecture_3':
                $this->sendLectureThirdPreview($user);
                break;

            case 'get_lecture_3':
                $this->sendLectureThirdContent($user);
                break;

            case 'read_lecture_3':
                $this->sendBestsGallery($user);
                $this->sendBestsCaption($user);
                break;

            case 'end':
                $this->sendPreRegistrationAnnouncement($user);
                break;

            case 'start':
            default:
                $this->sendStartMessage($user);
                break;
        }

    }

    public function sendRemaining(User $user) : Message
    {
        return $this->telegramService->send(
            $user,
            $this->textsService->get('remaining'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'Продолжить',
                        'callback_data' => 'continue'
                    ]
                ]
            ])
        );
    }

    public function sendStartMessage(User $user) : Message
    {

        return $this->telegramService->sendPhoto(
            $user,
            'AgACAgIAAxkBAAMnaQEQvqMZWltUvwXsYhWEBuyuN4EAAjIAATIbudhgS3XrF-dGQXvZAQADAgADeAADNgQ',
            $this->textsService->get('start_message', [
                'name' => $user->name
            ]),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'Далее',
                        'callback_data' => 'conditions'
                    ]
                ]
            ])
        );

    }

    public function getConditionsLinks() : array
    {

        return [
                [
                    [
                        'text' => 'ПРАВИЛА КЛУБА',
                        'url' => 'https://antifragile-trading.ru/rules_club'
                    ]
                ],
                [
                    [
                        'text' => 'СОГЛАСИЕ НА РАССЫЛКУ',
                        'url' => 'https://antifragile-trading.ru/rassilka'
                    ]
                ],
                [
                    [
                        'text' => 'ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ',
                        'url' => 'https://antifragile-trading.ru/confidencial'
                    ]
                ]
        ];


    }

    public function sendContinueQuestion(User $user) : Message
    {
        return $this->telegramService->send(
            $user,
            'Начнем сначала или с того места, где ты остановился?',
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'Продолжить',
                        'callback_data' => 'continue'
                    ]
                ],
                [
                    [
                        'text' => 'Начать с начала',
                        'callback_data' => 'no_continue'
                    ]
                ]
            ])
        );
    }

    public function sendConditions(User $user) : Message
    {

        return $this->telegramService->send(
            $user,
            $this->textsService->get('conditions'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'ПРИНИМАЮ УСЛОВИЯ',
                        'callback_data' => 'accept_conditions',
                    ]
                ],
                ...$this->getConditionsLinks()
            ])
        );


    }

    public function sendWelcome(User $user) : Message
    {

        return $this->telegramService->send(
            $user,
            $this->textsService->get('welcome_message'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'ПОЛУЧИТЬ МАТЕРИАЛЫ',
                        'callback_data' => 'check_list'
                    ]
                ]
            ])
        );

    }

    public function sendCheckList(User $user) : Message
    {

        return $this->telegramService->sendFile(
            $user,
            'BQACAgIAAxkBAAMlaQEQo_X7UwAB8DMRnMrmu_qgRhRDAAJHjAACFigJSH2GcTIZ-da9NgQ',
            $this->textsService->get('check_list'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'ДАЛЕЕ',
                        'callback_data' => 'preview_lecture_1'
                    ]
                ]
            ])
        );

    }

    public function sendLectureFirstPreview(User $user) : Message
    {

        return $this->telegramService->send(
            $user,
            $this->textsService->get('lecture_1_preview'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'ПОЛУЧИТЬ ЛЕКЦИЮ',
                        'callback_data' => 'get_lecture_1'
                    ]
                ]
            ])
        );

    }

    public function sendLectureFirstContent(User $user) : Message
    {

        return $this->telegramService->sendVideo(
            $user,
            'BAACAgIAAxkBAAMfaQEQYkKnGheuCNIJImwycLPvX7EAAjOHAAKhQhFLVKH2rL1Rabw2BA',
            $this->textsService->get('lecture_1_content'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'ЛЕКЦИЯ ПРОСМОТРЕНА',
                        'callback_data' => 'read_lecture_1'
                    ]
                ]
            ])
        );

    }

    public function sendLectureSecondPreview(User $user) : Message
    {

        return $this->telegramService->send(
            $user,
            $this->textsService->get('lecture_2_preview'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'ПОЛУЧИТЬ ЛЕКЦИЮ',
                        'callback_data' => 'get_lecture_2'
                    ]
                ]
            ])
        );

    }

    public function sendLectureSecondContent(User $user) : Message
    {

        return $this->telegramService->sendVideo(
            $user,
            'BAACAgIAAxkBAAMgaQEQYuT-3Mt0TUsMEy1u2BaunoQAAkmHAAKhQhFLrNTpIQNy-SU2BA',
            $this->textsService->get('lecture_2_content'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'ЛЕКЦИЯ ПРОСМОТРЕНА',
                        'callback_data' => 'read_lecture_2'
                    ]
                ]
            ])
        );

    }

    public function sendLectureThirdPreview(User $user) : Message
    {

        return $this->telegramService->send(
            $user,
            $this->textsService->get('lecture_3_preview'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'ПОЛУЧИТЬ ЛЕКЦИЮ',
                        'callback_data' => 'get_lecture_3'
                    ]
                ]
            ])
        );

    }

    public function sendLectureThirdContent(User $user) : Message
    {

        return $this->telegramService->sendVideo(
            $user,
            'BAACAgIAAxkBAAMhaQEQYk8jZNmFzBFhERiuHsAeXwADT4cAAqFCEUtdHljizZRldzYE',
            $this->textsService->get('lecture_3_content'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'ЛЕКЦИЯ ПРОСМОТРЕНА',
                        'callback_data' => 'read_lecture_3'
                    ]
                ]
            ])
        );

    }

    public function sendAdvert(User $user) : Message
    {

        return $this->telegramService->send(
            $user,
            $this->textsService->get('advert'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'ДАЛЕЕ',
                        'callback_data' => 'cases'
                    ]
                ]
            ])
        );

    }

    public function sendCasesGallery(User $user) : array
    {

        return $this->telegramService->sendGallery(
            $user,
            new ArrayOfInputMedia([
                new InputMediaPhoto('AgACAgIAAxkBAAIDlmktiEXvqKP8VqcRKQN3xKwWGsmhAAJ5DWsb7z5xSfpztkhdHbLpAQADAgADeQADNgQ'),
                new InputMediaPhoto('AgACAgIAAxkBAAIDl2ktiEXnnOQ6E4ZM-i3P8nAXvz2xAAJ6DWsb7z5xSZF7BuyZWiBUAQADAgADeQADNgQ'),
                new InputMediaPhoto('AgACAgIAAxkBAAIDmGktiEU2_ntxt7tdcNUGSCyQszcpAAJ7DWsb7z5xSYB3BVOTd8SUAQADAgADeQADNgQ')
            ])
        );

    }

    public function sendCasesCaption(User $user) : Message
    {

        return $this->telegramService->send(
            $user,
            $this->textsService->get('cases'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'ХОЧУ ТАК ЖЕ',
                        'callback_data' => 'preview_lecture_3'
                    ]
                ]
            ])
        );

    }

    public function sendBestsGallery(User $user) : array
    {
        return $this->telegramService->sendGallery(
            $user,
            new ArrayOfInputMedia([
                new InputMediaPhoto('AgACAgIAAxkBAAIDkGktiD6TvjWRS7O8Mg729lp9y_cPAAJ1DWsb7z5xSbtcgcUdexifAQADAgADeQADNgQ'),
                new InputMediaPhoto('AgACAgIAAxkBAAIDkWktiD6tj-kgMi771aMeB1cljme8AAJ2DWsb7z5xSUUEI7jhQ5vZAQADAgADeQADNgQ'),
                new InputMediaPhoto('AgACAgIAAxkBAAIDkmktiD55pTLkrV_1OkVW6PP7JSTKAAJ3DWsb7z5xSYrwhcw-3efEAQADAgADeQADNgQ')
            ])
        );
    }

    public function sendBestsCaption(User $user) : Message
    {
        return $this->telegramService->send(
            $user,
            $this->textsService->get('bests'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'Далее',
                        'callback_data' => 'pre_registration_form'
                    ]
                ]
            ])
        );
    }

    public function sendMoneyReward(User $user, int $amount, ?int $picture_index = null) : Message
    {

        $gifs = [
            'CgACAgQAAxkBAAJRY2lmLnOn69VBdY1VAAHyYrLxUEzALQACcRoAAv7nMVOTqCE5RAWOozgE',
            'CgACAgQAAxkBAAJRZGlmLnMCkkEOKAc9xV_4K08cRqQ0AAJ0GgAC_ucxU6J_MGZPyvDAOAQ',
            'CgACAgQAAxkBAAJRZ2lmLoHgDZNktbLID0bF0LJugMnQAAJyGgAC_ucxU__HXFNwyl6gOAQ',
            'CgACAgQAAxkBAAJRaGlmLoHGnw3dbV9cv64Imtl5gNKGAAJ1GgAC_ucxU7qp4j_lR02SOAQ',
            'CgACAgQAAxkBAAJRa2lmLoZ2P1W9avnQ0e7pQ9m2Nr3zAAJzGgAC_ucxU_Vbxxe11PxvOAQ',
        ];

        if(is_null($picture_index)) {
            $picture_index = array_rand($gifs);
        }

        if(!array_key_exists($picture_index, $gifs)) {
            throw new \Exception('Bad picture index');
        }

        return $this->telegramService->sendVideo(
            $user,
            $gifs[$picture_index],
            $this->textsService->get('warm_reward_' . ($picture_index + 1), [
                'amount' => $amount
            ])
        );

    }

    public function sendAnnouncement(User $user) : Message
    {

        return $this->telegramService->send(
            $user,
            $this->textsService->get('announcement', [
                'balance' => $user->balance
            ]),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'Войти в клуб 257',
                        'callback_data' => 'buy'
                    ]
                ]
            ])
        );

    }

    public function sendPreRegistrationAnnouncement(User $user) : Message
    {

        return $this->telegramService->send(
            $user,
            $this->textsService->get('pre_registration_announcement', [
                'balance' => $user->balance
            ]),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'Заполнить форму',
                        'url' => route_public($user, 'public.pre-registration')
                    ]
                ]
            ])
        );

    }

    public function sendSpamBlock(User $user, Post $post) : Message
    {

        $text = $this->postsService->normalize($post->value);

        if($post->file_id){

            switch($post->file->type){
                case FileTypes::PHOTO:
                    return $this->telegramService->sendPhoto($user, $post->file->hash, $text);
                case FileTypes::VIDEO:
                    return $this->telegramService->sendVideo($user, $post->file->hash, $text);
                case FileTypes::VOICE:
                    return $this->telegramService->sendVoice($user, $post->file->hash, $text);
                default:
                    return $this->telegramService->sendFile($user, $post->file->hash, $text);
            }

        }else{
            return $this->telegramService->send($user, $text);
        }

    }

}
