<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Http\Criterias\SearchCriteria;
use App\Http\Presenters\DataPresenter;
use Carbon\Carbon;
use App\Models\Dana;

class TransactionRepository extends BaseRepository
{
    public function __construct() 
    {
        parent::__construct(Transaction::class);
    }

    public function getByAuthId($request)
	{
		try{
			$this->query = $this->getModel()->where('user_id', \Auth::user()->id);
			
			$this->applyCriteria(new SearchCriteria($request));
			$presenter = new DataPresenter(\App\Http\Resources\TransactionResource::class, $request);
		
			return $presenter
			  ->preparePager()
			  ->renderCollection($this->query);
		}catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		}
	}

	public function show($id, $request)
	{
		try{
			$this->query = $this->getModel()->where('id', $id);
            
			$this->applyCriteria(new SearchCriteria($request));
            $presenter = new DataPresenter(\App\Http\Resources\TransactionResource::class, $request);

            return $presenter->render($this->query);
		}catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		} 
	}
	
	protected function store($request)
	{
		$payload = $request->all();
		$payload['date'] = Carbon::now()->toDateTimeString();
		$payload['user_id'] = \Auth::user()->id;
		$payload['dana_id'] = Dana::whereHas('user', function($q){
			$q->where('id', \Auth::user()->id);
		})->firstOrFail()->id;
		
		$transaction = $this->getModel()->create($payload);

		return $transaction;		
	}

	public function topUp($request)
	{
		try {
			$transaction = $this->store($request);
			$dana = Dana::findOrFail($transaction->dana_id);
			$dana->amount += $transaction->amount;
			$dana->save();

			return $this->show($transaction->dana_id, $request);
		}catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		}
	}

	public function withDraw($request)
	{
		try {
			$transaction = $this->store($request);
			$dana = Dana::findOrFail($transaction->dana_id);
			$dana->amount -= $transaction->amount;
			$dana->save();

			return $this->show($transaction->dana_id, $request);
		}catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		}
	}
}
