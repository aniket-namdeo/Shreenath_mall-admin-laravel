<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <!-- <form action="{{ url()->current() }}" method="POST" enctype="multipart/form-data"> -->
        <form action="{{ route('add-deliveryUser.store'); }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Full Name</label>
                            <input type="text" class="form-control" name="name" onkeypress="return /[A-Za-z ]/i.test(event.key)" required value="{{ old('name') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Email</label>
                            <input type="email" class="form-control" name="email" required value="{{ old('email') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Mobile</label>
                            <input type="text" class="form-control" name="contact" onkeypress="return /[0-9]/i.test(event.key)" minlength="10" maxlength="10" pattern="[6-9]{1}[0-9]{9}" required value="{{ old('contact') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Password</label>
                            <input type="text" class="form-control" name="password" required value="{{ old('password') }}" />
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="dob">Dob</label>
                            <input type="date" class="form-control" name="dob" value="{{ old('dob') }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="gender">Gender</label>
                            <input type="text" class="form-control" name="gender" value="{{ old('gender') }}" required />
                        </div>


                        <div class="col-md-full mb-2">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address') }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="city">City</label>
                            <input type="text" class="form-control" name="city" value="{{ old('city') }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="state">State</label>
                            <input type="text" class="form-control" name="state" value="{{ old('state') }}" required />
                        </div>

                    </form>
                       
                        {{-- <div class="col-md-4 mb-2">
                            <label class="form-label" for="aadhar_card">Aadhar card</label>
                            <input type="text" class="form-control" name="aadhar_card" value="{{ old('aadhar_card') }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="pan_no">Pan No</label>
                            <input type="text" class="form-control" name="pan_no" value="{{ old('pan_no') }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="vehicle_name">Vehicle name</label>
                            <input type="text" class="form-control" name="vehicle_name" value="{{ old('vehicle_name') }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="vehicle_no">Vehicle no</label>
                            <input type="text" class="form-control" name="vehicle_no" value="{{ old('vehicle_no') }}" required />
                        </div>
                     
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="vehicle_type">Vehicle Type</label>
                            <input type="text" class="form-control" name="vehicle_type" value="{{ old('vehicle_type') }}" required />
                        </div>
                     
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="vehicle_insurance">Vehicle Insurance</label>
                            <input type="text" class="form-control" name="vehicle_insurance" value="{{ old('vehicle_insurance') }}" required />
                        </div>
                     
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="registration_no">Registration no</label>
                            <input type="text" class="form-control" name="registration_no" value="{{ old('registration_no') }}" required />
                        </div>
                     
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="driving_license">Driving license</label>
                            <input type="text" class="form-control" name="driving_license" value="{{ old('driving_license') }}" required />
                        </div>
                      --}}
                        <div class="col-md-12">
                            <button type="submit" class="btn web-btn mt-3" id="submit_btn">
                                Register User
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
</div>