<?php

namespace App\Console\Commands;

use App\Consts\OptionTypes;
use App\Consts\PostTypes;
use App\Consts\TariffModes;
use App\Consts\UserStages;
use App\Jobs\Schedule\RunNightSpam;
use App\Jobs\Schedule\ScheduleSpamPosts;
use App\Jobs\Schedule\SpamPosts;
use App\Jobs\Schedule\SpamWarmup;
use App\Jobs\Telegram\SavePreRegistrationForm;
use App\Jobs\Telegram\SendClearMenu;
use App\Jobs\Telegram\SendMailing;
use App\Models\Application;
use App\Models\Link;
use App\Models\Mailing;
use App\Models\Post;
use App\Models\Text;
use App\Models\TextGroup;
use App\Models\User;
use App\Services\OptionsService;
use App\Services\TelegramMailing\TelegramBaseService;
use App\Services\TelegramMailing\TelegramWelcomeService;
use App\Services\TelegramService;
use App\Services\TextsService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Artisan;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function handle(OptionsService $optionsService)
    {

       echo date('H:i');

    }
}
