<?php

namespace App\Service;
use finfo;
use \Illuminate\Http\UploadedFile;

class UgcImageService
{
    private $finfo;

    public function __construct()
    {
        $this->finfo = new finfo(FILEINFO_MIME);
    }

    private function isImage(string $filename): bool
    {
        $allowedMime = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        return in_array($$this->finfo->file($filename), $allowedMime);
    }
}