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
Start making a new model called Assignment:
<pre>
        php artisan make:model Assignment -mc
</pre>

Imagine some manager wants to make something. Add columns for the database (in database\migrations\2020_01_21_144854_create_assignments_table.php) to 
make the up() function look like this:
<pre>
        public function up()
        {
                Schema::create('assignments', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('body');
                $table->timestamp('completed_at')-> nullable();
                $table->timestamps();
                $table->timestamp('due_date')->nullable();
                });
        }
</pre>

In this case the column 'completed_at' is a timestamp, which is nullable. If the assignment is completed, the time when it was completed is saved.
A more simple way is using a boolean for this column. The downside of this approach is that the date of completion will not be saved. Use 'php artisan migrate'
to apply the changes to the database. Use 'php artisan migrate:fresh' in order to rebuild the database completely. Remember all entries will be deleted this way.<br>

The next thing is using the created model to make an example record. In the command line open 'php artisan tinker'. This is a shell in which php commands can 
be executed. Let's make a new assignment like this:

<pre>
        >>> $assignment = new App\Assignment;
</pre>

If you defined the column 'completed' as a boolean, make sure to add a default of false and migrate again by using 'php artisan migrate:rollback' and 'php artisan
migrate'.
<pre>
        $table=>boolean('completed')->default(false);
</pre>

The new assignment will need a 'body', 'completed' and 'due_date'. 'id', 'created_at' and 'updated_at' are automatically filled in.<br>

Now a body will be added to the assignment. Remember to save it as well by calling the save() function.
<pre>
        >>> $assignment->body = 'Finish school work';
        => "Finish school work"
        >>> $assignment->save();
        => true
</pre>

To see all data from the table use the following command:
<pre>
        >>> App\Assignment::all();
</pre>

To see the first entry of the table use the following command:
<pre>
        >>> App\Assignment::first();
</pre>

Query the table using the following command (when 'completed' is boolean):
<pre>
        >>> App\Assignment::where('completed', false)->get();
</pre>

Query the table using the following command (when 'completed_at' is a timestamp):
<pre>
        >>> App\Assignment::where('completed_at', NULL)->get();
</pre>

How to change the status of an assignment to completed in a way that is easily understood:<br>

To complete an assignment a complete() function would be good for this.
<pre>
        >>> $assignment->complete()
        BadMethodCallException with message 'Call to undefined method App/Assignment::complete()'
</pre>

We will have to make a complete() function in the .../app/Assignment.php model.  
<pre>
        class Assignments extends Model
        {
                public function complete()
                {
                        $this->completed_at = now();
                        $this->save();
                }
        }
</pre>
If the 'completed' variable is boolean use '$this->completed = true;'<br>
Call '$assignment = App\Assignments::first();' again to see the changes'.<br>
Wrapping multiple commands in a function will avoid code duplication.<br>


</p>
</div>

@endsection
