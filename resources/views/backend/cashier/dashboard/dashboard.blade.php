
@if(session('user_type') == 'cashier')
    <div class="admin-dash">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-6">
                <div class="card card-body">
                    <div class="title text-center">
                        {{-- <h4>Qr Code</h4> --}}
                        <p>{!! $qrCode !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <div class="card card-body d-flex justify-content-center  text-center">
                    <div class="title">
                        <i class="fa fa-lock fa-3x"></i>
                        <h4>Cash Deposit OTP</h4>
                        <h1>{{ $admin_details->cash_deposit_otp }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="admin-dash">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-6">
                <div class="card card-body d-flex justify-content-center  text-center py-5">
                    <div class="title">
                        <h1>{{ $deliveryUser; }}</h1>
                        <h5>Delivery User</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif