<?php

namespace Database\Seeders;

use App\Consts\SubscriptionStatuses;
use App\Consts\TariffModes;
use App\Consts\TariffPeriods;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TestSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        $tariff = Tariff::create([
            'name' => $faker->company(),
            'mode' => TariffModes::FULL,
            'period' => TariffPeriods::WEEK,
            'duration' => 1,
            'price' => 200,
            'is_active' => true
        ]);

        $tariff2 = Tariff::create([
            'name' => $faker->company(),
            'mode' => TariffModes::SIMPLE,
            'period' => TariffPeriods::WEEK,
            'duration' => 1,
            'price' => 200,
            'is_active' => true
        ]);

        $user = User::create([
            'name' => $faker->name(),
            'username' => $faker->userName(),
            'chat' => $faker->numberBetween($min = 190000000, $max = 1900000000),
            'picture' => null,
            'tariff_id' => $tariff->id,
            'tariff_expired_at' => now()->addMonth()
        ]);

        $subscription = Subscription::create([
            'status' => SubscriptionStatuses::ACTIVE,
            'card' => $faker->creditCardNumber(),
            'next_payment_at' => now()->addWeek(),
            'last_payment_at' => now(),
            'user_id' => $user->id,
            'code' => $faker->uuid(),
            'period' => $tariff->period,
            'duration' => $tariff->duration,
            'amount' => $tariff->price,
            'tariff_id' => $tariff->id
        ]);

        $payment = Payment::create([
            'subscription_id' => $subscription->id,
            'hash' => $faker->uuid(),
            'amount' => $tariff->price,
            'user_id' => $user->id
        ]);

    }
}
