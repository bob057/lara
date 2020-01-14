@extends('layout')

@section ('content')


<h1>Prerequisites</h1>

<div>
<h2>01 At a Glance</h2>
    <p>
    What happens when a request comes in? A laravel app is loaded and notices it's a request for the homepage. Any URI can be processed. A controller is loaded.
    It receives a request and provides a response. This can happen in multiple ways. An eloqent model can be used for this.
    It will provide domain knowledge and business logic. Next a view is generated (xxx.blade.php) View receives data from the controller and renders it to the user.
    </p>
 <a href="https://laracasts.com/series/laravel-6-from-scratch/episodes/1">link to video</a>
</div>

<div>
<h2>02 Install PHP, MySQL and Composer</h2>
    <p>
    Check if php version >7.2 is installed<br>
    php -v (in your CLI)<br>
    XAMPP can be used to run a web server and database. Visual Studio Code can be used as a text editor.<br>
    Dependency manager "composer" must be installed to install laravel. <a href="https://getcomposer.org">link</a><br>
    </p>
</div>

<div>
<h2>03 The Laravel Installer</h2>
    <p>
    These commands are used setting up a laravel workspace:<br>
    composer global require laravel/installer  (install laravel)<br>
    laravel new projectName (initiate new project)<br>
    ECHO %PATH% (check path variable)<br>
    php artisan serve (starts server at 127.0.0.1:8000)
    </p>
</div>


<div>
<h2>04 Laravel Valet Setup</h2>
    <p>
    Mac specific, so can be skipped
    </p>
</div>

@endsection
