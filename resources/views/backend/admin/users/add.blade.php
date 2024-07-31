<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <!-- <form action="{{ url()->current() }}" method="POST" enctype="multipart/form-data"> -->
        <form action="{{ route('add-user.store'); }}" method="POST" enctype="multipart/form-data">
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
                        {{-- <div class="col-md-full mb-2">
                            <label class="form-label" for="">Address</label>
                            <textarea class="form-control" name="address" required value="{{ old('address') }}">
                            </textarea>
                        </div> --}}

                        <div class="col-md-full mb-2">
                            <label class="form-label" for="house_address">House Address</label>
                            <input type="text" class="form-control" name="house_address" value="{{ old('house_address') }}" />
                        </div>
                        <div class="col-md-full mb-2">
                            <label class="form-label" for="street_address">Street Address</label>
                            <input type="text" class="form-control" name="street_address" value="{{ old('street_address') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="landmark">Landmark</label>
                            <input type="text" class="form-control" name="landmark" value="{{ old('landmark') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="city">City</label>
                            <input type="text" class="form-control" name="city" value="{{ old('city') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="state">State</label>
                            <input type="text" class="form-control" name="state" value="{{ old('state') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="country">Country</label>
                            <input type="text" class="form-control" name="country" value="{{ old('country') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="pincode">Pincode</label>
                            <input type="text" class="form-control" name="pincode" value="{{ old('pincode') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="default_address">Default Address</label>
                            <select class="form-control" name="default_address">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
        
                        <div class="col-md-12">
                            <button type="submit" class="btn web-btn mt-3" id="submit_btn">
                                Register User
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>