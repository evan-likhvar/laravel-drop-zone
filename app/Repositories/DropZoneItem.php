<?php
/**
 * Created by PhpStorm.
 * User: evan
 * Date: 29.10.18
 * Time: 15:59
 */

namespace App\Repositories;


use Illuminate\Support\Facades\Storage;
use SplFileInfo;

class DropZoneItem
{
    private $absolutePathToStorage;                 // path to Laravel's storage directory
    private $relativePathToStorageDropZone;         // path to DropZone's directory into Laravel's storage directory
    private $dropZoneHomeDirectory;                 // directory name into Laravel's storage where dropzone files in
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

    public function getPreviewInfo(): array
    {

        if (count($file = Storage::files($this->getRelativePathToDropZonePreviewFilesDirectory())) != 1)
            throw new \Exception('Can\'t locate preview file' );

        $fileInfo = new SplFileInfo($this->absolutePathToStorage.'/app/'.$file[0]);

        if (empty($fileInfo))
            throw new \Exception('Can\'t read preview file' );

        return [
            'link'=>'/'.$file[0],
            'name'=>$fileInfo->getFilename(),
            'size'=>$fileInfo->getSize(),
            'test'=>320
        ];
    }

    public function getFullPathToOriginalFile(): string
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

    public function getFullPathToOriginalDirectory(): string
    {
        return
            $this->absolutePathToStorage
            . $this->relativePathToStorageDropZone
            . DIRECTORY_SEPARATOR
            . $this->itemIndex
            . $this->itemOriginalPath
            . DIRECTORY_SEPARATOR;
    }

    public function getFullPathToDropZonePreviewFile(): string
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
    public function getFullPathToDropZonePreviewDirectory(): string
    {
        return
            $this->absolutePathToStorage
            . $this->relativePathToStorageDropZone
            . DIRECTORY_SEPARATOR
            . $this->itemIndex
            . $this->dropZoneThumbNail
            . DIRECTORY_SEPARATOR;
    }
    /**
     * for $request->file('file')->storeAs(
     * $dropZoneItem->getDropZoneHomeDirectory(), $request->file('file')->getClientOriginalName()
     * );
     *
     * @return string
     */
    public function getRelativePathToOriginalFilesDirectory(): string
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
    public function getRelativePathToDropZonePreviewFilesDirectory(): string
    {
        return
            $this->dropZoneHomeDirectory
            . DIRECTORY_SEPARATOR
            . $this->itemIndex
            . $this->dropZoneThumbNail;
    }

    /**
     * for Storage::deleteDirectory($this->dropZoneItem->get);
     *
     * @return string
     */
    public function getRelativePathToDropZoneItemIndexDirectory(): string
    {
        return
            $this->dropZoneHomeDirectory
            . DIRECTORY_SEPARATOR
            . $this->itemIndex;
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
     * @param string $itemOriginalPath
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

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * set file name for uploaded file in site filesystem
     *
     * @param null $fileName
     */
    public function setFileName($fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode([
            'absolutePathToStorage' => $this->absolutePathToStorage,
            'relativePathToStorageDropZone' => $this->relativePathToStorageDropZone,
            'itemIndex' => $this->itemIndex,
            'itemOriginalPath' => $this->itemOriginalPath,
            'dropZoneThumbNail' => $this->dropZoneThumbNail,
            'fileName' => $this->fileName,
            'dropZoneHomeDirectory' => $this->dropZoneHomeDirectory,
        ]);
    }


}