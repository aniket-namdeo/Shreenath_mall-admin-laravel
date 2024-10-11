
  
  <!-- <title>Account</title>
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="assets/parallax/jarallax.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/socicon/css/styles.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto+Flex:wght@400;700&display=swap&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Flex:wght@400;700&display=swap&display=swap"></noscript>
  <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css?v=kYhlUg"><link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css?v=kYhlUg" type="text/css"> -->

  
  <section data-bs-version="5.1" class="menu menu2 cid-uqPLl36Mni" once="menu" id="menu02-4">
	

	<nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
		<div class="container">
			<div class="navbar-brand">
				<span class="navbar-logo">
					<a href="https://shrinathmall.com">
						<img src="assets/images/shrinath-removebg-preview-192x80.webp" alt="Shrinath Mall" style="height: 4.3rem;">
					</a>
				</span>
				
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse" data-target="#navbarSupportedContent" data-bs-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<div class="hamburger">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				
				
				<div class="navbar-buttons mbr-section-btn"><a class="btn btn-primary display-4" href="https://mobiri.se">Get App</a></div>
			</div>
		</div>
	</nav>
</section>

<section data-bs-version="5.1" class="form1 cid-uqPRp3LWeo mbr-fullscreen mbr-parallax-background" id="form1-a">

    

    
    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(255, 255, 255);"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 mx-auto mbr-form" data-form-type="formoid">
            <form action="{{ route('account-delete',['id' => $user->id]) }}" method="POST" 
            class="mbr-form form-with-styler" data-form-title="Form Name"  onsubmit="return confirmDelete();">
@csrf
                    <div class="row">
                        <div hidden="hidden" data-form-alert="" class="alert alert-success col-12">Thanks for filling out the form!</div>
                        <div hidden="hidden" data-form-alert-danger="" class="alert alert-danger col-12">
                            Oops...! some problem!
                        </div>
                    </div>
                    <div class="dragArea row">
                        <div class="col-12">
                            <h1 class="mbr-section-title mb-4 mbr-fonts-style align-center display-2">
                                <strong>Welcome</strong></h1>
                        </div>
                        <div class="col-12">
                            <p class="mbr-text mbr-fonts-style mb-5 align-center display-7">Please download our app to avail our services. <br>You can delete your account from this page.</p>
                        </div>
                     
                        <div class="mbr-section-btn col-12 col-md-auto">
                            <button type="submit" class="btn btn-danger display-4">Delete My Account</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section data-bs-version="5.1" class="footer3 cid-uqPLl3jG0a" once="footers" id="footer03-5">

        

    

    <div class="container">
        <div class="row">
            <div class="row-links">
                <ul class="header-menu">
                  
                  
                  
                  
                <li class="header-menu-item mbr-fonts-style display-5">
                    <a href="#" class="text-white">Home</a>
                  </li><li class="header-menu-item mbr-fonts-style display-5">Login</li></ul>
              </div>

            
            <div class="col-12 mt-4">
                <p class="mbr-fonts-style copyright display-7">© 2024 Shrinath Mall. All rights reserved.</p>
            </div>
        </div>
    </div>
</section><section class="display-7" style="padding: 0;align-items: center;justify-content: center;flex-wrap: wrap;    align-content: center;display: flex;position: relative;height: 4rem;"><a href="https://mobiri.se/336110" style="flex: 1 1;height: 4rem;position: absolute;width: 100%;z-index: 1;"><img alt="" style="height: 4rem;" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="></a><p style="margin: 0;text-align: center;" class="display-7">&#8204;</p><a style="z-index:1" href="https://mobirise.com"> Website Builder Software</a></section><script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>  <script src="assets/parallax/jarallax.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/ytplayer/index.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  <script src="assets/theme/js/script.js"></script>  <script src="assets/formoid/formoid.min.js"></script>  
  
  
</body>
</html>