<?php

namespace App\Services\MaxMailing;

use App\Consts\FileTypes;
use App\Models\Post;
use App\Models\Tariff;
use App\Models\User;
use App\Services\MaxService;
use App\Services\PostsService;
use App\Services\TextsService;

class MaxWelcomeService
{

    protected $maxService;
    protected $textsService;
    protected $postsService;

    public function __construct(
        MaxService $maxService,
        TextsService $textsService,
        PostsService $postsService
    )
    {
        $this->maxService = $maxService;
        $this->textsService = $textsService;
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

    public function sendRemaining(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('remaining'),
        );
    }

    public function sendStartMessage(User $user)
    {
        $this->maxService->sendImage(
            $user->max_chat, 
            'https://petr-petr.ru/storage/content/main.jpg',
            $this->textsService->get('start_message', [
                    'name' => $user->name
            ])
        );
    }

    public function sendConditions(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('conditions'),
        );
    }

    public function sendWelcome(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('welcome_message'),
        );

    }

    public function sendCheckList(User $user)
    {
        $this->maxService->sendFile($user->max_chat, 'f9LHodD0cOJ6gpNYMksHq38q-qr8u1xO--Vj48PH_3VV0346kRR6HLtrGsrYMdTxNdS8fbR3lqlU-kESnDYO', $this->textsService->get('check_list'), 'file');
    }

    public function sendLectureFirstPreview(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('lecture_1_preview'),
        );
    }

    public function sendLectureFirstContent(User $user)
    {
        $this->maxService->sendFile($user->max_chat , 'f9LHodD0cOLiRXefj8yKvqpCA6h7D1psluxUgc1CxqeJPMiM7ITRfd4MjJLWNsdfyQiYrpzC13CZMPsPf_H8', $this->textsService->get('lecture_1_content'), 'video');
    }

    public function sendLectureSecondPreview(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('lecture_2_preview'),
        );
    }

    public function sendLectureSecondContent(User $user)
    {
        $this->maxService->sendFile($user->max_chat , 'f9LHodD0cOJgNbkluFzBmVpHX89lefi6TXQK90LGKyNLsIik1nsJ6Z_8UdG78v_O3OSGLrAlVs8AXHTtGav0', $this->textsService->get('lecture_2_content'), 'video');
    }

    public function sendLectureThirdPreview(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('lecture_3_preview'),
        );
    }

    public function sendLectureThirdContent(User $user)
    {
        $this->maxService->sendFile($user->max_chat , 'f9LHodD0cOKooT9tjAdv_ZIWmJhE9fkKYnn8igRuvPL-Kq5PYrJOO8ND-ge5ksppYMfLMv2plniGpeyBud8J', $this->textsService->get('lecture_3_content'), 'video');
    }

    public function sendAdvert(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('advert'),
        );
    }

    public function sendCasesGallery(User $user)
    {
        $text = 'Реальный кейс';

        $this->maxService->sendFile($user->max_chat, 'https://petr-petr.ru/storage/content/cases/c47.jpg', $text);
        $this->maxService->sendFile($user->max_chat, 'https://petr-petr.ru/storage/content/cases/c46.jpg', $text);
        $this->maxService->sendFile($user->max_chat, 'https://petr-petr.ru/storage/content/cases/c36.jpg', $text);
    }

    public function sendCasesCaption(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('cases'),
        );
    }

    public function sendBestsGallery(User $user)
    {
        $text = 'Результаты подписчиков';

        $this->maxService->sendFile($user->max_chat, 'https://petr-petr.ru/storage/content/cases/c11.jpg', $text);
        $this->maxService->sendFile($user->max_chat, 'https://petr-petr.ru/storage/content/cases/c25.jpg', $text);
        $this->maxService->sendFile($user->max_chat, 'https://petr-petr.ru/storage/content/cases/c33.jpg', $text);
    }

    public function sendBestsCaption(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('bests'),
        );
    }

    public function sendAnnouncement(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('announcement', [
                'balance' => $user->balance
            ]),
        );
    }

    public function sendTariffs(User $user) {
        $tariffs = Tariff::where('is_active', true)
            ->where('mode', 'simple')
            ->get();

        foreach ($tariffs as $tariff) {
            $keyboard[] = [
                [
                    'type' => 'message',
                    'text' => "Купить {$tariff->name}",
                ]
            ];
        }

        $this->maxService->sendMessage(
            $user->max_chat,
            "Выберите тариф:",
            $keyboard
        );
    }

    public function sendPreRegistrationAnnouncement(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('pre_registration_announcement', [
                'balance' => $user->balance
            ]),
            [
                [
                    [
                        'type' => 'link',
                        'text' => 'Заполнить форму',
                        'url' => route_public($user, 'public.pre-registration')
                    ]
                ]
            ]
        );
    }

    public function sendSpamBlock(User $user, Post $post)
    {
        $text = $this->postsService->normalize($post->value);

        if($post->file_id) {
            switch($post->file->type) {
                case FileTypes::PHOTO:
                    return $this->maxService->sendFile($user->max_chat, $post->file->max_hash, $text);
                case FileTypes::VIDEO:
                    return $this->maxService->sendFile($user->max_chat, $post->file->max_hash, $text);
                case FileTypes::VOICE:
                    return $this->maxService->sendFile($user->max_chat, $post->file->max_hash, $text);
                default:
                    return $this->maxService->sendFile($user->max_chat, $post->file->max_hash, $text);
            }

        } else {
            return $this->maxService->sendMessage($user->max_chat, $text);
        }
    }
}
