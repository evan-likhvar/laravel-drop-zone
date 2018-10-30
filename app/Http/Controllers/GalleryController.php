<?php

namespace App\Http\Controllers;

use App\Repositories\DropZoneDeleteItem;
use App\Repositories\DropZoneItem;
use App\Repositories\DropZoneStoreItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class GalleryController extends Controller
{
    public function show()
    {
        return view('gallery');
    }

    public function store(Request $request)
    {

        //todo validate request file exist
        //todo add size for preview

        try {
            $dropZoneItem = (
                new DropZoneStoreItem($request->input('id').'/'.$request->input('type'))
            )->store($request->file('file'));
        } catch (\Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }

        //todo validate $dropZoneItem

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
}
