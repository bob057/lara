@extends('layout')

@section ('content')


<h1>Routing</h1>

<div>
<h2>05 Basic Routing and Views</h2>
    <p>
    In routes/web.php the routes are defined like this:<br>
        <pre>
        Route::get('/', function () {
            return view('welcome');<
        });
        </pre>
    This will refer to the view in the /resources/views/ folder<br>
    In this case /resources/views/welcome.blade.php is loaded<br><br>

    Inside the function a string can de returned as well:<br>
    return 'Hello World';<br><br>

    And an array that will be converted to JSON:<br>
    return ['foo' => 'bar'];<br>

      
    </p>
</div>

<div>
<h2>06 Pass Request Data to Views</h2>
    <p>
    Request data is entered in the address bar: 127.0.0.1:8000/?name=tammo<br>
    This data can be fetched by the request helper function. This is what happens in the body of the route function:<br>
    $name = request('name');<br>
    'return $name' //returns tammo<br><br>
    Grabbing the value and send it to the view:<br>
    Add in bla.blade.php: '$name'<br><br>
    
    <h3>Sanitize data input:</h3>
    A user can add request data in the address bar. Always assume a user is a malicious user!<br>
    For instance: A user types the following in the address bar:<br>
        <pre>
        {{ $maliciousString }}
        </pre>
    This will execute the script the user entered in the address bar.<br>
        <pre>
        Route::get('/test', function () {
            $name = request('name');
            return view('test', [
                'name' => $name
            ]);
        });
        </pre>
        
    In order to fix this there are multiple options:<br>
    Escape traditionally in php:
        <pre>
        htmlspecialchars($name, ENT_QUOTES)
        </pre>
    However there is an option in laravel to handle this:
    
        <pre>
        {{ $name }}
        </pre>
    The blade templating engine will escape the variable.<br>
    The code will be compiled in /storage/framework/views/l0ngStr1ngW1thNum8er5.php<br><br>

    Using the following syntax will not escape.<br>
    This is in case you want to use unedited strings.
        <pre>
        {!! $unescapedName !!}
        </pre>

    

    </p>
</div>

<div>
<h2>07 Route Wildcards</h2>
<p>EPISODE 3</p>
<p>3:02</p>
<p>FREE</p>
</div>


<div>
<h2>08 Routing to Controllers</h2>
<p>EPISODE 4</p>
<p>3:18</p>
<p>FREE</p>
</div>

@endsection
