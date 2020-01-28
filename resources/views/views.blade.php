@extends ('layout')

@section ('content')


<h1>Views</h1>

<div>
<h2>14 Layout Pages</h2>
    <p>
    Using views cleans up code and avoids code duplication by reusing commonly used code. This can be a header containing style attributes and scripts.
    In the .../resources/views/ directory make a layout file (layout.blade.php). In this file a {{ $escapedYield }} is placed where the content of the 
    unique pages is inserted. This refers to the 'content' section of the page where the layout file is extended.
    </p>

    <p>  
    To use the reusable code on a page a {{ $escapedExtends }} is placed at the place where the code needs to be inserted. In case of headers and scripts this 
    can be at the top of the page. The code that is unique will be placed in a section. The section starts with {{ $escapedSection }} and 
    ends with {{ $escapedEndsection}}.
    </p>

</div>

<div>
<h2>15 Integrate a Site Template</h2>
    <p>
    For this paragraph it is preferred to use a new workspace. Download the simplework template on <a href="https://templated.co/simplework">templated.co</a> 
    and copy the content to the public folder (index.html and license.txt don't need to be copied). Copy the content of index.html 
    to .../resources/views/layout.php. In welcome.blade.php extend the layout file. Create a css folder in the public folder and move the css files to it.
    This will fail loading the background image. To fix this open default.css and look for the #header-wrapper property. Change
     images/banner.jpg to ../images.banner.jpg. Move the content of the body of layout.blade.php into a content section in welcome.blade.php.    
    </p>

    <p>
    Next we will implement the 'About us' page. Make a route (routes/web.php). Make the file (resources/views/about.blade.php). Link in the 
    welcome.blade.php to "/about". The navigation is lost now. Move the header-wrapper back to the layout file. Next remove header-featured and put a yield for a header
    at that spot. On welcome the header is gone as well. Add a section to add the header. Make sure the name of the section and the yield to it is the same.
    </p>
</div>

<div>
<h2>16 Set an Active Menu Link</h2>
    <p>
    Change the homepage link from # to /. Currently the links are hard-coded. Change it with a request helper. (Request::path())

    <pre>
    <li class="{{ Request::path() === '/' ? 'current_page_item' : '' }}"><a href="/" accesskey="1" title="">Homepage</a></li>
    </pre>
    The is() function call also be called on the Request. It accepts regular expressions.
    <pre>
    <li class="{{ Request::is('about') ? 'current_page_item' : '' }}"><a href="/about" accesskey="3" title="">About Us</a></li>
    </pre>

    </p>
</div>


<div>
<h2>17 Asset Compilation with Laravel Mix and webpack</h2>
    <p>
        There is still a duplication of code. At the end of the page there is a footer. Move this section to layout.blade.php. In welcome.blade.php the 'content'
        section can be removed. 
    </p>

    <p>
        In the /resources folder there are folders for js, lang and sass. These can be used when there is a build process involved. The files in /resources 
        are compiled into /public. These files are served to the browser.
    </p>

    <p>
        Look at webpack.mix.js. laravel-mix is a wrapper around webpack. The first argument is the entry point and the second argument is the output location.
        In /resources/sass/app.scss some code is added. 
            <pre>
                $primary: red;

                body {
                    color: $primary;
                }
            </pre>

            In webpack.mix.js:

            <pre>
                mix.sass('resources/sass/app.scss', 'public/css');
            </pre>
        
        In package.json the dependencies are defined, but they haven't been installed. On the command line run npm -v to check the verion.
        If not installed, go to nodejs.org. Install the dependencies by running npm install. They are stored in node_modules directory. Next step is compiling
        npm run dev. The output can be found in /public/css/app.css. 'npm run watch' will keep an eye on changes so you don't have to run npm dev every time.

            <pre>
            mix.js('resources/js/app.js', 'public/js')
                .sass('resources/sass/app.scss', 'public/css');
            </pre>

        Go to /resources/js/app.js and recompile by using 'npm run dev'. Make sure to remove the ; after the first line. This is not done in the video.
        Now import the script in the layout.blade.php (at the end of the body)

            <pre>
            <script src="/js.app.js"></script>
            </pre>

        Css in the header:
            <pre>
                <link rel="stylesheet" href="css/app.css" />
            </pre>

        Alternative helper function:
            <pre>
                <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
            </pre>



        <br><a href="https://laracasts.com/series/laravel-6-from-scratch/episodes/17?autoplay=true">link to video</a>
    </p>

</div>

<div>
<h2>18 Render Dynamic Data</h2>
    <p>
    Make a model with a migration:
            <pre>
                php artisan make:model Article -m
            </pre>


    Add columns to the table (database/migrations/create_articles_table.php):
            <pre>
            $table->string('title');
            $table->text('excerpt');
            $table->text('body');
            </pre>
    
            Migrate 'php artisan migrate'. Next use 'php artisan tinker' to make a new article.

            <pre>
                $article = new App\Article;
                $article->title = 'Getting to know us';
                $article->excerpt = 'Bacon ipsum dolor amet tri-tip ball tip tenderloin';
                $article->body = 'Bacon ipsum dolor amet tri-tip ball tip tenderloin, porchetta t-bone bresaola doner shankle frankfurter. 
                Kielbasa beef ribs fatback leberkas shankle. Meatloaf hamburger prosciutto pork. Capicola pork chop short ribs filet mignon frankfurter brisket venison tongue buffalo.

                Burgdoggen tri-tip brisket, kevin buffalo flank kielbasa turducken fatback beef ribs ribeye venison. Fatback shankle sausage, pastrami chislic 
                beef ribs cow pancetta. Shoulder rump ham frankfurter ribeye salami fatback jowl pork loin venison leberkas spare ribs buffalo chicken tenderloin. 
                Cow landjaeger drumstick, pancetta ball tip sausage capicola corned beef tongue kielbasa tail chicken chislic boudin ground round. 
                Turducken jowl chuck corned beef.';
                $article->save();

            </pre>
            Add two more articles.<br>
            Get back to the /routes/web.php file and get the articles. This will return ALL the articles.

            <pre>
            Route::get('/about', function () {
                $article = App\Article::all();
                return $article;
                return view('about');
            });
            </pre>

            If there is a database error, re-run 'php artisan serve'. <br>
            Instead of getting all the articles, it is also possible to take some articles:

            <pre>
                $article = App\Article::take(2)->get();
            </pre>

            Paginating is also possible:
            <pre>
                $article = App\Article::paginate(2);
            </pre>

            Latest article first (helper function to order by 'created_at)' descending
            <pre>
                $article = App\Article::latest()->get();
            </pre>
            
            Add a parameter to latest in order to sort by different attributes:
            <pre>
                $article = App\Article::latest('published')->get();
            </pre>
            
            Now refactor and use it:

            <pre>
            Route::get('/about', function () {
                
                return view('about', [
                    'articles' => App\Article::latest()->get()
                ]);
            });
            </pre>

            In the about.blade.php look for the place to put the articles. There is a list. 
            <pre>
            <ul class="style1">
                @foreach ($articles as $article)
				<li class="first">
					<h3>{{ $article->title }}</h3>
					<p><a href="#">{{ $article -> excerpt }}</a></p>
				@endforeach
            </ul>
            
            </pre>

            If an article is added, it will be shown in the sidebar. Next step is to reduce this to the three latest articles.
            In the routes/web.php file specify to take the latest 3 articles:
            <pre>
            'articles' => App\Article::take(3)->latest()->get()
            </pre>
    
    </p>
</div>

<div>
<h2>19 Render Dynamic Data: Part 2</h2>
    <p>
    
    </p>
</div>

<div>
<h2>20 Homework Solutions</h2>
    <p>
    
    </p>
</div>

@endsection
