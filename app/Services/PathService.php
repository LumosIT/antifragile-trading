<?php

namespace App\Services;

class PathService
{

    protected function getExtension(string $path): ?string
    {

        $ext = pathinfo($path);

        return isset($ext['extension'])
            ? mb_strtolower($ext['extension'])
            : null;

    }

    public function isExtensionIn(string $path, array $extensions): bool
    {
        return in_array($this->getExtension($path), $extensions);
    }

    public function isVoice(string $path) : bool
    {
        return $this->isExtensionIn($path, ['ogg']);
    }

    public function isVideo(string $path) : bool
    {
        return $this->isExtensionIn($path, ['mp4']);
    }

    public function isPicture(string $path) : bool
    {
        return $this->isExtensionIn($path, ['jpg', 'jpeg', 'png']);
    }



}
