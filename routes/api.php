<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//API Category
Route::get('show_category', 'CategoryController@api_show');
Route::post('category', 'CategoryController@api_store');
Route::delete('delete_category/{id}', 'CategoryController@api_delete');
Route::put('update_category/{id}', 'CategoryController@api_update');

// Locations
Route::post('location', 'LocationController@api_store');
Route::post('update-location/{id}', 'LocationController@api_update');
Route::delete('delete-location/{id}', 'LocationController@apiDelete');
Route::get('show_location', 'LocationController@api_show');
Route::get('getid_location/{id}', 'LocationController@api_getId');


// Reders
Route::post('reder', 'RederController@apiStore');
Route::put('update-reder/{id}', 'RederController@apiUpdate');
Route::delete('update-reder/{id}', 'RederController@apiDelete');
Route::get('reder', 'RederController@apiShow');

//API Banner
Route::get('show_banner', 'BannerController@api_show');
Route::post('banner', 'BannerController@api_store');
Route::delete('delete_banner/{id}', 'BannerController@api_delete');
Route::post('update_banner/{id}', 'BannerController@api_update');


// User
Route::put('update-user/{id}', 'UserController@apiUpdate');
Route::delete('update-user/{id}', 'UserController@apiDelete');
Route::get('user', 'UserController@apiShow');


// Review
Route::post('review', 'RateController@apiStore');
// Route::delete('update-review/{id}', 'Re@apiDelete');
Route::get('review', 'RateController@apiShow');
Route::get('getuser_review/{id}', 'RateController@getUser_review');
Route::put('update_reply/{id}', 'RateController@apiUpdate');


// Booking
Route::post('booking', 'BookingController@apiStore');
// Route::delete('update-review/{id}', 'Re@apiDelete');
Route::get('booking', 'BookingController@apiShow');
Route::get('getuser_booking/{id}', 'BookingController@getUser_Booking');
Route::post('update_booking/{id}', 'BookingController@apiUpdate');



// Wishlist 
Route::get('wishlist', 'WishlistController@apiShow');
// Oder 
Route::get('oder', 'OderController@apiShow');
//API car
Route::get('dasbroad', 'CarController@api_show');
Route::get('getid_dasbroad/{id}', 'CarController@api_getId');
Route::post('add_dasbroad', 'CarController@api_store');
Route::delete('delete_car/{id}', 'CarController@api_delete');
Route::post('update_car/{id}', 'CarController@api_update');


//API comment
Route::get('show_comment', 'CommentController@api_show');
Route::post('comment', 'CommentController@api_store');
Route::delete('delete_comment/{id}', 'CommentController@api_delete');

//API history 
Route::get('show_history', 'HistoryController@api_show');
Route::get('getuser_history/{id}', 'HistoryController@getuser_history');
Route::post('history', 'HistoryController@api_store');
Route::delete('delete_history/{id}', 'HistoryController@api_delete');


//API contact
Route::get('show_contact', 'ContactController@api_show');
Route::post('contact', 'ContactController@api_store');
// Route::delete('delete_contact/{id}', 'ContactController@api_delete');
// Route::post('update_contact/{id}', 'ContactController@api_update');


//API Sale
Route::get('show_sale', 'SaleController@api_show');
Route::post('sale', 'SaleController@api_store');
Route::delete('delete_sale/{id}', 'SaleController@api_delete');


// District
Route::post('district', 'DistriController@apiStore');
Route::get('getid_district/{id}', 'DistriController@api_getId');
Route::post('update-district/{id}', 'DistriController@apiUpdate');
Route::delete('delete-district/{id}', 'DistriController@apiDelete');
Route::get('district', 'DistriController@apiShow');





// Hi???n th??? l???ch s??? thanh to??n : 
Route::get('history' , 'APIYotripController@getAPIHistory');
// T??m ki???m xe :\
Route::get('search-cars-location', 'APIYotripController@getAPISortCar');
// T??m ki???m xe theo khu v???c v?? th???i gian :\
Route::get('search-cars-location-time', 'APIYotripController@getAPILotionCars');
// Ch????ng tr??nh gi???i thi???u : 
Route::get('invite', 'APIYotripController@getAPIInvite');
// danh s??ch m?? khuy???n m??i: 
Route::get('coupon/{id}' , 'APIYotripController@getAPICoupny');
// T??m ki???m m?? khuy???n m??i :
Route::get('search-coupon-key' , 'APIYotripController@getAPISearchCoupon');

// Th??m xe v??o danh s??ch y??u th??ch:
Route::get('wishlist/show/{id}', 'APIYotripController@getAPIShowWishList');
Route::post('wishlist/add' , 'APIYotripController@getAPIAddWishlist');
Route::get('wishlist/remove/{id}', 'APIYotripController@getAPIRemoveWishList');

// Thay ?????i m???t kh???u : 
Route::get('changepassword/user/{id}', 'APIYotripController@getAPIChangeUserPassword');
Route::post('changepassword/user/save', 'APIYotripController@changPasswordStore');

// Danh s??ch xe : 
Route::get('get-cars-list', 'APIYotripsController@getAPICars');
// Danh s??ch t??? l??i : 
Route::get('get-cars-driving-list', 'APIYotripController@getAPIDriving');
// Danh s??ch c?? t??i x??? : 
Route::get('get-cars-drive-list', 'APIYotripController@getAPIDrive');
// Chi ti???t xe : 
Route::get('get-cars-list/{id}', 'APIYotripController@getAPICarsID');
// Hi???n th??? b???ng gi?? khi hi???n th??? chi ti???t :
Route::get('get-cars-table-cost-date/{id}', 'APIYotripController@getAPITableCars');


// Danh s??ch khu v???c: 
Route::get('get-location-cars-list', 'APIYotripController@getAPILocation');
// li???t k?? Xe theo khu v???c:
Route::get('get-location-cars-list/{id}', 'APIYotripController@getAPILocationID');
// Qu???n , huy???n li??n k???t v???i khu v???c:
Route::get('get-location-district-list', 'APIYotripController@getAPIDistrict');

// Danh s??ch h??ng xe: 
Route::get('get-renders-cars-list', 'APIYotripController@getAPIRenders');

// li??t k??? xe theo lo???i ch??? ng???i c???a xe : 
Route::get('get-seats-cars-list', 'APIYotripController@getAPISeats');

// hi???n th??? banners trang yotrip: 
Route::get('get-banner-yotrip-status', 'APIYotripController@getAPIBanners');

// hi???n th??? ????nh gi??: 
Route::get('get-cars-review-detail', 'APIYotripController@getAPIReview');


// L???y m?? khuy???n m??i cho ph????ng th???c thu?? xe : 
Route::get('get-cars-booking-coupon/{id}', 'APIYotripController@getAPICouponBooking');

// Profile : 
Route::get('get-user-profile-account/{id}', 'APIYotripController@getAPIProfile');
// ????ng xu???t : 
Route::get('get-user-logout-yotrip', 'APIYotripController@getAPILogout');
// M?? otp:
Route::post('get-user-signup-otp', 'APIYotripController@getAPIUserSubmitOTP');
Route::post('get-user-signup-yotrip', 'APIYotripController@getAPIUserRegisterSubmit');
// Login
Route::post('get-user-signin-yotrip', 'APIYotripController@getAPIFormLoginSubmit');
