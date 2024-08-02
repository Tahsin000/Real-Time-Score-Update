<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

<body>
    @yield('content')
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/pusher.min.js')}}"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    @yield('script')
</body>
</html>