<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StatusNotification;
use Illuminate\Support\Facades\DB;
use Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\Banners;
use App\Models\Cars;
use App\Models\Contacts;
use App\Models\Locations;
use App\Models\Categories;
use App\Models\Reders;
use App\Models\Wishlists;
use App\Models\CarSales;
use App\Models\ReferralLink;
use App\Models\Bookings;
use App\Models\Historys;
use App\Models\Payment;
use App\Models\Costdate;
use App\Models\OtpEmail;
use App\Models\Reviews;
use App\Rules\MatchOldPassword;


class APIYotripController extends Controller
{
    // Lịch sử giao dịch :
    public function getAPIHistory()
    {
        $historys = Historys::all();
        return response()->json($historys, 200);
    }
    //Tìm kiếm xe : theo khu vực , loại xe , hãng xe và giá
    public function getAPISortCar(Request $request)
    {
        $sort = $request->all();
        $results = array();
        //Sort one where
        if ($sort['render'] != "render") {
            $results = Cars::with('render')->join('reders', 'red_id', '=',  'reders.id')
                ->where('red_id', '=', $request->render)->paginate(6)
                ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
        }
        if ($sort['seat'] != "seat") {
            $results = Cars::with('render')->where('seat', '=', $request->seat)
                ->paginate(6)
                ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
        }
        if ($sort['locations'] != "locations") {
            $results = Cars::with('render')->join('locations', 'locat_id', '=',  'locations.id')
                ->where('locat_id', '=', $request->locations)->paginate(6)
                ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
        }

        if ($sort['price'] != "price") {
            if ($sort['price'] == "1") {
                $results = Cars::with('render')->orderBy('price', 'ASC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            } else {
                $results = Cars::with('render')->orderBy('price', 'DESC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            }
        }
        //Sort two where
        if ($sort['render'] != "render" && $sort['seat'] != "seat") {
            $results = Cars::with('render')->join('reders', 'red_id', '=',  'reders.id')
                ->where('red_id', '=', $sort['render'])->where('seat', '=', $sort['seat'])
                ->paginate(6)
                ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
        }
        if ($sort['render'] != "render" && $sort['locations'] != "locations") {
            $results = Cars::with('render')->join('reders', 'red_id', '=',  'reders.id')
                ->join('locations', 'locat_id', '=', 'locations.id')->where('red_id', '=', $sort['render'])->where('locat_id', '=', $sort['locations'])
                ->paginate(6)
                ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
        }
        if ($sort['render'] != "render" && $sort['price'] != "price") {
            if ($sort['price'] == "1") {
                $results = Cars::with('render')->join('reders', 'red_id', '=',  'reders.id')->where('red_id', '=', $sort['render'])
                    ->orderBy('price', 'ASC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            } else {
                $results = Cars::with('render')->join('reders', 'red_id', '=',  'reders.id')->where('red_id', '=', $sort['render'])
                    ->orderBy('price', 'DESC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            }
        }
        if ($sort['seat'] != "seat" && $sort['locations'] != "locations") {
            $results = Cars::with('render')->join('locations', 'locat_id', '=',  'locations.id')
                ->where('locat_id', '=', $sort['locations'])->where('seat', '=', $sort['seat'])
                ->paginate(6)
                ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
        }
        if ($sort['seat'] != "seat" && $sort['price'] != "price") {
            if ($sort['price'] == "1") {
                $results = Cars::with('render')->where('seat', '=', $sort['seat'])->orderBy('price')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            } else {
                $results = Cars::with('render')->where('seat', '=', $sort['seat'])->orderByDesc('price')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            }
        }
        if ($sort['locations'] != "locations" && $sort['price'] != "price") {
            if ($sort['price'] == "1") {
                $results = Cars::with('render')->join('locations', 'locat_id', '=',  'locations.id')->where('locat_id', '=', $sort['locations'])
                    ->orderBy('price', 'ASC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            } else {
                $results = Cars::with('render')->join('locations', 'locat_id', '=',  'locations.id')->where('locat_id', '=', $sort['locations'])
                    ->orderBy('price', 'DESC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            }
        }
        //Sort three where
        if ($sort['render'] != "render" && $sort['seat'] != "seat" && $sort['locations'] != "locations") {
            $results = Cars::with('render')
                ->join('reders', 'red_id', '=',  'reders.id')
                ->join('locations', 'locat_id', '=', 'locations.id')
                ->where('red_id', '=', $sort['render'])
                ->where('locat_id', '=', $sort['locations'])
                ->where('seat', '=', $sort['seat'])
                ->paginate(6)
                ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
        }
        if ($sort['render'] != "render" && $sort['locations'] != "locations" && $sort['price'] != "price") {
            if ($sort['price'] == "1") {
                $results = Cars::with('render')
                    ->join('reders', 'red_id', '=',  'reders.id')
                    ->join('locations', 'locat_id', '=', 'locations.id')
                    ->where('red_id', '=', $sort['render'])
                    ->where('locat_id', '=', $sort['locations'])
                    ->orderBy('price', 'ASC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            } else {
                $results = Cars::with('render')
                    ->join('reders', 'red_id', '=',  'reders.id')
                    ->join('locations', 'locat_id', '=', 'locations.id')
                    ->where('cat_id', '=', $sort['categories'])
                    ->where('locat_id', '=', $sort['locations'])
                    ->orderBy('price', 'DESC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            }
        }
        if ($sort['render'] != "render" && $sort['seat'] != "seat" && $sort['price'] != "price") {
            if ($sort['price'] == "1") {
                $results = Cars::with('render')
                    ->join('reders', 'red_id', '=',  'reders.id')
                    ->where('red_id', '=', $sort['render'])
                    ->where('seat', '=', $sort['seat'])
                    ->orderBy('price', 'ASC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            } else {
                $results = Cars::with('render')
                    ->join('reders', 'red_id', '=',  'reders.id')
                    ->where('red_id', '=', $sort['render'])
                    ->where('seat', '=', $sort['seat'])
                    ->orderBy('price', 'DESC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            }
        }
        if ($sort['locations'] != "locations" && $sort['seat'] != "seat" && $sort['price'] != "price") {
            if ($sort['price'] == "1") {
                $results = Cars::with('render')
                    ->join('locations', 'locat_id', '=',  'locations.id')
                    ->where('locat_id', '=', $sort['locations'])
                    ->where('seat', '=', $sort['seat'])
                    ->orderBy('price', 'ASC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            } else {
                $results = Cars::with('render')
                    ->join('locations', 'locat_id', '=',  'locations.id')
                    ->where('locat_id', '=', $sort['locations'])
                    ->where('seat', '=', $sort['seat'])
                    ->orderBy('price', 'DESC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            }
        }
        //Sort four where
        if ($sort['render'] != "render" && $sort['locations'] != "locations" && $sort['seat'] != "seat" && $sort['price'] != "price") {
            if ($sort['price'] == "1") {
                $results = Cars::with('render')
                    ->join('reders', 'red_id', '=',  'reders.id')
                    ->join('locations', 'locat_id', '=',  'locations.id')
                    ->where('red_id', '=', $sort['render'])
                    ->where('locat_id', '=', $sort['locations'])
                    ->where('seat', '=', $sort['seat'])
                    ->orderBy('price', 'ASC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            } else {
                $results = Cars::with('render')
                    ->join('reders', 'red_id', '=',  'reders.id')
                    ->join('locations', 'locat_id', '=',  'locations.id')
                    ->where('red_id', '=', $sort['render'])
                    ->where('locat_id', '=', $sort['locations'])
                    ->where('seat', '=', $sort['seat'])
                    ->orderBy('price', 'DESC')
                    ->paginate(6)
                    ->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
            }
        } else if ($sort['render'] == "render" && $sort['locations'] == "locations" && $sort['seat'] == "seat" && $sort['price'] == "price") {
            $results = Cars::with('render')->paginate(6)->appends(['render' => $request->render, 'seat' => $request->seat, 'locations' => $request->locations, 'price' => $request->price]);
        }
        $locations = Locations::all();
        $seats = DB::table('cars')->distinct()->get('seat');
        $renders = Reders::all();
        return response()->json($results, 200);
    }
    // Tìm kiếm xe để thuê xe theo địa chỉ và thời gian: 
    public function getAPILotionCars(Request $request)
    {
        $request->validate([
            'start_date' => 'required|after:yesterday',
            'end_date' => 'required|after:start_date'
        ]);

        $start_date = date('Y-m-d', $request->start_date = strtotime($request->start_date));
        $end_date = date('Y-m-d', $request->end_date = strtotime($request->end_date));

        $cars = Cars::with('render')->where('city', 'like', '%' . $request->address . '%')
            ->where('start_date', '<=', $start_date)
            ->where('end_date', '>=', $end_date)
            ->paginate(6);

        return response()->json($cars, 200);
    }
    // Chương trình giới thiệu bạn bè:
    public function getAPIInvite()
    {
        $refect = User::all();
        return response()->json($refect, 200);
    }
    //Danh sách mã khuyến mãi danh cho mỗi khách hàng :: cần đăng nhập:
    public function getAPICoupny($id)
    {

        $carsale = DB::table('car_sales')->where('user_id', $id)->paginate(3);

        return response()->json($carsale, 200);
    }
    // Tìm kiếm mã khuyến mãi
    public function getAPISearchCoupon(Request $request)
    {

        $tukhoa = $request->get('keyword');
        $carsale = CarSales::where('zipcode',  'LIKE', "%$tukhoa%")->take(30)->paginate(3)->appends(['tukhoa' => $tukhoa]);
        return response()->json($carsale, 200);
    }
    // Thêm xe vào danh sách yêu thích:
    public function getAPIAddWishlist(Request $request)
    {
        $wishList = new Wishlists;
        $wishList->user_id = $request->user_id;   //Auth::user()->id
        $wishList->car_id = $request->car_id;
        $wishList->save();
        return response()->json($wishList, 200);
    }
    // Xóa xe trong danh sách yêu thích:
    public function getAPIRemoveWishList($carID)
    {
        //echo  $id;
        DB::table('wishlists')->where('car_id', '=', $carID)->delete();
        return response()->json("Delete product in wishlist success", 200);
    }
    // Hiển thị danh sách yêu thích của khách hàng : 
    public function getAPIShowWishList($id)
    {

        $cars = Wishlists::with('render')
            ->leftJoin('cars', 'wishlists.car_id', '=', 'cars.id')
            ->join('users', 'users.id', '=', 'wishlists.user_id')
            ->selectRaw('users.id as id_user, users.name as name_user, cars.*, wishlists.id as id_wishlist')
            ->where('wishlists.user_id', $id) //Auth::user()->id
            ->orderBy('id', 'DESC')->paginate(6);

        // dd($cars);
        return response()->json($cars, 200);
    }
    //Trang đổi password cua user
    public function getAPIChangeUserPassword($id)
    {
        $profile = DB::table('users')->where('id', $id)->get();
        return response()->json($profile, 200);
    }
    // Lưu lại mật khẩu : 
    public function changPasswordStore(Request $request)
    {
        $current_password = DB::table('users')->where('id', $request->user_id)->first();
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        $pw = $request->current_password;
        if (password_verify($pw, $current_password->password)) {
            User::find($request->user_id)->update(['password' => bcrypt($request->new_password)]);
            return response()->json('Change password success', 200);
        } else {
            return response()->json('Current Password Wrong', 400);
        }
    }
    //Danh sách xe :khách hàng : 
    public function getAPICars()
    {
        $cars = Cars::with('render')->paginate(6);
        return response()->json($cars, 200);
    }
    // Khu vực : 
    public function getAPILocation()
    {
        $locations = Locations::all();
        return response()->json($locations, 200);
    }
    // Liệt kê xe theo khu vực :
    public function getAPILocationID($id)
    {
        $cars = Cars::where('locat_id', $id)->paginate(6);
        return response()->json($cars, 200);
    }
    // Quận , huyện liên kết với khu vực:
    public function getAPIDistrict()
    {
        $districts = DB::table('districts')->join(
            'locations',
            'locations.id',
            '=',
            'districts.locat_id'
        )
            ->join(
                'cars',
                'cars.id',
                '=',
                'districts.car_id'
            )->get();
        return response()->json($districts, 200);
    }

    // hãng xe : 
    public function getAPIRenders()
    {
        $renders = Reders::all();
        return response()->json($renders, 200);
    }
    // Số chỗ ngồi của xe : 
    public function getAPISeats()
    {
        $seats = DB::table('cars')->distinct()->get('seat');
        return response()->json($seats, 200);
    }
    // Hiển thị banner: 
    public function getAPIBanners()
    {
        $banner = Banners::where('status', 'on')->first();
        return response()->json($banner, 200);
    }
    // Hiển thị xe tự lái :
    public function getAPIDriving()
    {
        $drivingCar = Cars::where('book_status', 1)->where('status', 'active')->orderBy('id', 'DESC')->get();
        return response()->json($drivingCar, 200);
    }
    // Hiển thị xe có tài xế :
    public function getAPIDrive()
    {
        $driverCar = Cars::where('book_status', 2)->where('status', 'active')->orderBy('id', 'DESC')->get();
        return response()->json($driverCar, 200);
    }
    // Chi tiết xe:
    public function getAPICarsID($id)
    {
        $cars = Cars::where('id', $id)->first();
        return response()->json($cars, 200);
    }
    // Hiển thị bảng giá khi hiển thị chi tiết :
    public function getAPITableCars($id)
    {
        $costdate = Costdate::where('car_id', $id)->first();
        return response()->json($costdate, 200);
    }
    // Hiển thị đánh giá :
    public function getAPIReview()
    {
        $car_reviews = Reviews::getAllReview();
        return response()->json($car_reviews, 200);
    }
    // Booking : 
    public function getAPIBooking()
    {
        $booking = Bookings::with('cars');
        return response()->json($booking, 200);
    }
    // Booking theo id:
    public static function getAPIBookings($id)
    {
        $cars = Cars::where('id', $id)->first();
        return response()->json($cars, 200);
    }
    // Lấy mã khuyến mãi cho phương thức thuê xe : 
    public function getAPICouponBooking($id)
    {
        $zipcode = CarSales::where('user_id', $id)->get();
        return response()->json($zipcode, 200);
    }
    // profile :
    public function getAPIProfile($id)
    {
        $user = User::where('id', $id)->first();
        return response()->json($user, 200);
    }

    // Form login : //chưa được
    public function getAPIFormLoginSubmit(Request $request)
    {

        $remember_token = ($request->has('remember_token')) ? true : false; // add
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'active'], $remember_token)) {
            return response()->json("Login Success", 200);
        } else {
            return response()->json([
                'message' => 'Email or Password wrong'
            ], 401);
        }
    }
    // Đăng xuất : 
    public function getAPILogout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    // API : Sign up
    public function getAPIUserSubmitOTP(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $email_active = DB::table('users')->where('email', $request->email)->first();
        if ($email_active == null) {
            $dataAll = $request->all();

            $otp = rand(0, 99999999);

            $data = [
                'otp' => $otp,
            ];
            $otpemail = new OtpEmail();
            $otpemail['email'] = $request->email;
            $otpemail['otp'] = $otp;
            $otpemail['start_time'] = date('Y-m-d H:i');
            $otpemail['end_time'] = date("Y-m-d H:i", strtotime('+5 minute', strtotime(date("Y-m-d H:i"))));
            $otpemail->save();
            Mail::send('login.sendmail', $data, function ($message) use ($dataAll) {
                $message->from('phantinh1209@gmail.com', 'Xác thực tài khoản thuê xe');
                $message->to($dataAll['email']);
                $message->subject('Thư xác thực tài khoản thuê xe');
            });
            return response()->json([
                'message' => 'Successfully Send OTP ',
                'data' => $data,
                'dataAll' => $dataAll,
            ], 201);
        } else {

            return response()->json([
                'code' => 400,
                'message' => 'Email already exist',
                'data' => [],
                'dataAll' => [],
            ], 400);
        }
    }
    // API : Xử lý submit register đăng ký tài khoản thành công
    public function getAPIUserRegisterSubmit(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data = $request->all();

        $otp = [
            'otp' => $request->otpRegister,
        ];
        // Mã giới thiệu
        $code = strtoupper(substr(md5(time()), 0, 8));
        $otpemail = DB::table('otp_email')->where('email', $request->email)->orderByDesc('id')->first();
        if (isset($otpemail)) {
            if (strtotime($otpemail->end_time) >= strtotime(date('Y-m-d H:i'))) {
                if ($request->otp == $otpemail->otp) {

                    $data['name'] = $request->name;
                    $data['email'] = $request->email;
                    $data['password'] = bcrypt($request->password);
                    $data['otp'] = $request->otp;
                    $data['country_code'] = $code;
                    $data['referral_code'] = $request->referral_code;

                    $status = User::create($data);

                    if ($status) {
                        return response()->json([
                            'message' => 'Successfully registered!Please confrfirm your email!',
                            'status' => $status
                        ], 201);
                    }
                } else {
                    return response()->json([
                        'error' => 'Wrong OTP',
                        'data' => $otp,
                        'dataAll' => $data,
                    ], 201);
                }
            } else {
                OtpEmail::where('email', $request->email)->delete();
                return response()->json([
                    'code' => 400,
                    'message' => 'OTP expired',
                ], 400);
            }
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Please re-enter email and get otp',
            ], 400);
        }
    }
}
