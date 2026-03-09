<?php

namespace App\Services\MaxMailing;

use App\Models\User;
use App\Services\MaxService;

class MaxUpgradeService {

    protected MaxService $maxService;

    public function __construct()
    {
        $this->maxService = app(MaxService::class);
    }

    public function sendMaxInvite(User $user) {
        $user->update([
            'invite_in_test' => true
        ]);

        $this->maxService->sendMessage($user->max_chat, "Вы получили возможность пройти тестирование🎉🎉\n\nВы можете это сделать в приложении📲");
    }

}
    