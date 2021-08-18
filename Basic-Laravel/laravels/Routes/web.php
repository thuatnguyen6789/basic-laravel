<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;
use App\Models\password_resets;



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

Route::get('profile/{name}',[ProfileController::class,'showProfile']);

Route::get('about',[AboutController::class,'showWelcome']);
Route::get('home',[HomeController::class,'showWelcome']);

Route::get('/', function (){
    return view('welcome');
});


/* Route::get('about',function (){
   return 'About Content';
});
*/
Route::get('about/directions',array('as' => 'directions', function(){
    $theURL = URL::route('directions');
    return "Directions go to this URL: $theURL";
}));

Route::any('submit-form',function (){
    return 'Process Form';
});

/*
Route::get('about/{theSubject}',function ($theSubject){
    return $theSubject. ' content goes here';
});
*/

Route::get('about/{theSubject}',[AboutController::class,'showSubject']);

Route::get('about/classes/{theSubject}',function ($theSubject){
    return " Content on $theSubject";
});

Route::get('about/classes/{theArt}/{thePrice}',function ($theArt, $thePrice){
    return "The product: $theArt and $thePrice";
});

Route::get('where',function (){
    return Redirect::to('about/directions');
});

// Thêm dữ liệu vào 1 bảng
Route::get('/insert',function (){[
    DB::insert('insert into posts(title,body,is_admin) values(?,?,?)',['PHP with Laravel','Laravel is the best fremework !',0])];
    return 'Done';
});
Route::get('/insert',function (){[
    DB::insert('insert into posts(title,body,is_admin) values(?,?,?)',['PHP with Laravel','Laravel is the best fremework !',0])];
    return 'Done';
});
Route::get('/insert',function (){[
    DB::insert('insert into posts(title,body,is_admin) values(?,?,?)',['PHP with Laravel','Laravel is the best fremework !',0])];
    return 'Done';
});

// In ra dữ liệu của 1 bảng
Route::get('/read',function (){
    $result = DB::select('select * from posts where id = ?',[1]);
    // hiện tất cả
    //  return $result;

    // hiện từng cái
    foreach ($result as $posts){
        return $posts->body;
    }
});


// Sửa dữ liệu bảng
Route::get('/update',function ()
{
    $update = DB::update('update posts set title = "New Title hihi" where id > ? ',[1]);
    return $update;
});


// Xóa dữ liệu 1 bảng
Route::get('/delete',function (){
    $delete = DB::delete('delete from posts where id = ?',[3]);
    return $delete;
});


// Lấy toàn bộ dữ liệu hoặc 1 cái của một bảng
Route::get('/readAll',function (){
    $posts = Post::all();
    // -lấy ra hết
    // echo $posts;


    //-lấy ra từng cái
    foreach ($posts as $p) {
        echo $p->title . " " . $p ->body . " " .$p->is_admin;
        echo "<br>";
    }
});

Route::get('/password',function (){
    $pass = password_resets::all();
    return $pass;
});


// Tìm kiếm dữ liệu của bảng bắng id
Route::get('/findId',function (){
    $posts = Post::where('id',2)
        ->orderBy('id','desc')
        ->take(1)
        ->get();
    foreach ($posts as $p) {
        echo $p->title . " " . $p ->body . " " .$p->is_admin;
        echo "<br>";
    }
});

//Tìm kiếm nâng cao bằng id, body, title, ..
Route::get('/findIds',function (){
    $posts = Post::where('id', '>=', 1)
        ->where('title','PHP with Laravel')
        ->where('body','like','$laravel%')
        ->orderBy('id','desc')
        // take lấy số lượng bản ghi muốn lấy
        ->take(10)
        ->get();
    foreach ($posts as $p) {
        echo $p->title ;
        echo "<br>";
    }
});


// Thêm mới 1 bản ghi vào database
Route::get('/insertORM',function (){
    $p = new Post;
    $p ->title = 'insert ORm';
    $p ->body = 'INSERT done done ORM';
    $p ->is_admin = 1;
    $p ->save();
});


// Câp nhật(sửa) bản ghi
Route::get('updateORM',function (){
    $p =  Post::where('id',5)->first();
    $p ->title = 'updated ORM';
    $p ->body ='updated Ahihi DOne Done';
    $p ->save();
});


// Xóa 1 bản ghi

// C1
Route::get('deleteORM',function (){
    // xóa bản ghi số mấy hoặc là từ đâu đến đâu
    Post::where('id', '>=', 10)
        ->delete();
});

// C2
Route::get('destroyORM',function (){
    Post::destroy([7,9]);
});
