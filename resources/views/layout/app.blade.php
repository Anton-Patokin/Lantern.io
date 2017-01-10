<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lantern.io</title>
    <!-- Styles -->
    <link rel="stylesheet" href="/css/dropzone.css">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div id="root">
        @yield('content')
        <main-footer></main-footer>
    </div>
    <script src="/js/app.js" charset="utf-8"></script>
    @yield('javascript')
    <script type="text/javascript">
    
    </script>
</body>
</html>
