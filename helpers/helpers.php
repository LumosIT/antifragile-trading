<?php

use App\Services\UsersService;

function tempAsset(string $src) : string
{

    $file = public_path($src);

    if(file_exists($file)){

        $time = filemtime($file);

        return $src . '?v=' . crc32($src . $time);

    }else{

        return $src;

    }

}

function route_public(\App\Models\User $user, string $name, array $params = []) : string
{
    $usersService = app()->make(UsersService::class);

    return route($name, $params) . "?" . http_build_query([
        'user' => $user->id,
        'hash' => $usersService->getPublicAccessHash($user)
    ]);
}
