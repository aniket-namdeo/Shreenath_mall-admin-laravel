
@include('backend.layouts.head')

    <section class="login-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3">
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <div class="logo-div mb-4 mb-xs-20">
                        <img src="{{ asset('includes-backend/images/logo.png'); }}" alt="">
                    </div>
                    <form method="POST" action="{{ route('login.user') }}" autocomplete="off" >
                        @csrf
                    <div class="card h-auto">
                        <div class="upper-div d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <h6>Welcome Back Admin!</h6>
                                <p>Sign in to continue to Shree nath mall</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <label for="email">{{ __('Email Address') }}</label>
    
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <label for="password">{{ __('Password') }}</label>
    
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                {{-- <div class="form-check">
                                    <input type="checkbox" id="check" class="form-check-input"> <label
                                        class="form-check-label" for="check">Remember Me</label>
                                </div> --}}
                            </div>
                            <button type="submit" class="btn web-btn w-100">
                                Log In
                            </button>
                        </div>
                    </div>
                    </form>
                    <div class="mt-4 mt-xs-20 text-center">
                        <div class="copyright-div">
                            <p class="mb-0">{{ date('Y'); }} © SecondMedic, Designed with ❤️ by SecondMedic</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('backend.layouts.js')