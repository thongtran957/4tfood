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
	$filePath = '/home/thongtran/Pictures/Screenshot from 2018-09-16 21-32-02.png';
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
    // $filename = 'image';
    // // Tìm file và sử dụng ID (path) của nó để xóa
    // $dir = '/';
    // $recursive = false; //  Có lấy file trong các thư mục con không?
    // $contents = collect(Storage::cloud()->listContents($dir, $recursive));
    // $file = $contents
    //     ->where('type', '=', 'file')
    //     ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
    //     ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
    //     ->first(); // có thể bị trùng tên file với nhau!
    // // Storage::cloud()->delete($file['path']);
    // dd($file);
    // return 'File was deleted from Google Drive';
    // $b = '';
    // $b = bcrypt('a');
    // dd($b);
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
       	dd($characters[61]);
    $charactersLength = strlen($characters);

    $randomString = '';
    for ($i = 0; $i < $charactersLength; $i++) {

        $randomString .= $characters[rand(0, $charactersLength - 1)];
        if($i == 2)
        	dd($randomString);
    }
    return $randomString;
});
