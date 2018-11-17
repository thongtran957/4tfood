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
	$filePath = '/home/thongtran/Pictures/download.jpeg';
    $fileData = File::get($filePath);
    Storage::cloud()->put('image1', $fileData);
    return 'File was saved to Google Drive';
});

Route::get('list', function() {
    $dir = '/';
    $recursive = false; // Có lấy file trong các thư mục con không?
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));
    return $contents->where('type', '=', 'file');

});
Route::get('delete', function() {
    $filename = 'image1';
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
    $a = [2, 3,3];
    $array = [];
    foreach ($a as $key1 => $value1) {
        $temp = $value1;
        $b = array_slice($a,$key1+1);
        foreach ($b as $key2 => $value2) {
            if($value2 == $temp){
                array_push($array,$key2 +$key1+1);
            }
        }
    }
    if(empty($array)){
        return -1;
    }else{
        $min = $array[0];
        foreach ($array as $key => $value) {
            if($value < $min){
                $min = $value;
            }
        } 
        return $a[$min];
    }
    
    
});
