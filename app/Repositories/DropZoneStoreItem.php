<?php
/**
 * Created by PhpStorm.
 * User: evan
 * Date: 30.10.18
 * Time: 9:43
 */

namespace App\Repositories;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DropZoneStoreItem
{
    private $dropZoneItem;

    public function __construct($itemIndex)
    {
        $this->dropZoneItem = new DropZoneItem($itemIndex);
    }

    public function store(UploadedFile $uploadFile): DropZoneItem
    {
        if ($this->dropZoneItem->isItemIndexExist())
            throw new \Exception('Item already exists');

        $this->dropZoneItem->setFileName($uploadFile->getClientOriginalName());

        $this->storeOriginalFile($uploadFile);

        Storage::makeDirectory($this->dropZoneItem->getRelativePathToDropZonePreviewFilesDirectory());

        (new ImageResize(
            $this->dropZoneItem->getFullPathToOriginalFile(),
            $this->dropZoneItem->getFullPathToDropZonePreviewDirectory(),
            235,175)
        )->resize();

        return $this->dropZoneItem;
    }

    private function storeOriginalFile(UploadedFile $uploadFile): void
    {
        $uploadFile->storeAs(
            $this->dropZoneItem->getRelativePathToOriginalFilesDirectory(),
            $this->dropZoneItem->getFileName()
        );
    }
}