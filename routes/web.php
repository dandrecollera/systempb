<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CameraSettings;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('main');
});


Route::get('/settings', function () {
    return view('settings');
});

Route::post('/store-image', function(Request $request) {
    // Get the image data from the request
    $imageData = $request->input('image');
    
    // Decode the image data and save it to storage
    $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
    $filename = 'image-' . time() . '.png';
    Storage::put('public/images/' . $filename, $image);
    
    // Return a response
    return response()->json(['success' => true]);
});

// Route::post('/save-image', function (Request $request) {
//     $imageData = $request->input('imageData');
//     $imageName = $request->input('imageName');

//     $imageData = str_replace('data:image/png;base64,', '', $imageData);
//     $imageData = str_replace(' ', '+', $imageData);
//     $imageData = base64_decode($imageData);

//     Storage::disk('public')->put('images/' . $imageName, $imageData);

//     return response()->json(['success' => true]);
// });
