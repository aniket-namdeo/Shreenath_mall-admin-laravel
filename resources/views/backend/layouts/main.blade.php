@include('backend.layouts.head')

@if(!Session::has('user_id'))

    @include('backend.pages.'.$page_name)

@else

    @include('backend.layouts.header')

    @include('backend.pages.'.$page_name)

    @include('backend.layouts.footer')

@endif

@include('backend.layouts.js')