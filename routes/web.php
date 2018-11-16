<?php

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
    return view('welcome');
});

Route::get('put', function () {
	// Storage::cloud()->put('test.txt', 'Hello World');
 //    return 'File was saved to Google Drive';
	$filePath = '/home/thongtran/Pictures/images (1).jpeg';
    $fileData = File::get($filePath);
    Storage::cloud()->put('image', $fileData);
    return 'File was saved to Google Drive';
});

Route::get('list', function() {
    $dir = '/';
    $recursive = false; // Có lấy file trong các thư mục con không?
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));
    return $contents->where('type', '=', 'file');

});
Route::get('delete', function() {
    $filename = 'image';
    // Tìm file và sử dụng ID (path) của nó để xóa
    $dir = '/';
    $recursive = false; //  Có lấy file trong các thư mục con không?
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));
    $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
        ->first(); // có thể bị trùng tên file với nhau!
    // Storage::cloud()->delete($file['path']);
    dd($file);
    // return 'File was deleted from Google Drive';
    // $b = '';
    // $b = bcrypt('a');
    // dd($b);
    
});
Route::get('test', function() {
   
    
});
