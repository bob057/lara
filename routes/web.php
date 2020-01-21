<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pre', function () {
    return view('pre');
});

Route::get('/routing', function () {
    return view('routing', [
        'name' => "{{ \$name }}",
        'unescapedName' => "{!! \$name !!}",
        'maliciousString' => "127.0.0.1/?name=<script>alert('Hello');<script>"
    ]);
});

Route::get('/visual', function () {
    return view('visual');
});

Route::get('/database', function () {
    return view('database', [
        'escapedPostBody' => "{{ \$post=>body }}"
    ]);
});

/*
Route::get('/posts/{post}', function ($post) {
    $posts = [
        'my-first-post' => 'first post, csdiojcosdi diojcdiocjiosd jicosjcsd odkospvsvdsi',
        'my-second-post' => 'second post, ckoskcoapbcuhua nisjciaosc nioascj vmwopvmpowmv'
    ];

    if (! array_key_exists($post, $posts)) {
        abort(404, 'Sorry, that post was not found');
    }

    return view('post', [
        'post' => $posts[$post]
    ]);
    
});
*/

Route::get('/posts/{post}', 'PostsController@show');

Route::get('/test', function () {
    $name = request('name');
    return view('test', [
        'name' => $name
    ]);
    
});

