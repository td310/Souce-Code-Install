<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Enums\PostStatus;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\DataTables\PostDataTable;

class PostController extends Controller
{
    use AuthorizesRequests;
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(PostDataTable $dataTable)
    {
        return $dataTable->render('post.index');
    }

    public function news()
    {
        $post = Post::where('status', PostStatus::APPROVE)->latest()->get();
        return view('post.news', compact('post'));
    }

    public function newsDetail(Post $post)
    {
        return view('post.news_detail', compact('post'));
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(PostRequest $request)
    {
        return $this->postService->createPost($request->validated())
            ? to_route('post.index')->with('success', 'Tạo bài viết thành công')
            : to_route('post.index')->with('error', 'Tạo bài viết thất bại');
    }

    public function show(Post $post)
    {
        $this->authorize('update', $post);
        return view('post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('post.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        return $this->postService->updatePost($post, $request->validated())
            ? to_route('post.index')->with('success', 'Cập nhật bài viết thành công')
            : back()->with('error', 'Cập nhật bài viết thất bại');
    }

    public function destroy(Post $post)
    {
        return $this->postService->deletePost($post)
            ? to_route('post.index')->with('success', 'Xoá bài viết thành công')
            : to_route('post.index')->with('error', 'Xoá bài viết thất bại');
    }

    public function deleteAll()
    {
        return $this->postService->deleteAllPosts()
            ? to_route('post.index')->with('success', 'Xoá tất cả bài viết thành công')
            : to_route('post.index')->with('error', 'Xoá tất cả bài viết thất bại');
    }
}
