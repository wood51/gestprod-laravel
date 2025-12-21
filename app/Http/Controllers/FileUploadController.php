<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,png,pdf|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads', 'public');

        // Additional logic (e.g., storing file information in the database)

        return "File uploaded successfully!";
    }

    public function show()
    {
        //$url = Storage::url("uploads/{$filename}");
        $url ="";
        return view('file.show', ['url' => $url]);
    }
}
