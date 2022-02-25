<?php

use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookingController as BkController;
use App\Http\Controllers\CustomerController as CusController;
use Illuminate\Support\Facades\Route;

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
Route::get('admin/login',[AdminController::class,'login'])->name('login');
Route::post('admin/login',[AdminController::class,'sign_in'])->name('signin');


Route::group(['prefix' => 'admin','middleware' => 'auth'] , function (){
    Route::get('',[AdminController::class,'index'])->name('admin.index');
    Route::get('logout',[AdminController::class,'sign_out'])->name('logout');
    Route::resources([
        'account' => AdminAccountController::class,
        'customer' => CustomerController::class,
        'category' => CategoryController::class,
        'hotel' => HotelController::class,
        'banner' => BannerController::class,
        'room' => RoomController::class,
        'booking' => BookingController::class,
        'service' => ServiceController::class,
        'city' => CityController::class,
        'infomation' => InfoController::class,
        'blog' => BlogController::class,
    ]);
    // update status booking
    Route::get('update-status/{booking}',[BookingController::class,'update_status'])->name('admin.booking.status');
});


Route::group(['prefix' => '' ], function(){
    Route::get('',[ClientController::class,'index'])->name('client.index');
    Route::get('room',[ClientController::class,'room'])->name('client.room');
    Route::get('room/detail/{room}',[ClientController::class,'detail'])->name('client.room.detail');
    Route::get('login',[ClientController::class,'login'])->name('client.login');
    Route::post('login',[CusController::class,'submit_login']);
    Route::get('logout',[CusController::class,'logout'])->name('client.logout');
    Route::get('register',[ClientController::class,'register'])->name('client.register');
    Route::post('register',[CusController::class,'submit_register']);
    Route::get('contact',[ClientController::class,'contact'])->name('client.contact');
    Route::post('contact',[ClientController::class,'contact_mail']);
    Route::get('about',[ClientController::class,'about'])->name('client.about');
    Route::get('checkout',[ClientController::class,'checkout'])->name('client.checkout');
    Route::post('checkout',[ClientController::class,'booking'])->name('client.checkout.booking');
    Route::get('amout',[ClientController::class,'amout'])->name('client.checkout.amout');
    Route::get('forgot-password',[CusController::class,'forgot_password'])->name('client.forgot.password');
    Route::post('forgot-password',[CusController::class,'confirm_email']);
    Route::get('confirm/{email}/{token}',[CusController::class,'confirm_request'])->name('client.confirm.request');
    Route::post('confirm/{email}/{token}',[CusController::class,'change_password'])->name('client.confirm.change');

    Route::group(['prefix' => 'blog'],function(){
        Route::get('',[ClientController::class,'blog'])->name('client.blog');
        Route::get('detail/{blog}',[ClientController::class,'blog_detail'])->name('client.blog.detail');
    });

    // profile customer
    Route::group(['prefix' => 'profile','middleware' => 'cus'],function(){
        Route::get('',[CusController::class,'profile'])->name('client.profile');
        Route::post('upload',[CusController::class,'upload'])->name('client.profile.upload');
        Route::get('update',[CusController::class,'form_update'])->name('client.profile.update');
        Route::post('update',[CusController::class,'update']);
        Route::get('history',[CusController::class,'history'])->name('client.profile.history');
        Route::get('change-password',[CusController::class,'form_change_password'])->name('client.profile.change.password');
        Route::post('change-password',[CusController::class,'submit_change_password']);
        Route::get('history/{id}',[CusController::class,'detail_booking'])->name('client.profile.booking');
    });

    // Route Booking Room
    Route::get('roomData',[ClientController::class,'room_data'])->name('client.room.data');
    Route::get('review/{id}',[ReviewController::class,'get_review_by_room'])->name('client.room.review');
    Route::post('review',[ReviewController::class,'add_review'])->name('client.add.review');

    Route::group(['prefix' => 'booking'],function(){
        Route::get('',[BkController::class,'index'])->name('client.booking');
        Route::get('add/{room}',[BkController::class,'add'])->name('booking.add');
        Route::get('delete/{id}',[BkController::class,'delete'])->name('booking.delete');
        Route::get('clear',[BkController::class,'clear'])->name('booking.clear');
        Route::post('update',[BkController::class,'update'])->name('booking.update');
        Route::get('delete/service/{id_bk}/{id_service}',[BkController::class,'delete_service'])->name('delete.service');
        Route::get('data',[BkController::class,'main_booking'])->name('client.booking.data');
        Route::get('check-sale',[BkController::class,'check_sale'])->name('client.check.sale');
    });
});