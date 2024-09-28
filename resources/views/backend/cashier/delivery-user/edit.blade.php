<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ url('cashier/cashier-delivery-user/'.$deliveryUser->id); }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Full Name</label>
                            <input type="text" class="form-control" name="name" onkeypress="return /[A-Za-z ]/i.test(event.key)" required value="{{ $deliveryUser->name; }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Email</label>
                            <input type="email" class="form-control" name="email" required value="{{ $deliveryUser->email; }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Mobile</label>
                            <input type="text" class="form-control" name="contact" onkeypress="return /[0-9]/i.test(event.key)" minlength="10" maxlength="10" pattern="[6-9]{1}[0-9]{9}" required value="{{ $deliveryUser->contact; }}" />
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Password</label>
                            <input type="text" class="form-control" name="password" />
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="dob">Dob</label>
                            <input type="date" class="form-control" name="dob" value="{{ $deliveryUser->dob; }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="gender">Gender</label>
                            <select class="form-control js-example-basic-single" name="gender">
                                <option value="" selected disabled> -- -- </option>
                                <option value="Male" {{ ($deliveryUser->gender == 'Male') ? 'selected' : '' }} >Male</option>
                                <option value="Female" {{ ($deliveryUser->gender == 'Female') ? 'selected' : '' }} >Female</option>
                                <option value="Other" {{ ($deliveryUser->gender == 'Other') ? 'selected' : '' }} >Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ $deliveryUser->address; }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="city">City</label>
                            <input type="text" class="form-control" name="city" value="{{ $deliveryUser->city; }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="state">State</label>
                            <input type="text" class="form-control" name="state" value="{{ $deliveryUser->state; }}" required />
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="vehicle_name">Vehicle name</label>
                            <input type="text" class="form-control" name="vehicle_name" value="{{ $deliveryUser->vehicle_name; }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="vehicle_no">Vehicle no</label>
                            <input type="text" class="form-control" name="vehicle_no" value="{{ $deliveryUser->vehicle_no; }}" required />
                        </div>
                     
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="vehicle_type">Vehicle Type</label>
                            <input type="text" class="form-control" name="vehicle_type" value="{{ $deliveryUser->vehicle_type; }}" required />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="incentive_type">Incentive Type</label>
                            <select class="form-control js-example-basic-single" name="incentive_type" required>
                                <option value="" selected disabled> -- -- </option>
                                <option value="percentage" {{ ($deliveryUser->incentive_type == 'percentage') ? 'selected' : '' }} >Percentage</option>
                                <option value="fixed" {{ ($deliveryUser->incentive_type == 'fixed') ? 'selected' : '' }} >Fixed</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="incentive">Incentive</label>
                            <input type="text" class="form-control" name="incentive" value="{{ $deliveryUser->incentive; }}" required />
                        </div>

                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn web-btn mt-3">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>