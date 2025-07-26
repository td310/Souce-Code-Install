<?php

namespace App\Http\Controllers\User;

use App\Services\User\PostService;
use App\Http\Requests\User\Post\StorePostRequest;
use App\Http\Requests\User\Post\UpdatePostRequest;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use AuthorizesRequests;
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        return view('post.index');
    }

    public function data(Request $request)
    {
        return response()->json($this->postService->getDataTableData($request->all()));
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(StorePostRequest $request)
    {
        return $this->postService->createPost($request->validated())
            ? to_route('post.index')->with('success', 'Tạo bài viết thành công')
            : to_route('post.index')->with('error', 'Tạo bài viết thất bại');
    }

    public function show(Post $post)
    {
        //$post->load('user');
        $this->authorize('userPost', $post);
        return view('post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('userPost', $post);
        return view('post.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        return $this->postService->updatePost($post, $request->validated())
            ? to_route('post.index')->with('success', 'Cập nhật bài viết thành công')
            : back()->with('error', 'Cập nhật bài viết thất bại');
    }

    public function destroy(Post $post)
    {
        $success = $this->postService->deletePost($post);
        return response()->json([
            'success' => $success,
            'redirect' => $success ? route('post.index') : null
        ]);
    }

    public function deleteAll()
    {
        $success = $this->postService->deleteAllPosts();
        return response()->json([
            'success' => $success,
            'redirect' => $success ? route('post.index') : null
        ]);
    }
}
