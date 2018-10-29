<?php
/**
 * Created by PhpStorm.
 * User: evan
 * Date: 29.10.18
 * Time: 15:59
 */

namespace App\Repositories;


class DropZoneItem
{
    private $absolutePathToStorage;                 // path to Laravel's storage directory
    private $relativePathToStorageDropZone;         // path to DropZone's directory into Laravel's storage directory
    private $dropZoneHomeDirectory;
    private $itemIndex;                             // items directory into DropZone's directory
    private $itemOriginalPath = '/original';        // directory for original downloaded files
    private $dropZoneThumbNail = '/preview';        // directory for dropzone preview
    private $fileName;                              // original name of uploaded file

    public function __construct($itemIndex = null, $fileName = null)
    {
        $this->absolutePathToStorage = storage_path();
        $this->dropZoneHomeDirectory = 'images';
        $this->relativePathToStorageDropZone = '/app/' . $this->dropZoneHomeDirectory;
        $this->itemIndex = $itemIndex;
        $this->fileName = $fileName;
    }

    public function getFullPathToOriginalFile()
    {
        return
            $this->absolutePathToStorage
            . $this->relativePathToStorageDropZone
            . DIRECTORY_SEPARATOR
            . $this->itemIndex
            . $this->itemOriginalPath
            . DIRECTORY_SEPARATOR
            . $this->fileName;
    }

    public function getFullPathToDropZonePreviewFile()
    {
        return
            $this->absolutePathToStorage
            . $this->relativePathToStorageDropZone
            . DIRECTORY_SEPARATOR
            . $this->itemIndex
            . $this->dropZoneThumbNail
            . DIRECTORY_SEPARATOR
            . $this->fileName;
    }

    /**
     * for $request->file('file')->storeAs(
     * $dropZoneItem->getDropZoneHomeDirectory(), $request->file('file')->getClientOriginalName()
     * );
     *
     * @return string
     */
    public function getRelativePathToOriginalFilesDirectory()
    {
        return
            $this->dropZoneHomeDirectory
            . DIRECTORY_SEPARATOR
            . $this->itemIndex
            . $this->itemOriginalPath;
    }

    /**
     * for Storage::makeDirectory($dropZoneItem->getFullPathToDropZonePreviewFile());
     *
     * @return string
     */
    public function getRelativePathToDropZonePreviewFilesDirectory()
    {
        return
            $this->dropZoneHomeDirectory
            . DIRECTORY_SEPARATOR
            . $this->itemIndex
            . $this->dropZoneThumbNail;
    }

    public function isItemIndexExist(): bool
    {
        return $this->itemIndex ? file_exists(
            $this->absolutePathToStorage
            . $this->relativePathToStorageDropZone
            . DIRECTORY_SEPARATOR
            . $this->itemIndex
        ) : false;
    }

    /**
     * @param string $absolutePathToStorage
     */
    public function setAbsolutePathToStorage(string $absolutePathToStorage): void
    {
        $this->absolutePathToStorage = $absolutePathToStorage;
    }

    /**
     * @param string $relativePathToStorageDropZone
     */
    public function setRelativePathToStorageDropZone(string $relativePathToStorageDropZone): void
    {
        $this->relativePathToStorageDropZone = $relativePathToStorageDropZone;
    }

    /**
     * @param string $itemOriginal
     */
    public function setItemOriginal(string $itemOriginalPath): void
    {
        $this->itemOriginalPath = $itemOriginalPath;
    }

    /**
     * @param string $dropZoneThumbNail
     */
    public function setDropZoneThumbNail(string $dropZoneThumbNail): void
    {
        $this->dropZoneThumbNail = $dropZoneThumbNail;
    }

    public function __toString()
    {
        return json_encode([
            'absolutePathToStorage' => $this->absolutePathToStorage,
            'relativePathToStorageDropZone' => $this->relativePathToStorageDropZone,
            'itemIndex' => $this->itemIndex,
            'itemOriginalPath' => $this->itemOriginalPath,
            'dropZoneThumbNail' => $this->dropZoneThumbNail,
            'fileName' => $this->fileName,
            //'relativePathToStorageDropZone' => $this->relativePathToStorageDropZone,
        ]);
    }

    /**
     * @return null
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}