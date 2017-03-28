<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CRPG - Traveling the world the Catenian way">
    <meta name="keywords" content="C,R,P,G">
    <meta name="author" content="Thomas van den Bulk">
    <meta name="theme-color" content="#444444">

    <title>CRPG - Catenian Roleplay</title>
    <link href='//fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body>
    @include('parts.navigation')
    <div id="wrapper">
        <div id="page-content-wrapper">
            <main class="container">
                <div class="row">
                    <div class="col-xs-12 content">
                        @yield("content")
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('scripts/script.js') }}"></script>
</body>
</html>