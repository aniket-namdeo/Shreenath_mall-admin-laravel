<div id="wrapper" class="toggled">
    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
        <button type="button" class="hamburger is-closed d-none d-sm-block" data-toggle="offcanvas">
            <i class="fa fa-angle-double-left"></i>
        </button>

        <ul class="nav sidebar-nav">
            <li class="sidebar-brand d-none d-md-block">
                <a href="{{ url('admin/dashboard') }}">
                    <span><img src="{{ asset('includes-backend/images/logo.webp') }}" alt=""></span>
                </a>
            </li>
            <li class="mb-2 {{ $current_page == 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}">
                    <font><i class="bx bxs-dashboard"></i> <span>Dashboard</span></font>
                </a>
            </li>
            {{-- <li class="mb-2 dropdown {{ $current_page == 'users' ? 'active' : '' }} {{ $current_page == 'users-list' ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <font><i class="bx bxs-user-plus"></i> <span>Manage Users</span></font>
                    <span class="bx bx-chevron-right"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="{{ $current_page == 'users' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-user') }}">Add User</a></li>
                    <li class="{{ $current_page == 'users-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/users-list') }}">Users List</a></li>
                </ul>
            </li> --}}
            <li class="mb-2 dropdown {{ $current_page == 'add-plan' ? 'active' : '' }} {{ $current_page == 'plan-list' ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <font><i class="bx bxs-user-plus"></i> <span>Manage Categories</span></font>
                    <span class="bx bx-chevron-right"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="{{ $current_page == 'add-category' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-category') }}">Add Category</a></li>
                    <li class="{{ $current_page == 'category-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/category-list') }}">Category List</a></li>
                </ul>
            </li>
            <li class="mb-2 dropdown {{ $current_page == 'add-product' ? 'active' : '' }} {{ $current_page == 'product-list' ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <font><i class="bx bxs-user-plus"></i> <span>Manage Product</span></font>
                    <span class="bx bx-chevron-right"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="{{ $current_page == 'add-product' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-product') }}">Add Product</a></li>
                    <li class="{{ $current_page == 'product-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/product-list') }}">Product List</a></li>
                </ul>
            </li>
            <li class="mb-2 dropdown {{ $current_page == 'order-list' ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <font><i class="bx bxs-user-plus"></i> <span>Manage Orders</span></font>
                    <span class="bx bx-chevron-right"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="{{ $current_page == 'order-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/order-list') }}">List</a></li>
                </ul>
            </li>
            {{-- <li class="mb-2 dropdown {{ $current_page == 'add-testimonial' ? 'active' : '' }} {{ $current_page == 'testimonial-list' ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <font><i class="bx bxs-user-plus"></i> <span>Manage Testimonial</span></font>
                    <span class="bx bx-chevron-right"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="{{ $current_page == 'add-testimonial' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-testimonial') }}">Add </a></li>
                    <li class="{{ $current_page == 'testimonial-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/testimonial-list') }}">List</a></li>
                </ul>
            </li> --}}
            {{-- <li class="mb-2 dropdown {{ $current_page == 'add-home_video' ? 'active' : '' }} {{ $current_page == 'home_video-list' ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <font><i class="bx bxs-user-plus"></i> <span>Manage Home Video</span></font>
                    <span class="bx bx-chevron-right"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="{{ $current_page == 'add-home_video' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-home_video') }}">Add </a></li>
                    <li class="{{ $current_page == 'home_video-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/home_video-list') }}">List</a></li>
                </ul>
            </li> --}}
            {{-- <li class="mb-2 dropdown {{ $current_page == 'add-services' ? 'active' : '' }} {{ $current_page == 'services-list' ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <font><i class="bx bxs-user-plus"></i> <span>Manage Services</span></font>
                    <span class="bx bx-chevron-right"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="{{ $current_page == 'add-services' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-services') }}">Add </a></li>
                    <li class="{{ $current_page == 'services-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/services-list') }}">List</a></li>
                </ul>
            </li> --}}

            {{-- <li class="mb-2 dropdown {{ $current_page == 'add-benifits' ? 'active' : '' }} {{ $current_page == 'benifits-list' ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <font><i class="bx bxs-user-plus"></i> <span>Manage Benifits</span></font>
                    <span class="bx bx-chevron-right"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="{{ $current_page == 'add-benifits' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-benifits') }}">Add </a></li>
                    <li class="{{ $current_page == 'benifits-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/benifits-list') }}">List</a></li>
                </ul>
            </li> --}}
            {{-- <li class="mb-2 dropdown {{ $current_page == 'add-terms&condition' ? 'active' : '' }} {{ $current_page == 'terms&condition-list' ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <font><i class="bx bxs-user-plus"></i> <span>Manage Terms&condition</span></font>
                    <span class="bx bx-chevron-right"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="{{ $current_page == 'add-terms&condition' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/add-terms&condition') }}">Add </a></li>
                    <li class="{{ $current_page == 'terms&condition-list' ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('/admin/terms&condition-list') }}">List</a></li>
                </ul>
            </li> --}}
{{-- 
            <li class="mb-2 {{ $current_page == 'support' ? 'active' : '' }}">
                <a href="{{ url('admin/support') }}">
                    <font><i class='bx bx-support'></i> <span>Support</span></font>
                </a>
            </li> --}}
            {{-- <li class="mb-2 {{ $current_page == 'customer-review' ? 'active' : '' }}">
                <a href="{{ url('admin/review') }}">
                    <font><i class='bx bxs-comment-detail'></i> <span>Customer Review</span></font>
                </a>
            </li> --}}
        </ul>
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