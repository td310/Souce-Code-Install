<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\PostService;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Http\Requests\Admin\Post\UpdatePostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    protected $adminPostService;

    public function __construct(PostService $adminPostService)
    {
        $this->adminPostService = $adminPostService;
    }

    public function index()
    {
        return view('admin.admin_post.index');
    }

    public function data(Request $request)
    {
        return response()->json($this->adminPostService->getAdminPostData($request->all()));
    }

    public function create()
    {
        return view('admin.admin_post.create');
    }

    public function store(StorePostRequest $request)
    {
        return $this->adminPostService->adminCreatePost($request->validated())
        ? to_route('admin.post.index')->with('success', 'Tạo bài viết thành công')
        : to_route('admin.post.index')->with('error', 'Tạo bài viết thất bại');
    }

    public function show(Post $post)
    {
        return view('admin.admin_post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view ('admin.admin_post.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        return $this->adminPostService->adminUpdatePost($post, $request->validated())
            ? to_route('admin.post.index')->with('success', 'Cập nhật bài viết thành công')
            : to_route('admin.post.index')->with('error', 'Cập nhật bài viết thất bại');
    }

    public function destroy(Post $post)
    {
        $success = $this->adminPostService->adminDeletePost($post);
        return response()->json([
            'success' => $success,
            'redirect' => $success ? route('admin.post.index') : null
        ]);
    }

    public function adminDeleteAll()
    {
        $success = $this->adminPostService->adminDeleteAllPosts();
        return response()->json([
            'success' => $success,
            'redirect' => $success ? route('admin.post.index') : null
        ]);
    }
}
