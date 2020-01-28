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
    
    </p>
</div>

<div>
<h2>16 Set an Active Menu Link</h2>
    <p>
    
    </p>
</div>


<div>
<h2>17 Asset Compilation with Laravel Mix and webpack</h2>
    <p>
    
    </p>
</div>

<div>
<h2>18 Render Dynamic Data</h2>
    <p>
    
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
