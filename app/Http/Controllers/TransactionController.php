<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $repository;

    public function __construct(\App\Repositories\TransactionRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct(\App\Models\Transaction::class);
    }

    public function getByAuthId(Request $request)
    {
        return $this->repository->getByAuthId($request);
    }
    
    public function topUp(\App\Http\Requests\TransactionRequest $request)
    {
        return $this->repository->topUp($request);
    }

    public function withDraw(\App\Http\Requests\TransactionRequest $request)
    {
        return $this->repository->withDraw($request);
    }
}
