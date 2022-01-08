<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function __construct(\App\Repositories\WalletRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct(\App\Models\Wallet::class);
    }

    public function getWallet()
    {
        return $this->repository->getWallet();
    }

    public function index(Request $request)
    {
        return $this->repository->index($request);
    }

    public function store(\App\Http\Requests\WalletRequest $request)
    {
        return $this->repository->store($request);
    }

    public function update($id, \App\Http\Requests\WalletRequest $request)
    {
        return $this->repository->update($id, $request);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }

}
