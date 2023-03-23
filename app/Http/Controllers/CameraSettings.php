<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CameraSettings extends Controller
{
    public function saveImage(Request $request)
    {
        $base64_image = $request->input('base64_image');
        $imageName = 'image_'.time().'.png';
        $path = storage_path('app/public/images/' . $imageName);
        file_put_contents($path, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_image)));
        return response()->json(['success' => 'Image saved successfully']);
    }
}
