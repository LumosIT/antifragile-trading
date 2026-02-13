<?php

namespace App\Http\Controllers\Admin;

use App\Utilits\Api\ApiError;
use App\Utilits\QR\QR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;

class ProfileController extends Controller
{

    public function changePassword(Request $request) : void
    {

        $data = $request->validate([
            'password' => ['required', 'string', 'max:255']
        ], [
            'password.min' => 'Пароль слишком короткий',
            'password.max' => 'Пароль слишком длинный'
        ]);

        $admin = $this->admin();

        if(Hash::check($data['password'], $admin->password)){
            throw new ApiError('У вас сейчас установлен такой же пароль', 422);
        }

        DB::transaction(function() use ($admin, $data){

            $admin->password = Hash::make($data['password']);
            $admin->save();

        });

    }

    public function generateTFA() : array
    {

        $google = new Google2FA;

        $secret = $google->generateSecretKey();

        $qrUrl = $google->getQRCodeUrl(
            $this->admin()->login,
            $this->admin()->login,
            $secret
        );

        $qrPicture = new QR($qrUrl, 200, 0);
        $qrPicture->setBackgroundColor(255,255,255);

        return [
            'secret' => $secret,
            'qr' => $qrPicture->toSVG()->getString()
        ];

    }

    public function confirmTFA(Request $request) : void
    {

        $data = $request->validate([
            'secret' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'size:6']
        ], [
            'code.size' => 'Вы ввели неверный код'
        ]);

        $google = new Google2FA;
        $admin = $this->admin();

        if($admin->tfa_enabled){
            throw new ApiError('У вас уже установлен 2FA');
        }

        if(!$google->verifyKey($data['secret'], $data['code'])) {
            throw new ApiError('Вы ввели неверный код');
        }

        $admin->setTFASecret($data['secret']);

    }

    public function removeTFA(Request $request) : void
    {

        $admin = $this->admin();

        if(!$admin->tfa_enabled){
            throw new ApiError('У вас не установлен 2FA');
        }

        $admin->disableTFA();

    }

}
