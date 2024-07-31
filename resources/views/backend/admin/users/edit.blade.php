@empty(!$details)

{{-- @php $imgUrl = ($details->image != "" && $details->image != null) ? $details->image : "uploads/default.jpg"; @endphp --}}


<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ route('users-update.update', $details->id); }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Full name</label>
                            <input type="text" class="form-control" name="name" onkeypress="return /[A-Za-z ]/i.test(event.key)" required value="{{ $details->name }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Email</label>
                            <input type="price" class="form-control" name="email" required value="{{ $details->email }}" />
                        </div>
                       
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Mobile</label>
                            <input class="form-control" name="contact" id="contact" value="{{ $details->contact }}" ></input>
                        </div>

                        {{-- <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Password</label>
                            <input type="text" class="form-control" name="password" required value="{{ $details->password }}" />
                        </div> --}}


                        <div id="addresses-container">
                            @foreach($detailAddress as $address)
                                <div class="address-fields">
                                    <div class="row">
                                        <div class="col-md-full mb-2">
                                            <label class="form-label" for="house_address">House Address</label>
                                            <input type="text" class="form-control" name="house_address[]" required value="{{ $address->house_address }}" />
                                        </div>
                                        <div class="col-md-full mb-2">
                                            <label class="form-label" for="street_address">Street Address</label>
                                            <input type="text" class="form-control" name="street_address[]" required value="{{ $address->street_address }}" />
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label" for="landmark">Landmark</label>
                                            <input type="text" class="form-control" name="landmark[]" value="{{ $address->landmark }}" />
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label" for="city">City</label>
                                            <input type="text" class="form-control" name="city[]" required value="{{ $address->city }}" />
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label" for="state">State</label>
                                            <input type="text" class="form-control" name="state[]" required value="{{ $address->state }}" />
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label" for="country">Country</label>
                                            <input type="text" class="form-control" name="country[]" required value="{{ $address->country }}" />
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label" for="pincode">Pincode</label>
                                            <input type="text" class="form-control" name="pincode[]" required value="{{ $address->pincode }}" />
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label" for="default_address">Default Address</label>
                                            <select class="form-control" name="default_address[]">
                                                <option value="0" {{ $address->default_address == 0 ? 'selected' : '' }}>No</option>
                                                <option value="1" {{ $address->default_address == 1 ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn web-btn mt-3" id="submit_btn">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endempty