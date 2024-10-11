
  
  <section data-bs-version="5.1" class="header15 cid-uqPOQ1X61j" id="header15-3">
	<div class="container">
		<div class="row justify-content-center">
			<div class="card col-12 col-lg-12">
				<div class="card-wrapper wrap">
					<div class="card-box align-center">
						<h1 class="card-title mbr-fonts-style mb-4 display-1"><strong>Login</strong></h1>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section data-bs-version="5.1" class="form03 cid-uqPOAUrpHJ" id="form03-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg item-wrapper">
                <div class="mbr-section-head mb-5">
                    <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
                        <strong>Login</strong></h3>
                    
                </div>
                <div class="col-lg-12 mx-auto mbr-form" data-form-type="formoid">
                <form action="{{ route('logindata') }}" method="POST" class="mbr-form form-with-styler" data-form-title="Form Name">
                @csrf
                        <input type="hidden" name="email" data-form-email="true" value="bOsVsbi32UylSLpO3FvdkXRMzFFqplgtiqfr+AtKlc04ImHUqn+daZwt+qBWblTeTbLZLWeXYb/fgX/MUKwzv9nk+zJf/kNGMNIoqKiCE9MXkCwQ+ZZz0RH4kgqmxSAJ">
                        <div class="row">
                            <div hidden="hidden" data-form-alert="" class="alert alert-success col-12">Thanks for filling out the form!</div>
                            <div hidden="hidden" data-form-alert-danger="" class="alert alert-danger col-12">
                                Oops...! some problem!
                            </div>
                        </div>
                        <div class="dragArea row">
                            
                            <div class="col-md col-sm-12 form-group mb-3 mb-3" data-for="email">
                                <input type="email" name="email" placeholder="E-mail" data-form-field="email" class="form-control" value="{{old('email')}}" id="email-form03-2">
                            </div>
                            <div class="col-12 form-group mb-3 mb-3" data-for="password">
                                <input type="password" name="password" placeholder="password" data-form-field="password" class="form-control" value="{{old('password')}}" id="password-form03-2">
                            </div>
                            
                            <div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
                                <button type="submit" class="btn btn-primary display-7">
                                    Submit</button></div>
                        </div>
                    </form>
                </div>


            </div>
            <div class="col-12 col-lg-6">
                <div class="image-wrapper">
                    <img class="w-100" src="{{asset('includes-frontend//images/mbr-1256x942.webp')}}" alt="Shrinath Mall Login">
                </div>
            </div>

        </div>
    </div>
</section><section class="display-7" style="padding: 0;align-items: center;justify-content: center;flex-wrap: wrap;    align-content: center;display: flex;position: relative;height: 4rem;"><a href="https://mobiri.se/336110" style="flex: 1 1;height: 4rem;position: absolute;width: 100%;z-index: 1;">
    <img alt="" style="height: 4rem;" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="></a><p style="margin: 0;text-align: center;" class="display-7">&#8204;</p><a style="z-index:1" href="https://mobirise.com/builder/ai-website-maker.html">Free AI Website Maker</a></section><script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/ytplayer/index.js"></script>  <script src="assets/theme/js/script.js"></script>  <script src="assets/formoid/formoid.min.js"></script>  
  
  
</body>
</html>