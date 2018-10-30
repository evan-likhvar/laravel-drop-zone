<?php
/**
 * Created by PhpStorm.
 * User: evan
 * Date: 30.10.18
 * Time: 18:39
 */

namespace App\Repositories;


use Intervention\Image\Facades\Image;

class ImageResize
{

    private $imageFullName;
    private $splImage;
    private $image;

    private $targetWith;
    private $targetHeight;
    private $targetDirectory = '/gallery';

    public function __construct(string $imageFullName, int $targetWith, int $targetHeight)
    {
        $this->imageFullName = $imageFullName;
        $this->splImage = new \SplFileInfo($imageFullName);
        $this->targetWith = $targetWith;
        $this->targetHeight = $targetHeight;

        $this->image = Image::make($this->imageFullName);
    }

    /**
     * @param string $targetDirectory
     */
    public function setTargetDirectory(string $targetDirectory): void
    {
        $this->targetDirectory = $targetDirectory;
    }

    private function setOriginalImageSize()
    {

    }
}