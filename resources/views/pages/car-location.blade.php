@extends('layouts.app')
@section('content')

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row mt-4">

            <div class="col-md-12" style="margin-bottom: 80px;">
                <div class="row no-gutters">
                    <div class="col-md-4 d-flex align-items-center">
                        <form action="{{route('sort')}}" class="request-form ftco-animate bg-primary"
                            style="border-radius: 0px !important;">
                            @csrf
                            <h2 style="border-radius: 0px !important;">The car you need</h2>
                            <div class="form-group mt-4">
                                <select class="form-control" name="render" id="exampleFormControlSelect1">
                                    <option value="render">Renders</option>
                                    @if(isset($renders))
                                    @foreach($renders as $render)
                                    <option value="{{$render->id}}">{{$render->manu_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group mt-4">
                                <select class="form-control" name="seat" id="exampleFormControlSelect1">
                                    <option value="seat">Seat</option>
                                    @if(isset($seats))
                                    @foreach($seats as $car)
                                    <option value="{{$car->seat}}">{{$car->seat}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group mt-4">
                                <select class="form-control" name="locations" id="exampleFormControlSelect1">
                                    <option value="locations">Locations</option>
                                    @if(isset($locations))
                                    @foreach($locations as $location)
                                    <option value="{{$location->id}}">{{$location->locat_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group mt-4">
                                <select class="form-control" name="price" id="exampleFormControlSelect1">
                                    <option value="price">Price</option>
                                    <option value="1">Increase</option>
                                    <option value="0">Decrease</option>
                                </select>
                            </div>
                            <div class="form-group" style="margin-bottom: -10px;">
                                <input type="submit" value="Find A Car Now" class="btn btn-secondary py-3 px-4">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8 d-flex">
                        <div class="services-wrap rounded-right w-100"
                            style="background: url(../../public/ui/images/bg_2.jpg) no-repeat center;">
                            <h3 class="heading-section mb-4 text-white">Better Way to Rent Your Perfect Cars</h3>
                            <!-- <p><a href="#" class="btn btn-primary py-3 px-4">Reserve Your Perfect Car</a></p> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- list cars -->
            @foreach($cars as $car)
            @if(isset($car))
            @php
            $photo=explode('/',$car->photo);
            @endphp
            <div class="col-md-4">
                <div class="car-wrap rounded ftco-animate">
                    <div class="img rounded d-flex align-items-end"
                        style="background-image: url('../../public/backend/uploads/images/cars/<?= $photo[0]?>');">
                    </div>
                    <div class="text">
                        <h2 class="mb-0"><a href="{{route('car.detail',$car->id)}}">{{$car->name}}</a></h2>
                        <div class="d-flex mb-3">
                            <span class="cat">{{$car->render->manu_name}}</span>
                            <p class="price ml-auto"><?= number_format($car->price, 0, ',', '.' ) . " VN??"; ?><span>/day</span></p>
                        </div>
                        <!-- T??nh t???ng rate trung b??nh  -->
                        @php
                        $numberRate =DB::table('reviews')->where('car_id',$car->id)->count();
                        $sumRating = DB::table('reviews')->where('car_id',$car->id)->sum('rate');
                        $itemAge = 0;
                        if($numberRate!=0){
                        $itemAge = round($sumRating / $numberRate, 2);
                        }
                        @endphp
                        <div class="wrapper">
                            @for($i = 1; $i <= 5; $i ++) <i class="ion-ios-star {{ $i <= $itemAge ? 'active' : ''}}">
                                </i>
                                @endfor

                        </div>
                        <!-- S??? chuy???n ??i -->
                        @php
                        $icheck = false;

                        $count = DB::table('bookings')->where('status' , 'active')->where('car_id' , $car->id)->count();
                        @endphp

                        
                        <span class="add-wapper">

                            <?=str_pad($count, 2, '0', STR_PAD_LEFT); ?> trip

                        </span>
                       
                        <!-- ?????a ch??? -->
                        @php
                        $boolbs = false;
                        $districts = DB::table('districts')->join('locations', 'locations.id',
                        '=', 'districts.locat_id')
                        ->join('cars', 'cars.id',
                        '=', 'districts.car_id')->get();

                        foreach($locations as $location) {
                        $boolbs = true;
                        }
                        @endphp
                        @foreach($districts as $district)
                        @if($district->car_id == $car->id && $boolbs == true)
                        <div class="location">
                            <div class=located>
                                <i class="fa fa-map-marker" aria-hidden="true"></i> {{$district->city_address}},
                                {{$district->locat_name}}
                            </div>
                        </div>
                        @endif
                        @endforeach
                        <p class="d-flex mb-0 d-block"><a href="{{route('car.booking',$car->id)}}"
                                class="btn btn-orange py-2 mr-1">Rent
                                now</a> <a href="{{route('car.detail',$car->id)}}"
                                class="btn btn-gray py-2 ml-1">Details</a></p>
                    </div>
                </div>
            </div>

            @endif
            @endforeach

        </div>
        <div class="row mt-5">
            <div class="col text-center">
                <div class="block-27">
                    {{$cars->links()}}
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.located {
    position: relative;
    font-size: .8125rem;
    top: -12px;
    bottom: 0;
    left: 0;
    right: 0;
}

.located i {
    width: 20px;
    height: 20px;
    border: 1px solid;
    text-align: center;
    padding: 3px;
    margin-left: 1px;
    border-radius: 50px;
}

.located i:before {
    color: black;
}

/* t???ng rate */
.add-wapper {
    position: relative;
    top: -16px;
    left: 100px;
    font-size: 14px;
    bottom: 0;
    right: 0;

}

.wrapper .active {
    color: #FFC107 !important;
    position: relative;
}

.wrapper {
    position: relative;
    bottom: 15px;
    left: 0;
    right: 0;
    display: inline-block;
    border: none;
    font-size: 20px;
    padding-top: -74px;
    margin-left: -2px;
}
</style>
<!-- Footer -->
@include('partials.footer')
<script>
//X??a style:display:none; trong select;
$('.pagination').remove();
</script>
@endsection