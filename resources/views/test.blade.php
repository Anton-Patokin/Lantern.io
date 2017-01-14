<!DOCTYPE html>
<html>
<head>
    <title>Real-Time Laravel with Pusher</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,200italic,300italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="http://d3dhju7igb20wy.cloudfront.net/assets/0-4-0/all-the-things.css" />

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    {{--<script>--}}
        {{--// Ensure CSRF token is sent with AJAX requests--}}
        {{--$.ajaxSetup({--}}
            {{--headers: {--}}
                {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--}--}}
        {{--});--}}

        {{--// Added Pusher logging--}}
        {{--Pusher.log = function(msg) {--}}
            {{--console.log(msg);--}}
        {{--};--}}
    {{--</script>--}}
</head>
<body>
<h1>test pisher</h1>
<script>
    var pusher = new Pusher('{{env("PUSHER_KEY")}}',{
        cluster:'eu',
        encrypted:false,
    });
    var channel = pusher.subscribe('test-channel');
    channel.bind('room', function(data) {
        console.log(data);
    });
</script>

</body>
</html>
