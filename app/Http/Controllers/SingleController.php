<?php

namespace App\Http\Controllers;

use App\Repositories\DropZoneItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SingleController extends Controller
{
    public function show()
    {
        return view('single');
    }

    public function store(Request $request)
    {
        //$file = $request->file('file');

        $dropZoneItem = new DropZoneItem('single',$request->file('file')->getClientOriginalName() );

        $request->file('file')->storeAs(
            $dropZoneItem->getRelativePathToOriginalFilesDirectory(), $dropZoneItem->getFileName()
        );

        Storage::makeDirectory($dropZoneItem->getRelativePathToDropZonePreviewFilesDirectory());

        Image::make($dropZoneItem->getFullPathToOriginalFile())
            ->resize(250, null, function ($constraints) {
                $constraints->aspectRatio();
            })
            ->save($dropZoneItem->getFullPathToDropZonePreviewFile());

        return Response::json([
            'message' => 'Image saved Successfully'
        ], 200);
    }
}
