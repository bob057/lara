@extends('layout')

@section ('content')

<h1>Database Access</h1>


<div>
<h2>09 Setup a Database Connection</h2>
    <p>
    In the .env file database settings are stored. /config/database.php uses the keys from .env<br>
    DB_DATABASE=laravel will set the database to laravel or any database name that is chosen.<br>
    Manually setting up the database:<br>
    <ul>
    <li> Login as root: 
    <pre>   mysql -u root</pre>
    </li>
    <li> Create database:
    <pre>   create database laravel;</pre>
    </li>
    </ul>
    A GUI can also be used to work with the database. There are several applications:
    <ul>
    <li>TablePlus</li>
    <li>Sequel Pro (Mac)</li>
    <li>Querious</li>
    <li>HeidiSQL</li>
    </ul>

    Next a posts table is created with an id, slug (URI) and body. Manually create a row within the table.<br>

    In the controller the array that was used for data storage will be commented out in order to use the database instead.<br>

    The variable $post in the function declaration will be changed to $slug to make it more comprehensive.<br>

    In the show function of PostsController.php the connection to the database is made like this:
        <pre>
        $post = \DB::table('posts')->where('slug', $slug)->first();
        </pre>
    From the DB class: select from the posts table where the slug column is equal to what was fetched from the URI and give the first result.<br>    

    Inspecting a variable can be done by using dd (Dump and die)
        <pre>
        dd($post);
        </pre>

    Run "php artisan serve" after changing the .env file. If not, you might get this error:
        <pre>
        SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost' (using password: NO) (SQL: select * from `posts` where `slug` = my-first-post limit 1)
        </pre>
    
    Displaying the output of $post in post.blade.php will not work now, because it's an object now and not a string. We will use the body of the post object.<br>
        <pre>
        {{ $escapedPostBody }}
        </pre>
   
    </p>
</div>

<div>
<h2>10 Hello Eloquent</h2>
<p>
If there is an invalid URI the "Trying to get property 'body' of non-object" error will be shown. This is because there is no existing body property of that URI.<br>
In the controller this can be fixed several ways. This is the first option (in PostsController.php):

<pre>
        if (!post) {
            abort(404);
        }
</pre>

From global namespace root the DB class is called. The \ can be removed if DB is imported at the top.<br>
<pre>
        use DB;
        $post = DB::table('posts')->where('slug', $slug)->first();
</pre>


A cleaner way to use the API is using an eloquent model using the command line.
<pre>
        php artisan make:model Post
</pre>
This will generate /app/Post.php. This can be used to store business logic.<br>
In the PostsController.php import the model:
<pre>
        use App\Post;
</pre>

In PostsController.php the query can be performed like this now:
<pre>
        $post = Post::where('slug', $slug)->first();
</pre>

Next the error handling will be cleaned up by using firstOrFail() instead of first(). The if statement with the abort(404) in the body can be removed.

<pre>
        $post = Post::where('slug', $slug)->firstOrFail();
</pre>
The last step in this section is making the variable inline. It will look like this:

<pre>
        return view('post', [
            'post' => Post::where('slug', $slug)->firstOrFail()
        ]);
</pre>

</p>
</div>


<div>
<h2>11 Migrations 101</h2>
<p>
Start by deleting the posts table made in the previous section in order to start from scratch. Go to the command line and make a migration:
<pre>
        php artisan make:migration create_posts_table        
</pre>
The new class can be found in /database/migrations/. Migrations are like a version controllers, defining a structure of the table.
The up() function contains the forward actions. The down() function contains rollback actions. In the up() functions the slug and the body 
will be added to the table. Also a timestamp is added here, which is optional. The nullable() function makes this variable optional.

<pre>
        public function up()
            {
                Schema::create('posts', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->string('slug');
                    $table->text('body');
                    $table->timestamps();
                    $table->timestamp('published_at')->nullable();
                });
            }
</pre>

The migration can be runned like this in the command line:
<pre>
        php artisan migrate
</pre>

You can see the posts table is generated now. Next step is adding columns. This can be done in multiple ways.
Adding a title using a new migration
<pre>
        php artisan make:migration add_title_to_posts_table
</pre>

In add_title_to_posts_table.php the column is added is up() and dropped in down()
<pre>
        public function up()
            {
                Schema::table('posts', function (Blueprint $table) {
                    $table->string('title');
                });
            }

            public function down()
            {
                Schema::table('posts', function (Blueprint $table) {
                    $table->dropColumn('title');
                });
            }
</pre>
This is the way to go after the code is pushed to production. 
In an earlier stage this does not make sense. When the code is not in production, it is better to refactor it.
The next step is removing the insertion of the title column and add it to the create_posts_table.php.

The down() functions will be called when a rollback is performed:
<pre>
        php artisan migrate:rollback
</pre>
Be careful while being in production. All data will be lost when a rollback is performed! Another way to drop everything and
 get a fresh start is doing a doing a fresh migration. It will drop all tables and regenerate them.

<pre>
        php artisan migrate:fresh
</pre>

</p>
</div>


<div>
<h2>12 Generate Multiple Files in a Single Command</h2>
<p>
A model can be made easily by adding parameters to the make:model command. Check the list of options by executing this command:
<pre>
        php artisan help make:model
</pre>

Now we make a new model with a migration and a controller:
<pre>
        php artisan make:model newProject -mc
</pre>

Files generated:
<ul>
<li>/app/newProject.php</li>
<li>/app/Http/Controllers/NewProjectController.php</li>
<li>/database/create_new_projects_table.php</li>
</ul>

</p>
</div>


<div>
<h2>13 Business Logic</h2>
<p>
Start making a new model called Assignments:
<pre>
        php artisan make:model Assignments -mc
</pre>

Imagine some manager wants to make something. Add columns for the database to make it look like this:

3:13 : 0:47




</p>
</div>

@endsection
