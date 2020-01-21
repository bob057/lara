<?php

namespace App\Http\Controllers;

class PostsController
{
    public function show($post)
    {
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
    }
}