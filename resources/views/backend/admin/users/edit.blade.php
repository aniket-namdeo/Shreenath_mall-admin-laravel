@empty(!$details)

@php $imgUrl = ($details->image != "" && $details->image != null) ? $details->image : "uploads/default.jpg"; @endphp


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
                            <input class="form-control" name="mobile" id="mobile" value="{{ $details->mobile }}" ></input>
                        </div>

                        {{-- <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Password</label>
                            <input type="text" class="form-control" name="password" required value="{{ $details->password }}" />
                        </div> --}}

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">User type</label>
                            <select class="form-control js-example-basic-single" name="user_type">
                                <option value="Admin" {{ (old('user_type') || $details->user_type) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="User" {{ (old('user_type')  || $details->user_type) == 'User' ? 'selected' : '' }}>User
                                </option>
                            </select>
                        </div>

                        <div class="col-md-full mb-2">
                            <label class="form-label" for="">Address</label>
                            <textarea class="form-control" name="address" required >{{ $details->address }}
                            </textarea>
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