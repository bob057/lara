<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Post;

class PostsController extends Controller
{
    public function show($slug)
    {
        /*$posts = [
            'my-first-post' => 'first post, csdiojcosdi diojcdiocjiosd jicosjcsd odkospvsvdsi',
            'my-second-post' => 'second post, ckoskcoapbcuhua nisjciaosc nioascj vmwopvmpowmv'
        ];
        
        $post = DB::table('posts')->where('slug', $slug)->first();
    
        dd($post);

        if (! array_key_exists($post, $posts)) {
            abort(404, 'Sorry, that post was not found');
        }
        
        return view('post', [
            'post' => $posts[$post]
        ]);
        */
        
        return view('post', [
            'post' => Post::where('slug', $slug)->firstOrFail()
            
        ]);
    }
}
