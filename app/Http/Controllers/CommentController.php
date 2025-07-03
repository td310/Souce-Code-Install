<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use HTMLPurifier;
use HTMLPurifier_Config;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('xss.index', compact('comments'));
    }

    public function store(Request $request)
    {
        // Cách 1
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,br,strong,em,a[href]');
        $config->set('HTML.ForbiddenAttributes', ['on*']); 
        $config->set('URI.DisableExternalResources', true); 
        $config->set('URI.AllowedSchemes', ['http', 'https']); 
        $purifier = new HTMLPurifier($config);
        $cleanContent = $purifier->purify($request->content);

        //Cách 2
        // $safeContent = strip_tags($request->content, '<p><b><i><u><strong><em><br>');

        Comment::create([
            'content' => $cleanContent,
        ]);

        return redirect('/comments');
    }
}