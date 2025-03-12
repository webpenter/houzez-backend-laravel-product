<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\UsersResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Retrieve all users from the database.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing all users.
     */
    public function getAllUsers(): JsonResponse
    {
        $users = User::all();
        return new JsonResponse(UsersResource::collection($users));
    }
}
