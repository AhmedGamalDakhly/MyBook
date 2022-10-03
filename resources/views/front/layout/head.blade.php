<!-- head contain all required meta data and linkes used throughout the whole website -->
<head>
    <title>Facebook Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Ahmed Gamal Dakhly" />
    <meta name="keywords" content="facebook , social ,login,post, posts, sign up, contact , share, website" />
    <meta name="description" content=" login page for facebook social website,you can post content , share content , contact others" />
    <link rel="icon" href="common/img/facebook.png" type="image/icon type">
    <link rel="stylesheet" href="front/css/bootstrap.min.css"/>
    <script src="front/js/jquery.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{asset('front/css')}}/all.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
          integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="{{asset('front/css')}}{{$layout}}/global.css"/>
    <link rel="stylesheet" href="{{asset('front/css')}}{{$layout}}/header.css"/>
    <link rel="stylesheet" href="{{asset('front/css')}}{{$layout}}/post.css"/>
    @include('front.layout.broadcast_channel')
    @yield('css_links')
</head>
<!---------------------------------------------------------------------------------------------->

