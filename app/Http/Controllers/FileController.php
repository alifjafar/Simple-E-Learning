<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:pdf,docx,doc,pptx,ppt,xls,xlsx'
        ]);

        $file = $request->file('file');
        $filename = uniqid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $path = 'files/';
        $size = $file->getSize();
        $mime = $file->getMimeType();
        $id = Str::orderedUuid()->getHex();

        $uploadedFile = File::create([
            'id' => $id,
            'filename' => $filename,
            'path' => $path,
            'size' => $size,
            'mime' => $mime
        ]);

        Storage::putFileAs($path, $file, $filename);

        return $uploadedFile->id;

    }

    public function download($id) {

        $file = File::findOrFail($id);

        return Storage::download($file['path'] . $file['filename']);

    }
}
