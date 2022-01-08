<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Http\Criterias\SearchCriteria;
use App\Http\Presenters\DataPresenter;
use App\Http\Resources\WalletResource;

class WalletRepository extends BaseRepository
{
    public function __construct() 
    {
        parent::__construct(Wallet::class);
    }

    public function getWallet()
	{
		try{
			$this->query = $this->getModel()->get();
			return response()->json([
				'success' => true,
				'data' => $this->query,
			], 200);

		}catch (\Exception $e) {
			 response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		}
	}

	public function index($request)
	{
		try {
			$this->query = $this->getModel();
			$this->applyCriteria(new SearchCriteria($request));
			$presenter = new DataPresenter(WalletResource::class, $request);
		
			return $presenter
			  ->preparePager()
			  ->renderCollection($this->query);
		}catch (\Exception $e) {
			response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		}
	}

	public function show($id, $request)
	{
		$this->query = $this->getModel()->where('id', $id);
		
		$this->applyCriteria(new SearchCriteria($request));
		$presenter = new DataPresenter(WalletResource::class, $request);

		return $presenter->render($this->query); 
	}
	public function store($request)
	{
		try{
			$payload = $request->all();
			$wallet = $this->getModel()->create($payload);

			return $this->show($wallet->id, $request);
		}catch (\Exception $e) {
			response()->json([
			   'success' => false,
			   'message' => $e->getMessage()
		   ], 400);
	   }
	}

	public function update($id, $request)
	{
		try{
			$payload = $request->all();
			$wallet = $this->getModel()->findOrFail($id)->update($payload);

			return $this->show($wallet->id, $request);
		}catch (\Exception $e) {
			response()->json([
			   'success' => false,
			   'message' => $e->getMessage()
		   ], 400);
	   }
		
	}

	public function destroy($id)
	{
		try{
			$wallet = $this->getModel()->findOrFail($id)->delete();

			return response()->json([
				'success' => true,
				'message' => 'data already deleted'
			], 200);
		}catch (\Exception $e) {
			response()->json([
			   'success' => false,
			   'message' => $e->getMessage()
		   ], 400);
	   }
	}
}
