<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ route('deliveryUser-update.update', $deliveryUser->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Full Name</label>
                            <input type="text" class="form-control" name="name" onkeypress="return /[A-Za-z ]/i.test(event.key)" required value="{{ old('name', $deliveryUser->name) }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Email</label>
                            <input type="email" class="form-control" name="email" required value="{{ old('email', $deliveryUser->email) }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Mobile</label>
                            <input type="text" class="form-control" name="contact" onkeypress="return /[0-9]/i.test(event.key)" minlength="10" maxlength="10" pattern="[6-9]{1}[0-9]{9}" required value="{{ old('contact', $deliveryUser->contact) }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Password</label>
                            <input type="text" class="form-control" name="password" value="{{ old('password') }}" placeholder="" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="dob">Dob</label>
                            <input type="date" class="form-control" name="dob" value="{{ old('dob', $deliveryUser->dob) }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="gender">Gender</label>
                            <input type="text" class="form-control" name="gender" value="{{ old('gender', $deliveryUser->gender) }}" required />
                        </div>

                        <div class="col-md-full mb-2">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address', $deliveryUser->address) }}" required />
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="state">State</label>
                            <input type="text" class="form-control" name="state" value="{{ old('state', $deliveryUser->state) }}" required />
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="city">City</label>
                            <input type="text" class="form-control" name="city" value="{{ old('city', $deliveryUser->city) }}" required />
                        </div>

                        {{-- <div class="col-md-4 mb-2">
                            <label class="form-label" for="">State</label>
                            <select class="form-control js-example-basic-single" name="state" id="state" >
                                <option value="" selected disabled> </option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">City</label>
                            <select class="form-control js-example-basic-single" name="city" id="city" >
                                <option value="" selected disabled> </option>
                            </select>
                        </div> --}}
                        

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="vehicle_name">Vehicle name</label>
                            <input type="text" class="form-control" name="vehicle_name" value="{{ old('vehicle_name', $deliveryUser->vehicle_name) }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="vehicle_no">Vehicle no</label>
                            <input type="text" class="form-control" name="vehicle_no" value="{{ old('vehicle_no', $deliveryUser->vehicle_no) }}" required />
                        </div>
                     
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="vehicle_type">Vehicle Type</label>
                            <input type="text" class="form-control" name="vehicle_type" value="{{ old('vehicle_type', $deliveryUser->vehicle_type) }}" required />
                        </div>
                     
                        <div class="col-md-12">
                            <button type="submit" class="btn web-btn mt-3" id="submit_btn">
                                Update User
                            </button>
                        </div>
                    </div>   
         
                </div>
            </div>
        </form>
        
        <form action="{{ route('deliveryUser-doc-update.update', $deliveryUser->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="aadhar_card">Aadhar card</label>
                            <input type="text" class="form-control" name="aadhar_card" value="{{ old('aadhar_card', $deliveryUser->aadhar_card) }}" required />
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="aadhar_doc">Aadhar</label>
                            <input type="file" class="form-control" id="aadhar_doc" name="aadhar_doc">
                        </div>
                        <div class="col-md-4 mb-2">
                            @if ($deliveryUser->aadhar_doc)
                            <img src="{{ "http://localhost:8000/".$deliveryUser->aadhar_doc }}" alt="{{ $deliveryUser->aadhar_doc }}" class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="pan_no">Pan No</label>
                            <input type="text" class="form-control" name="pan_no" value="{{ old('pan_no', $deliveryUser->pan_no) }}" required />
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="pan_doc">Pan</label>
                            <input type="file" class="form-control" id="pan_doc" name="pan_doc">
                        </div>
                        <div class="col-md-4 mb-2">
                            @if ($deliveryUser->pan_doc)
                            <img src="{{ "https://shreenathmall.smed.site/".$deliveryUser->pan_doc }}" alt="{{ $deliveryUser->pan_doc }}" class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>
                      
                     
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="registration_no">Registration no</label>
                            <input type="text" class="form-control" name="registration_no" value="{{ old('registration_no', $deliveryUser->registration_no) }}" required />
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="registration_doc">Registration</label>
                            <input type="file" class="form-control" id="registration_doc" name="registration_doc">
                        </div>
                        <div class="col-md-4 mb-2">
                            @if ($deliveryUser->registration_doc)
                            <img src="{{ "https://shreenathmall.smed.site/".$deliveryUser->registration_doc }}" alt="{{ $deliveryUser->registration_doc }}" class="img-thumbnail mt-2" width="100">
                        @endif
                        </div>
                     
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="driving_license">Driving license</label>
                            <input type="text" class="form-control" name="driving_license" value="{{ old('driving_license', $deliveryUser->driving_license) }}" required />
                        </div>

                       
                        <div class="col-md-4 mb-2">
                            <label for="license_doc">Driving license</label>
                            <input type="file" class="form-control" id="license_doc" name="license_doc">
                        </div>
                        <div class="col-md-4 mb-2">
                            @if ($deliveryUser->license_doc)
                            <img src="{{ "https://shreenathmall.smed.site/".$deliveryUser->license_doc }}" alt="{{ $deliveryUser->license_doc }}" class="img-thumbnail mt-2" width="100">
                        @endif
                        </div>
                        
                        
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="vehicle_insurance">Vehicle Insurance</label>
                            <input type="text" class="form-control" name="vehicle_insurance" value="{{ old('vehicle_insurance', $deliveryUser->vehicle_insurance) }}" required />
                        </div>
                        
                        <div class="col-md-4 mb-2">
                            <label for="insurance_doc">Vechicle Insurance</label>
                            <input type="file" class="form-control" id="insurance_doc" name="insurance_doc">
                        </div>
                        <div class="col-md-4 mb-2">
                            @if ($deliveryUser->image_url1)
                            <img src="{{ "https://shreenathmall.smed.site/".$deliveryUser->image_url1 }}" alt="{{ $deliveryUser->image_url1 }}" class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="pending" {{ old('status', $deliveryUser->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="verified" {{ old('status', $deliveryUser->status) == 'verified' ? 'selected' : '' }}>Verified</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12">
                            <button type="submit" class="btn web-btn mt-3" id="submit_btn">
                                Update docs
                            </button>
                        </div>
                     
                    </div>   
         
                </div>
            </div>
        </form>
                    
         
    </div>
</div>

<script>
    $('#country').change(function() {
        var country_id = $(this).val();
        $.ajax({
            url: "{{ url('state') }}/" + country_id,
            method: "GET",
            success: function(result) {
                data = "<option value='' selected disabled >Select State</option>";
                result.forEach(function(result, index) {
                    data += "<option value='" + result.state_id + "'>" + result.name + "</option>";
                });
                $('#state').html(data);
            },
        });
    });

    $('#state').change(function() {
        var state_id = $(this).val();
        $.ajax({
            url: "{{ url('city') }}/" + state_id,
            method: "GET",
            success: function(result) {
                data = "<option value='' selected disabled >Select City</option>";
                result.forEach(function(result, index) {
                    data += "<option value='" + result.city_id + "'>" + result.name + "</option>";
                });
                $('#city').html(data);
            }
        });
    });
</script>