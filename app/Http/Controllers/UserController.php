<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct(\App\Models\User::class);
    }

    public function register(RegisterRequest $request)
    {
        return $this->repository->register($request);
    }

    public function login(LoginRequest $request)
    {
        return $this->repository->login($request);
    }
}
