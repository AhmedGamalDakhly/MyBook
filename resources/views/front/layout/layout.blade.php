<!DOCTYPE html>
<html lang="en-US">
@include('front.layout.head')
<body>
@include('front.layout.header')
@yield('content')
@include('front.layout.footer')
@yield('js_links')
</body>
</html>
