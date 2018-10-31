<?php

namespace App\Repositories;

use Intervention\Image\Facades\Image;

class ImageResize
{
    private $imageFullName;
    private $splImage;
    private $image;

    private $fullPathToTargetDirectory;
    private $targetWith;
    private $targetHeight;

    private $targetImageName;

    public function __construct(
        string $imageFullName,
        string $fullPathToTargetDirectory,
        int $targetWith = 200,
        int $targetHeight = null,
        string $targetImageName = null)
    {
        $this->imageFullName = $imageFullName;
        $this->targetWith = $targetWith;
        $this->targetHeight = $targetHeight;

        $this->splImage = new \SplFileInfo($imageFullName);

        $this->image = Image::make($this->imageFullName);

        $this->fullPathToTargetDirectory = $fullPathToTargetDirectory;
        $this->targetImageName = $targetImageName ? $targetImageName : $this->splImage->getFilename();
    }

    public function resize()
    {
        if (!file_exists($this->fullPathToTargetDirectory))
            mkdir($this->fullPathToTargetDirectory, 0755);

        if ($this->targetHeight) {
            if ($this->resizeDirection() && $this->targetHeight)
                Image::make($this->imageFullName)
                    ->resize(null, $this->targetHeight, function ($constraints) {
                        $constraints->aspectRatio();
                    })
                    ->crop($this->targetWith, $this->targetHeight)
                    ->save($this->fullPathToTargetDirectory . $this->targetImageName);
            else
                Image::make($this->imageFullName)
                    ->resize($this->targetWith, null, function ($constraints) {
                        $constraints->aspectRatio();
                    })
                    ->crop($this->targetWith, $this->targetHeight)
                    ->save($this->fullPathToTargetDirectory . $this->targetImageName);
        } else {
            Image::make($this->imageFullName)
                ->resize($this->targetWith, null, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($this->fullPathToTargetDirectory . $this->targetImageName);
        }
    }

    private function resizeDirection(): bool
    {
        return $this->image->height() / $this->image->width() > 1 ? false : true;
    }

    /**
     * @param int $targetWith
     */
    public function setTargetWith(int $targetWith): void
    {
        $this->targetWith = $targetWith;
    }

    /**
     * @param int $targetHeight
     */
    public function setTargetHeight(int $targetHeight): void
    {
        $this->targetHeight = $targetHeight;
    }

    /**
     * @param string $targetImageName
     */
    public function setTargetImageName(string $targetImageName): void
    {
        $this->targetImageName = $targetImageName;
    }
}