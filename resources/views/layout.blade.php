<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Comparateur d'algo de tri">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AlgoStats</title>
        <!-- <link rel="stylesheet" href="css/style.css"> -->
        <!-- <link rel="author" href="humans.txt"> -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" 
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        @yield('head')
    </head>
    <body>
		<nav class="navbar navbar-inverse">
		  <a class="navbar-brand" href="/"><i class="fa fa-calculator" aria-hidden="true"></i> AlgoStats</a>
		  <ul class="nav navbar-nav">
		    <li class="nav-item {{ Request::segment(1) === null ? 'active' : null }}">
		      <a class="nav-link" href="/"><i class="fa fa-home" aria-hidden="true"></i> Home <span class="sr-only">(current)</span></a>
		    </li>
		    <li class="nav-item {{ Request::segment(1) === 'time' ? 'active' : null }}">
		      <a class="nav-link" href="/time"><i class="fa fa-clock-o" aria-hidden="true"></i> Time</a>
		    </li>
		    <li class="nav-item {{ Request::segment(1) === 'cost' ? 'active' : null }}">
		      <a class="nav-link" href="/cost"><i class="fa fa-eur" aria-hidden="true"></i> Cost</a>
		    </li>
		  </ul>
		</nav>

        @yield('content')

        @yield('beforeBody')
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" 
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" 
        crossorigin="anonymous"></script>
        <script src="../../js/Chart.min.js"></script>
        <script src="../../js/script.js"></script>

    </body>
</html>