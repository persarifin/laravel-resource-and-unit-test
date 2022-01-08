<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MutationController extends Controller
{
    protected $repository;

    public function __construct(\App\Repositories\MutationRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct(\App\Models\Mutation::class);
    }

    public function index(Request $request)
    {
        return $this->repository->index($request);
    }

    public function transfer(\App\Http\Requests\MutationRequest $request)
    {
        return $this->repository->transfer($request);
    }
}
