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
    Storage::cloud()->delete($file['path']);

    // return 'File was deleted from Google Drive';
    // $b = '';
    // $b = bcrypt('a');
    // dd($b);
    
});


Route::get('testmail', function() {
    // $data = array('name'=>"Thong Tran From 4TFood");
   
    //   \Mail::send(['html'=>'mail'], $data, function($message) {
    //         $message->to('ttthongcn@gmail.com', 'Tutorials Point')->subject
    //         ('Laravel Basic Testing Mail');
           
    //   });
    //   echo "Basic Email Sent. Check your inbox.";

    // $user = [
    //     'name' => 'thongtran',
    // ];

    // \Mail::to('ttthongcn@gmail.com')->send(new \App\Mail\VetifyEmail($user));  
    dd(123);

   
});
