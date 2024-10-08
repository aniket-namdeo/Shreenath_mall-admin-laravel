<div id="wrapper" class="toggled">
  
    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
        <button type="button" class="hamburger is-closed d-none d-sm-block" data-toggle="offcanvas">
            <i class="fa fa-angle-double-left"></i>
        </button>

        @if(session()->has('user_type'))
            <ul class="nav sidebar-nav">
                <li class="sidebar-brand d-none d-md-block">
                    <a href="{{ url('admin/dashboard') }}">
                        <span><img src="{{ asset('includes-backend/images/logo.png') }}" alt=""></span>
                    </a>
                </li>
                @if(session()->get('user_type') == 'admin')
               
                    <li class="mb-2 {{ $current_page == 'dashboard' ? 'active' : '' }}">
                        <a href="{{ url('admin/dashboard') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Dashboard</span></font>
                        </a>
                    </li>
                    <li class="mb-2 dropdown {{ ($current_page == 'users' || $current_page == 'add-user' || $current_page == 'add-delivery_user'  || $current_page == 'delivery_user') ? 'active' : '' }}">
                        <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <font><i class="bx bxs-user-plus"></i> <span>Manage Users</span></font>
                            <span class="bx bx-chevron-right"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li class="{{ ($current_page == 'add-user') ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-user') }}">Add User</a></li>
                            <li class="{{ $current_page == 'delivery-user' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-delivery-user') }}">Add Delivery User</a></li>
                            <li class="{{ $current_page == 'users-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/users-list') }}">Users List</a></li>
                            <li class="{{ $current_page == 'delivery-user-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/delivery-user-list') }}">Delivery Users List</a></li>
                        </ul>
                    </li>

                    <li class="mb-2 dropdown {{ $current_page == 'contractor-cashier' ? 'active' : '' }} {{ $current_page == 'tag-list' ? 'active' : '' }}">
                        <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <font><i class="bx bxs-dashboard"></i> <span>Man. Con. & Cas.</span></font>
                            <span class="bx bx-chevron-right"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li class="{{ $current_page == 'contractor-cashier' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/contractor-cashier/create') }}">Add </a></li>
                            <li class="{{ $current_page == 'tag-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/contractor-cashier') }}">List</a></li>
                        </ul>
                    </li>
                    
                    <li class="mb-2 dropdown {{ ($current_page == 'order-list' || $current_page == 'commissions-list') ? 'active' : '' }}">
                        <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <font><i class="bx bxs-dashboard"></i> <span>Manage Orders</span></font>
                            <span class="bx bx-chevron-right"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li class="{{ $current_page == 'order-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/order-list') }}">Order List</a></li>
                            <li class="{{ $current_page == 'commissions-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ route('commission-list.show') }}">Commission List</a></li>
                        </ul>
                    </li>
                
                    <li class="mb-2 {{ $current_page == 'contact-request' ? 'active' : '' }}">
                        <a href="{{ route('contact.request') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Contact Request</span></font>
                        </a>
                    </li>

                    <li class="mb-2 dropdown {{ ($current_page == 'add-category' || $current_page == 'category-list' || $current_page == 'add-subcategory' || $current_page == 'category') ? 'active' : '' }} {{ $current_page == 'plan-list' ? 'active' : '' }}">
                        <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <font><i class="bx bxs-dashboard"></i> <span>Manage Categories</span></font>
                            <span class="bx bx-chevron-right"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li class="{{ $current_page == 'add-category' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-category') }}">Add Category</a></li>
                            <li class="{{ $current_page == 'add-subcategory' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-subcategory') }}">Add SubCategory</a></li>
                            <li class="{{ $current_page == 'category-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/category-list') }}">Category List</a></li>
                            <li class="{{ $current_page == 'subcategory-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/subcategory-list') }}">Sub Category List</a></li>
                        </ul>
                    </li>
                    <li class="mb-2 dropdown {{ ($current_page == 'add-brand' || $current_page == 'brand-list' ) ? 'active' : '' }} {{ $current_page == 'brand-list' ? 'active' : '' }}">
                        <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <font><i class="bx bxs-dashboard"></i> <span>Manage Brand</span></font>
                            <span class="bx bx-chevron-right"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li class="{{ $current_page == 'add-brand' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-brand') }}">Add Brand</a></li>
                            <li class="{{ $current_page == 'brand-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/brand-list') }}">Brand List</a></li>
                        </ul>
                    </li>
                    <li class="mb-2 dropdown {{ $current_page == 'add-product' ? 'active' : '' }} {{ $current_page == 'product-list' ? 'active' : '' }}">
                        <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <font><i class="bx bxs-dashboard"></i> <span>Manage Product</span></font>
                            <span class="bx bx-chevron-right"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li class="{{ $current_page == 'add-product' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-product') }}">Add Product</a></li>
                            <li class="{{ $current_page == 'product-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/product-list') }}">Product List</a></li>
                        </ul>
                    </li>
                    

                    <li class="mb-2 dropdown {{ $current_page == 'add-coupon' ? 'active' : '' }} {{ $current_page == 'coupon-list' ? 'active' : '' }}">
                        <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <font><i class="bx bxs-dashboard"></i> <span>Manage Coupon</span></font>
                            <span class="bx bx-chevron-right"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li class="{{ $current_page == 'add-coupon' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-coupon') }}">Add </a></li>
                            <li class="{{ $current_page == 'coupon-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/coupon-list') }}">List</a></li>
                        </ul>
                    </li>

                    <li class="mb-2 dropdown {{ $current_page == 'offer-slider' ? 'active' : '' }} {{ $current_page == 'offer-slider-list' ? 'active' : '' }}">
                        <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <font><i class="bx bxs-dashboard"></i> <span>Manage Offer Slider</span></font>
                            <span class="bx bx-chevron-right"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li class="{{ $current_page == 'offer-slider' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/offer-slider') }}">Add </a></li>
                            <li class="{{ $current_page == 'offer-slider-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/offer-slider-list') }}">List</a></li>
                        </ul>
                    </li>
                    <li class="mb-2 dropdown {{ $current_page == 'add-tag' ? 'active' : '' }} {{ $current_page == 'tag-list' ? 'active' : '' }}">
                        <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <font><i class="bx bxs-dashboard"></i> <span>Manage Tags</span></font>
                            <span class="bx bx-chevron-right"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li class="{{ $current_page == 'add-tag' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-tag') }}">Add </a></li>
                            <li class="{{ $current_page == 'tag-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/tag-list') }}">List</a></li>
                        </ul>
                    </li>
                    
                    <li class="mb-2 {{ $current_page == 'deposit-request' ? 'active' : '' }}">
                        <a href="{{ url('admin/deposit-request') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Deposit Request</span></font>
                        </a>
                    </li>

                    <li class="mb-2 {{ $current_page == 'incentive' ? 'active' : '' }}">
                        <a href="{{ url('admin/incentive_list') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Incentive</span></font>
                        </a>
                    </li>

                    <li class="mb-2 {{ $current_page == 'referral' ? 'active' : '' }}">
                        <a href="{{ url('admin/referral_list') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Referral</span></font>
                        </a>
                    </li>

                    <li class="mb-2 {{ $current_page == 'privacypolicy' ? 'active' : '' }}">
                        <a href="{{ url('admin/edit-privacypolicy/1') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Privacy Policy</span></font>
                        </a>
                    </li>

                    <li class="mb-2 {{ $current_page == 'terms__and_condition' ? 'active' : '' }}">
                        <a href="{{ url('admin/edit-terms_and_condition/1') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Terms & Conditions</span></font>
                        </a>
                    </li>
                    
                    <li class="mb-2 {{ $current_page == 'about-us' ? 'active' : '' }}">
                        <a href="{{ url('admin/edit-aboutus/1') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Manage About Us</span></font>
                        </a>
                    </li>
                
                @elseif(session()->get('user_type') == 'cashier')
                
                    <li class="mb-2 {{ $current_page == 'dashboard' ? 'active' : '' }}">
                        <a href="{{ url('cashier/dashboard') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Dashboard</span></font>
                        </a>
                    </li>
                
                    <li class="mb-2 {{ $current_page == 'orders-list' ? 'active' : '' }}">
                        <a href="{{ url('cashier/orders-list') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Orders List</span></font>
                        </a>
                    </li>
                
                    <li class="mb-2 {{ $current_page == 'pickedup-list' ? 'active' : '' }}">
                        <a href="{{ url('cashier/pickedup-list') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Your Pick-up</span></font>
                        </a>
                    </li>
                
                    <li class="mb-2 {{ $current_page == 'cash-collect-add' ? 'active' : '' }}">
                        <a href="{{ url('cashier/cash-collect/create') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Add Cash Collect</span></font>
                        </a>
                    </li>
                
                    <li class="mb-2 {{ $current_page == 'cash-collect' ? 'active' : '' }}">
                        <a href="{{ url('cashier/cash-collect') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Cash Collected List</span></font>
                        </a>
                    </li>
                
                @elseif(session()->get('user_type') == 'contractor')
                
                    <li class="mb-2 {{ $current_page == 'dashboard' ? 'active' : '' }}">
                        <a href="{{ url('cashier/dashboard') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Dashboard</span></font>
                        </a>
                    </li>
                
                    <li class="mb-2 {{ $current_page == 'delivery-user-add' ? 'active' : '' }}">
                        <a href="{{ url('cashier/cashier-delivery-user/create') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Add Delivery User</span></font>
                        </a>
                    </li>
                
                    <li class="mb-2 {{ $current_page == 'delivery-user' ? 'active' : '' }}">
                        <a href="{{ url('cashier/cashier-delivery-user') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Delivery User</span></font>
                        </a>
                    </li>
                
                    <li class="mb-2 {{ $current_page == 'delivery-order-commission' ? 'active' : '' }}">
                        <a href="{{ url('cashier/delivery-order-commission') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>Order Commissions</span></font>
                        </a>
                    </li>
                
                    <li class="mb-2 {{ $current_page == 'our-order-commission' ? 'active' : '' }}">
                        <a href="{{ url('cashier/our-order-commission') }}">
                            <font><i class="bx bxs-dashboard"></i> <span>My Commissions</span></font>
                        </a>
                    </li>
                    
                @endif
            </ul>
            
        @endif
    </nav>



    <div class="rightside" id="page-content-wrapper">
        <header>
            <section class="header">
                <div class="row align-items-center">
                    <div class="col-sm-6 col-4">
                        <h5 class="mb-0 d-none d-md-block">{{ $page_title }}</h5>
                        <div class="d-flex align-items-center d-block d-md-none">
                            <button type="button" class="hamburger is-open" data-toggle="offcanvas">
                                <i class="fa fa-angle-double-left"></i>
                            </button>
                            <h6 class="m-0 ms-2"><a href="{{ url('admin/dashboard') }}">Admin</a></h6>
                        </div>
                    </div>
                    <div class="col-sm-6 col-8">
                        <ul class="header-nav">
                            <li>
                                <a href="javascript:;" id="darkMode" rel="{{ asset('includes-backend/css/dark-mode.css') }}"><i class="bx bx-moon"></i></a>
                                <a href="javascript:;" id="defaultMode" rel="{{ asset('includes-backend/css/default.css') }}" style="display: none;"><i class="bx bx-sun"></i></a>
                            </li>
                            <li class="dropdown user">
                                <a class="dropdown-toggle d-none d-md-flex" href="javascript:;" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div>
                                        @if(@Auth::user())
                                        <h6>{{ Auth::user()->name; }} <i class='bx bx-chevron-down'></i></h6>
                                        @else
                                        <h6>{{ Str::ucfirst(session('user_name')); }}</h6>
                                        @endif
                                        <p>{{ Str::ucfirst(session('user_type')); }}</p>
                                    </div>
                                    <img src="{{ asset('includes-backend/images/default-user.webp') }}" alt="">
                                </a>

                                <a class="dropdown-toggle d-block d-md-none" href="javascript:;" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-user"></i>
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    {{-- <li><a href="userprofile.html" class="dropdown-item"><i class="bx bx-user"></i> Profile</a></li>

                                    <li><a href="setting.html" class="dropdown-item"><i class="bx bx-cog"></i> Settings</a></li>
                                    <li class="divider"></li> --}}

                                    <li><a href="{{ url('/logout') }}" class="dropdown-item"><i class="bx bx-log-out-circle"></i> Logout</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
            </section>
        </header>