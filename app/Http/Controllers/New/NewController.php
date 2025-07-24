<?php

namespace App\Http\Controllers\New;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\New\NewService;
use App\Models\Post;

class NewController extends Controller
{
    protected $newService;

    public function __construct(NewService $newService)
    {
        $this->newService = $newService;
    }

    public function news(Request $request)
    {
        $posts = $this->newService->getPublishedPosts();
    
        if ($request->ajax()) {
            return view('new.partial.new_list', compact('posts'))->render(); 
        }
    
        return view('new.news', compact('posts')); 
    }
    
    public function newsDetail(Post $post)
    {
        $post->load(['comments.user', 'likes']);
        return view('new.news_detail', compact('post'));
    }
}
