<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DanaController extends Controller
{
    protected $repository;

    public function __construct(\App\Repositories\DanaRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct(\App\Models\Dana::class);
    }

    public function getByAuthId(Request $request)
    {
        return $this->repository->getByAuthId($request);
    }
}
