<?php

namespace App\Utils\File;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class ImageResizer
{
    private Imagine $imagine;

    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    public function resizeImageAndSave(string $originalFileFolder, string $originalFilename, array $targetParams): string
    {
        $originalFilePath = $originalFileFolder.'/'.$originalFilename;

        list($imageWidth, $imageHeight) = getimagesize($originalFilePath);

        $ratio = $imageWidth / $imageHeight;
        $targetWight = $targetParams['width'];
        $targetHeight = $targetParams['height'];

        if ($targetHeight) {
            if ($targetWight / $targetHeight > $ratio) {
                $targetWight = $targetHeight * $ratio;
            } else {
                $targetHeight = $targetWight / $ratio;
            }
        } else {
            $targetHeight = $targetWight / $ratio;
        }

        $targetFolder = $targetParams['newFolder'];
        $targetFileName = $targetParams['newFilename'];

        $targetFilePath = sprintf('%s/%s', $targetFolder, $targetFileName);

        $imagineFile = $this->imagine->open($originalFilePath);
        $imagineFile->resize(
            new Box($targetWight, $targetHeight)
        )->save($targetFilePath);

        return $targetFileName;
    }
}
