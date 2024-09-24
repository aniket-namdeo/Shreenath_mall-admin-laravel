<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ url('admin/contractor-cashier'); }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 mb-2">
                            <label class="form-label" for="">Full Name</label>
                            <input type="text" class="form-control" name="name" onkeypress="return /[A-Za-z ]/i.test(event.key)" required value="{{ old('name') }}" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label" for="">Email</label>
                            <input type="email" class="form-control" name="email" required value="{{ old('email') }}" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label" for="">Mobile</label>
                            <input type="text" class="form-control" name="contact" onkeypress="return /[0-9]/i.test(event.key)" minlength="10" maxlength="10" pattern="[6-9]{1}[0-9]{9}" required value="{{ old('contact') }}" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label" for="">Password</label>
                            <input type="text" class="form-control" name="password" required value="{{ old('password') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="user_type">User Type</label>
                            <select class="form-control js-example-basic-single" name="user_type">
                                <option value="" selected disabled> -- -- </option>
                                <option value="contractor">Contractor</option>
                                <option value="cashier">Cashier</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="commission_type">Commission Type</label>
                            <select class="form-control js-example-basic-single" name="commission_type">
                                <option value="" selected disabled> -- -- </option>
                                <option value="percentage">Percentage</option>
                                <option value="amount">Amount</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Commission</label>
                            <input type="text" class="form-control" name="commission" required value="{{ old('commission') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Aadhar Card</label>
                            <input type="text" class="form-control" name="aadhar_card" value="{{ old('aadhar_card') }}" />
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="blog_title">Aadhar Card Image</label>
                            <input type="file" name="aadhar_image" class="form-control" onchange="readURL(this,'aadhar');"  />
                        </div>
                        <div class="col-md-2 mb-3">
							<img alt="Blog Image" src="{{ asset('uploads/default.jpg');  }}" class="img-responsive rounded" width="100" height="auto" id="img_preview_aadhar" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Pan Card</label>
                            <input type="text" class="form-control" name="pancard" value="{{ old('pancard') }}" />
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="blog_title">Pan Card Image</label>
                            <input type="file" name="pan_image" class="form-control" onchange="readURL(this,'pan');"  />
                        </div>
                        <div class="col-md-2 mb-3">
							<img alt="Blog Image" src="{{ asset('uploads/default.jpg');  }}" class="img-responsive rounded" width="100" height="auto" id="img_preview_pan" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label" for="">Account Number</label>
                            <input type="text" class="form-control" name="account_number" onkeypress="return /[0-9]/i.test(event.key)" value="{{ old('account_number') }}" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label" for="">Bank IFSC</label>
                            <input type="text" class="form-control" name="bank_ifsc" value="{{ old('bank_ifsc') }}" onkeypress="return /[a-zA-Z0-9]/i.test(event.key)" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label" for="">Account Type</label>
                            <input type="text" class="form-control" name="account_type" value="{{ old('account_type') }}" />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label" for="">Bank Name</label>
                            <input type="text" class="form-control" name="bank_name" value="{{ old('bank_name') }}" />
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