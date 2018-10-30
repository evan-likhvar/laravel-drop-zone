<?php
/**
 * Created by PhpStorm.
 * User: evan
 * Date: 30.10.18
 * Time: 10:39
 */

namespace App\Repositories;


use Illuminate\Support\Facades\Storage;

class DropZoneDeleteItem
{
    private $dropZoneItem;

    public function __construct($itemIndex)
    {
        $this->dropZoneItem = new DropZoneItem($itemIndex);
    }

    public function delete()
    {
        Storage::deleteDirectory($this->dropZoneItem->getRelativePathToDropZoneItemIndexDirectory());
        return true;
    }
}