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
                            <input type="text" class="form-control" name="mobile" onkeypress="return /[0-9]/i.test(event.key)" minlength="10" maxlength="10" pattern="[6-9]{1}[0-9]{9}" required value="{{ old('mobile') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Password</label>
                            <input type="text" class="form-control" name="password" required value="{{ old('password') }}" />
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">User type</label>
                            <select class="form-control js-example-basic-single" name="user_type">
                                <option value="Admin" {{ old('user_type') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="User" {{ old('user_type') == 'User' ? 'selected' : '' }}>User
                                </option>
                            </select>
                        </div>

                        <div class="col-md-full mb-2">
                            <label class="form-label" for="">Address</label>
                            <textarea class="form-control" name="address" required value="{{ old('address') }}">
                            </textarea>
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