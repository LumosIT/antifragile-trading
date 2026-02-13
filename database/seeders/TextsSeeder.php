<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Option;
use App\Models\Text;
use App\Models\TextGroup;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class TextsSeeder extends Seeder
{

    private $currentGroup = null;
    private $currentIndex = 0;

    protected function createText(string $id, string $value = '') : Text
    {
        return Text::create([
            'id' => $id,
            'value' => $value,
            'index' => $this->currentIndex++,
            'text_group_id'=> $this->currentGroup
        ]);
    }

    protected function wrapGroup(string $name, string $id, callable $cb)
    {

        $group = TextGroup::create([
            'id' => $id,
            'name' => $name
        ]);

        $before = $this->currentGroup;

        $this->currentGroup = $group->id;

        $cb($group);

        $this->currentGroup = $before;

    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->wrapGroup('Знакомство', 'welcome', function(){

            $this->createText('start_message');
            $this->createText('conditions');
            $this->createText('welcome_message');
            $this->createText('check_list');
            $this->createText('advert');
            $this->createText('cases');
            $this->createText('bests');
            $this->createText('lecture_1_preview');
            $this->createText('lecture_1_content');
            $this->createText('lecture_2_preview');
            $this->createText('lecture_2_content');
            $this->createText('lecture_3_preview');
            $this->createText('lecture_3_content');
            $this->createText('announcement');
            $this->createText('pre_registration_announcement');

        });

        $this->wrapGroup('Технические', 'technical', function(){
            $this->createText('referral_reward');
            $this->createText('alive_message');
            $this->createText('payment_reminder');
            $this->createText('cancel_reminder');
            $this->createText('kick_message');
            $this->createText('remaining');
            $this->createText('warm_reward_1');
            $this->createText('warm_reward_2');
            $this->createText('warm_reward_3');
            $this->createText('warm_reward_4');
            $this->createText('warm_reward_5');
        });

        $this->wrapGroup('Платежи', 'payments', function(){
            $this->createText('buy_menu');
            $this->createText('payment_form');
            $this->createText('offer');

            $this->createText('invite_to_second_stair');
            $this->createText('invite_to_third_stair');
        });

        $this->wrapGroup('Аккаунт', 'account', function(){
            $this->createText('profile_active');
            $this->createText('profile_no_active');
            $this->createText('subscribe');
            $this->createText('no_subscribe');
            $this->createText('subscribe_cancelation');
        });

        $this->wrapGroup('Тестирование', 'third_stair_test', function(){
            $this->createText('third_stair_test');
            $this->createText('third_stair_test_question');
            $this->createText('third_stair_test_result_success');
            $this->createText('third_stair_test_result_fail');
        });

        Artisan::call('texts:import');

    }
}
