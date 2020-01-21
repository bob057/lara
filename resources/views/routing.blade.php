@extends('layout')

@section ('content')

<h1>Routing</h1>

<div>
<h2>05 Basic Routing and Views</h2>
    <p>
    In routes/web.php the routes are defined like this:<br>
        <pre>
        Route::get('/', function () {
            return view('welcome');
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
<p>
    Constructing a route with a unique value using a wildcard requires curly brackets:
    <pre>
        Route::get('/posts/{post}', function () {
            return view('post');
        });
    </pre>
    This will refer /posts/blablabla to the post.blade.php content.<br>

    Grabbing the value of {post} is done by passing it as an argument of the function.
    <pre>
        Route::get('/posts/{post}', function ($post) {
            return $post;
        });
    </pre>
    
    The following snippet of code returns the selected entry of the $posts array.
    <pre>
        Route::get('/posts/{post}', function ($post) {
            $posts = [
                'my-first-post' => 'first post, csdiojcosdi diojcdiocjiosd jicosjcsd odkospvsvdsi',
                'my-second-post' => 'second post, ckoskcoapbcuhua nisjciaosc nioascj vmwopvmpowmv'
            ];

            return view('post', [
                'post' => $posts[$post]
            ]);
        });
    </pre>

    In post.blade.php the content of the $post variable can be shown now using the double bracket notation.<br>

    If the selected entry is not found there are several option to return feedback to the user:<br>
    <ul>
        <li>returning a default (not recommended): 
        <pre>
        'post' => $posts[$post] ?? 'Nothing here yet.'</pre>
        </li>
        <li>returning a 404 error code if the key does not exist (just before returning the view): 
        <pre>
        if (! array_key_exists($post, $posts)) {
            abort(404, 'Sorry, that post was not found');
        }
        </pre></li>
    </ul>

</p>
</div>


<div>
<h2>08 Routing to Controllers</h2>
<p>
For bigger projects controllers should be used. Here a controller is called with a method called 'show'. The route made in the previous 
paragraph can be commented out or deleted.
</p>
<pre>
        Route::get('/posts/{post}', 'PostsController@show');
</pre>

<p>
In order to make this work a controller has to be created. This is done in the App\Http\Controllers\ folder of the project. The controller will be called
PostsController.php. A namespace and a class will be added. In order to make it work a show function will be added.
</p>
<pre>
        namespace App\Http\Controllers;

        class PostsController
        {
            public function show()
            {
                return 'hello';
            }
        }
</pre>

<p>
The next step is to paste the content of the route of the previous paragraph in the post function of the controller. This will restore the original behaviour.
</p>


<p>
Another way of generating a controller is by using the command line. 
<pre>       php artisan make:controller PostsController</pre>
This generates an empty controller. Copy the show function into it to make it work again.
</p>

</div>

@endsection
