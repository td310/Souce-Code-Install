<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUserCreateRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use Illuminate\Http\Request;
use App\Services\AdminUserService;
use App\Models\User;

class AdminUserController extends Controller
{
    protected $adminUserService;

    public function __construct(AdminUserService $adminUserService)
    {
        $this->adminUserService = $adminUserService;
    }

    public function data(Request $request)
    {
        return response()->json($this->adminUserService->getAdminUserData($request));
    }

    public function index()
    {
        return view('admin.admin_user.index');
    }

    public function create()
    {
        return view('admin.admin_user.create');
    }

    public function store(AdminUserCreateRequest $request)
    {
        return $this->adminUserService->adminCreateUser($request->validated())
            ? to_route('admin.user.index')->with('success', 'Tạo người dùng thành công.')
            : to_route('admin.user.index')->with('error', 'Tạo người dùng thất bại.');
    }

    public function show(User $user)
    {
        return view('admin.admin_user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.admin_user.edit', compact('user'));
    }

    public function update(AdminUserUpdateRequest $request, User $user)
    {
        return $this->adminUserService->adminUpdateUser($user, $request->validated())
            ? to_route('admin.user.index')->with('success', 'Cập nhật người dùng thành công.')
            : to_route('admin.user.index')->with('error', 'Cập nhật người dùng thất bại.');
    }

    public function destroy(User $user)
    {
        //
    }

    public function statusUser(User $user)
    {
        return response()->json($this->adminUserService->toggleLock($user));
    }
}
