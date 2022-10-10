<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->create($request->all());

        return response()->json(200);
    }

    public function show($id)
    {
        $user = $this->userService->getById($id);

        return response()->json([
            'user' => $user
        ], 200);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $this->userService->update($id, $request->all());

        return response()->json(200);
    }

    public function destroy($id)
    {
        $this->userService->delete($id);
    }
}
