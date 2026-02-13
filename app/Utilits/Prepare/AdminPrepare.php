<?php

namespace App\Utilits\Prepare;

use App\Models\Admin;
use App\Models\File;
use App\Models\Mailing;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Promocode;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\Tariff;
use App\Models\User;

class AdminPrepare
{

    static public function file(File $file) : array
    {
        return $file->only([
            'id',
            'hash',
            'type',
            'name'
        ]);
    }

    static public function admin(Admin $admin) : array
    {

        $data = $admin->only(['id', 'login', 'role_id']);

        if($admin->relationLoaded('role')){
            $data['role'] = self::role($admin->role);
        }

        return $data;

    }

    static public function role(Role $role) : array
    {
        return $role->only(['id', 'name', 'permissions']);
    }

    static public function user(User $user, bool $fullData = false) : array
    {

        $data = $user->only([
            'id',
            'name',
            'username',
            'chat',
            'picture',
            'stage',
            'balance',
            'parent_id',
            'tariff_id',
            'is_alive',
            'tariff_expired_at',
            'last_activity_at',
            'created_at'
        ]);

        if($fullData){
            $data += $user->only([
                'fio',
                'experience',
                'acquaintance',
                'email',
                'phone'
            ]);
        }

        if($user->relationLoaded('tariff')){
            $data['tariff'] = $user->tariff_id ? self::tariff($user->tariff) : null;
        }

        return $data;

    }

    static public function tariff(Tariff $tariff) : array
    {

        return $tariff->only([
            'id',
            'name',
            'mode',
            'period',
            'duration',
            'price',
            'is_active'
        ]);

    }

    static public function promocode(Promocode $promocode) : array
    {

        $data = $promocode->only([
            'id',
            'code',
            'value',
            'type',
            'expired_at',
            'max_uses',
            'current_uses',
            'is_available',
            'bonus_duration',
            'bonus_period',
            'only_first_payment'
        ]);

        if($promocode->relationLoaded('tariffs')){
            $data['tariffs'] = $promocode->tariffs->map(function ($tariff) {
                return self::tariff($tariff);
            });
        }

        return $data;

    }

    static public function payment(Payment $payment) : array
    {
        $data = $payment->only([
            'id',
            'amount',
            'created_at',
            'hash'
        ]);

        if($payment->relationLoaded('user')){
            $data['user'] = self::user($payment->user);
        }

        return $data;
    }

    static public function mailing(Mailing $mailing) : array
    {
        return $mailing->only([
            'id',
            'text',
            'status',
            'users_count',
            'messages_count',
            'errors_count',
            'stages',
            'tariffs'
        ]);
    }

    static public function subscription(Subscription $subscription) : array
    {
        return $subscription->only([
            'id',
            'status',
            'amount',
            'period',
            'duration',
            'next_payment_at',
            'last_payment_at',
            'user_id',
            'tariff_id',
            'code'
        ]);
    }

    static public function post(Post $post) : array
    {
        return $post->only([
            'id',
            'index',
            'delay',
            'value'
        ]);
    }

}
