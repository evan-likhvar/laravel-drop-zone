<?php

namespace App\Http\Controllers;

use App\Repositories\DropZoneDeleteItem;
use App\Repositories\DropZoneItem;
use App\Repositories\DropZoneStoreItem;
use App\Repositories\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class ResizableController extends Controller
{
    const IMAGE_GALLERY_SIZE = [
        '_S' => [230,171],
        '_XS' => [110,82]
    ];

    public function show()
    {
        return view('resizable');
    }

    public function store(Request $request)
    {

        //todo validate request file exist
        //todo add size for preview

        try {

            $dropZoneStoreItem = new DropZoneStoreItem($request->input('id').'/'.$request->input('type'));

            $dropZoneItem = $dropZoneStoreItem->store($request->file('file'));

            $dropZoneStoreItem->setPreviewWidth(320);
            $dropZoneStoreItem->createPreview();

            //dd($this);

        } catch (\Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }

        //todo validate $dropZoneItem

        $this->createImageGallery($dropZoneItem);

        return Response::json([
            'message' => 'Image saved Successfully'
        ], 200);
    }

    public function delete(Request $request)
    {
        //todo validate request file exist
        //todo add size for preview
        //

        $dropZoneResponce = (
            new DropZoneDeleteItem($request->input('id').'/'.$request->input('type'))
        )->delete();

        //todo validate $dropZoneItem

        return Response::json([
            'message' => 'Image deleted Successfully'
        ], 200);
    }

    public function getPreview($id,$type)
    {
        $dropZoneItem = new DropZoneItem($id.'/'.$type);

        try {
            return $dropZoneItem->getPreviewInfo();
        } catch (\Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function createImageGallery(DropZoneItem $dropZoneItem)
    {
        $imageResize = new ImageResize(
            $dropZoneItem->getFullPathToOriginalFile(),
            $dropZoneItem->getFullPathToOriginalDirectory().'gallery/'
        );

        $path_parts = pathinfo($dropZoneItem->getFullPathToOriginalFile());

        foreach(self::IMAGE_GALLERY_SIZE as $size => $dimension) {
            $imageResize->setTargetWith($dimension[0]);
            $imageResize->setTargetHeight($dimension[1]);
            $imageResize->setTargetImageName($path_parts['filename'].$size.'.'.$path_parts['extension']);
            $imageResize->resize();
        }
    }
}
