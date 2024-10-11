<section data-bs-version="5.1" class="menu menu2 cid-uqPLl36Mni" once="menu" id="menu02-4">
	
	<nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
		<div class="container">
			<div class="navbar-brand">
				<span class="navbar-logo">
					<a href="https://shrinathmall.com">
						<img src="includes-frontend/images/shrinath-removebg-preview-192x80.webp" alt="Shrinath Mall" style="height: 4.3rem;">
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
				<div class="navbar-buttons mbr-section-btn"><a class="btn btn-primary display-4" href="#">Get App</a></div>
			</div>
		</div>
	</nav>
</section>

<section data-bs-version="5.1" class="form1 cid-uqPRp3LWeo mbr-fullscreen mbr-parallax-background" id="form1-a">

    

    
    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(255, 255, 255);"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 mx-auto mbr-form" data-form-type="formoid">
            <form id="delete-account-form"  action="{{ route('account-delete',['id' => $user->id]) }}" method="POST" 
            class="mbr-form form-with-styler" data-form-title="Form Name"  >
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
                            <p class="mbr-text mbr-fonts-style mb-5 align-center display-7">You can delete your account from this page.</p>
                        </div>
                     
                        <div class="mbr-section-btn">
                        <button type="button" class="btn btn-danger display-4" onclick="confirmDelete()">Delete My Account</button>

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
                    <a href="{{ url('/'); }}" class="text-white">Home</a>
                  </li><li class="header-menu-item mbr-fonts-style display-5">Login</li></ul>
              </div>

            
            <div class="col-12 mt-4">
                <p class="mbr-fonts-style copyright display-7">© 2024 Shrinath Mall. All rights reserved.</p>
            </div>
        </div>
    </div>
</section>
  
