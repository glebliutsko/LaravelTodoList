<?php

namespace App\Services;
use \finfo;
use Ramsey\Uuid\Uuid;
use \Illuminate\Http\UploadedFile;
use \Imagick;
use Illuminate\Support\Facades\Storage;

class UgcImageService
{
    private $finfo;

    public function __construct()
    {
        $this->finfo = new finfo(FILEINFO_MIME);
    }

    private function is_image(string $filename): bool
    {
        $allowedMime = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        $filetype = explode(';', $this->finfo->file($filename))[0];

        return in_array($filetype, $allowedMime);
    }

    private function convert_to_jpeg(Imagick $image): Imagick
    {
        $image->setImageFormat('jpeg');

        $image->setImageCompression(Imagick::COMPRESSION_JPEG);
        $image->setImageCompressionQuality(80);

        return $image;
    }

    private function convert_to_webp(Imagick $image): Imagick
    {
        $image->setImageFormat('webp');
        $image->setImageCompressionQuality(80);
        return $image;
    }

    public function save(UploadedFile $image): \App\Models\Image
    {
        $filename = $image->getRealPath();

        if (!$this->is_image($filename)) {
            throw new \Exception('file type not allowed');
        }

        $originalImage = new Imagick();
        $originalImage->readImage($filename);
        $originalImage->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);  # Удаляем прозрачный фон

        $jpegImage = $this->convert_to_jpeg($originalImage->clone());
        $webpImage = $this->convert_to_webp($originalImage->clone());

        $imageSaveName = Uuid::uuid4()->toString();
        Storage::disk('public')->put("$imageSaveName/full.jpeg", strval($jpegImage));
        Storage::disk('public')->put("$imageSaveName/full.webp", strval($webpImage));

        $imageDb = new \App\Models\Image;
        $imageDb->name = $imageSaveName;
        $imageDb->save();

        return $imageDb;
    }
}