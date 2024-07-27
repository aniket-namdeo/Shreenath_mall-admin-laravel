@include('backend.layouts.head')

@include('backend.layouts.header')

@include('backend.admin.' . $page_name)

@include('backend.layouts.footer')

@include('backend.layouts.js')
