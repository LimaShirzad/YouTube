<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\admincontroller;
use App\Http\Middleware\cheacklogin; 
use App\Http\Middleware\userloginme; 
// use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});
Route::get("youtube",[admincontroller::class,'home_page'])->name("youtube")
->middleware(userloginme::class);


Route::get('view_video_people/{id}',[admincontroller::class,'view_video'])
->name('view_video_people')
->middleware(userloginme::class);

Route::get('view_channel/{id}',[admincontroller::class,'view_my_channel'])
->name('view_channel');

Route::get('sub/{id}',[admincontroller::class,'sub_channel'])->name('sub')
->middleware(userloginme::class);


Route::view('first','viewrs.first');
Route::view('useracount','viewrs.creat_login')->name('useracount');
Route::view('userlogin','viewrs.loginuser')->name("userlogin");

Route::post("userloginmatch",[admincontroller::class,'userlogin'])->name("userloginmatch");



Route::post('create_acount',[admincontroller::class,'create_acount_fun'])->name("create_acount");


Route::get('userlogout',[admincontroller::class,'userlogout'])->name("userlogout");






Route::get('/search_data',[admincontroller::class,'search_video'])->name('search_data');

Route::get('gatagory_show/{id}',[admincontroller::class,'gatagory_show_fun'])->name('gatagory_show');

Route::get('channel_video/{id}',[admincontroller::class,'channel_video_view'])->name('channel_video');

Route::view('creat',"viewrs.creatacout")->name("creat");

Route::post("saveData",[usercontroller::class,'StoreUserData'])->name("saveData");

Route::view('login',"viewrs.login")->name("login");
Route::post("loginMatch",[usercontroller::class,'login'])->name("loginMatch");
//  ->middleware(loginme::class);
// page


// logout

Route::get("logout",[usercontroller::class,'logout'])->name("logout");

Route::view('home',"acount.header")
->name("home")
->middleware(cheacklogin::class);
Route::get('view_profile/{id}',[usercontroller::class,'view_profile'])
->name("view_profile")
->middleware(cheacklogin::class);

Route::get('upload_video/{id}',[usercontroller::class,'upload_video'])
->name("upload_video")
->middleware(cheacklogin::class);

Route::post("send_video/{id}",[usercontroller::class,'send_video_youtube'])->name('send_video');


// Route::view('home','viewrs.home')->name("acount_home");
Route::get('view_info/{id}',[usercontroller::class,'view_your_video'])
->name("view_info")
->middleware(cheacklogin::class);

Route::get('update_video/{id}',[usercontroller::class,'update_video_id'])
->name("update_video")
->middleware(cheacklogin::class);

Route::post('update_video_form/{id}',[usercontroller::class,'update_video_fun'])
->name("update_video_form")
->middleware(cheacklogin::class);

Route::get('delete_video/{id}',[usercontroller::class,'delete_my_video'])
->name("delete_video")
->middleware(cheacklogin::class);

Route::get('view_video/{id}',[usercontroller::class,'view_video_fun'])
->name("view_video")
->middleware(cheacklogin::class);


Route::get('update_profile/{id}',[usercontroller::class,'update_profile_view'])
->name("update_profile")
->middleware(cheacklogin::class);

// update_my_profile
// 
Route::get('Dleted_profile/{id}',[usercontroller::class,'Dleted_acount'])
->name("Dleted_profile")
->middleware(cheacklogin::class);

Route::put('update_my_profile/{id}',[usercontroller::class,'update_my_profile_function'])
->name("update_my_profile")
->middleware(cheacklogin::class);


// count user part end



// admin par
Route::view('gatagory',"admin.addgatagory")->name('gatagory');
Route::post('add_gatagory',[admincontroller::class,'add_gatagory_function'])->name("add_gatagory");