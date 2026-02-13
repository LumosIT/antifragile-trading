<?php

namespace App\Utilits\Traits;

use PragmaRX\Google2FA\Google2FA;

trait HasTwoFactoryCode
{

    public function getTfaEnabledAttribute(){
        return !!$this->tfa_secret;
    }

    public function disableTFA(){
        $this->tfa_secret = null;
        $this->save();
    }

    public function setTFASecret(string $secret)
    {
        $this->tfa_secret = $secret;
        $this->save();
    }

    public function verifyTFACode(string $code) : bool
    {
        return (new Google2FA())->verifyKey( $this->tfa_secret, $code);
    }

}
