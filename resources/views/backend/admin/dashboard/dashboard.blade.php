<div class="admin-dash">
    <div class="row">
        {{-- <div class="col-lg-3 col-md-6 col-6">
            <div class="card card-body">
                <div class="title">
                    <h4>{{$cash_deposit->cash_deposit_otp}}</h4>
                    <p>OTP</p>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-3 col-md-6 col-6">
            <div class="card card-body">
                <div class="title">
                    <h4>Qr Code</h4>
                    <p>{!! $qrCode !!}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6">
            <div class="card card-body d-flex justify-content-center  text-center">
                <div class="title">
                    <i class="fa fa-lock fa-4x"></i>
                    <h4>Cash Deposit OTP</h4>
                    <h1>{{ $cash_deposit->cash_deposit_otp }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card statistics">
                <div class="card-body">
                    <h6 class="mb-1">Sales Statistics</h6>
                    <p class="card-p mb-1">Updated 1 month ago</p>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="box">
                                <div class="icon bg-rgb-success text-success"><i class="bx bx-bar-chart"></i>
                                </div>
                                <div class="title">
                                    <h6>230k</h6>
                                    <p>Weekly Sales</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="box">
                                <div class="icon bg-rgb-primary text-primary"><i class="bx bx-briefcase"></i>
                                </div>
                                <div class="title">
                                    <h6>100</h6>
                                    <p>New Projects</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="box">
                                <div class="icon  bg-rgb-warning text-warning"><i class="bx bx-data"></i></div>
                                <div class="title">
                                    <h6>30</h6>
                                    <p>Item Orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="box">
                                <div class="icon bg-rgb-danger text-danger"><i class="bx bx-bug"></i></div>
                                <div class="title">
                                    <h6>50</h6>
                                    <p>Bug Reports</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <img src="{{ asset('includes-backend/images/wave.png') }}" class="w-100" alt="">
            </div>
        </div>
    </div>
</div>