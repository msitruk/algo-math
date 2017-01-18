<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Comparateur d'algo de tri">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Algo stats</title>
        <!-- <link rel="stylesheet" href="css/style.css"> -->
        <!-- <link rel="author" href="humans.txt"> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
        @yield('head')
    </head>
    <body>
		<nav class="navbar navbar-dark bg-inverse">
		  <a class="navbar-brand" href="/">Algo-Stats</a>
		  <ul class="nav navbar-nav">
		    <li class="nav-item {{ Request::segment(1) === null ? 'active' : null }}">
		      <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
		    </li>
		    <li class="nav-item {{ Request::segment(1) === 'time' ? 'active' : null }}">
		      <a class="nav-link" href="/time">Time</a>
		    </li>
		    <li class="nav-item {{ Request::segment(1) === 'cost' ? 'active' : null }}">
		      <a class="nav-link" href="/cost">Cost</a>
		    </li>
		  </ul>
		</nav>

        @yield('content')

        @yield('beforeBody')

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
    </body>
</html>