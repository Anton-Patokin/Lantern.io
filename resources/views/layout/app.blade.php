<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lantern.io</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" media="screen" title="no title">
    <link rel="stylesheet" href="/css/tooltipster.bundle.min.css">
    <link rel="stylesheet" href="/css/tooltipster-sideTip-borderless.min.css">
    <link rel="stylesheet" href="/css/dropzone.css">
    <link rel="stylesheet" href="/css/app.css">
    <script>
        window.Laravel =
            <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
    </script>

</head>
<body>
    <div id="root">
        @yield('content')

    </div>
    <script src="/js/app.js" charset="utf-8"></script>
    @yield('javascript')
    <script>
        
    </script>
</body>
</html>
