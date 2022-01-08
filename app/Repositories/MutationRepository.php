<?php

namespace App\Repositories;

use App\Models\Mutation;
use Illuminate\Http\Request;
use App\Http\Criterias\SearchCriteria;
use App\Http\Presenters\DataPresenter;
use App\Http\Resources\MutationResource;

class MutationRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(Mutation::class);
	}

	public function index($request)
	{
		try {
			$this->query = $this->getModel();
			$this->applyCriteria(new SearchCriteria($request));
			$presenter = new DataPresenter(MutationResource::class, $request);

			return $presenter
				->preparePager()
				->renderCollection($this->query);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		}
	}

	public function show($id, Request $request)
	{
		$this->query = $this->getModel()->where(['id' => $id]);
		$presenter = new DataPresenter(MutationResource::class, $request);

		return $presenter->render($this->query);
	}

	public function transfer($request)
	{
		try {
			$payload = $request->all();
			$objectDana = \App\Models\Dana::whereHas('user', function($q)use($payload){
				$q->where('phone', $payload['to_phone']);
			})->firstOrFail();
			$subjectDana = \App\Models\Dana::where('user_id', \Auth::user()->id)->firstOrFail();
			$payload['from_dana_id'] = $subjectDana->id;
			$payload['to_dana_id'] = $objectDana->id;
			$mutation = $this->getModel()->create($payload);	
			
			$objectDana->amount += $mutation->amount;
			$objectDana->save();

			$subjectDana->amount -= $mutation->amount;
			$subjectDana->save();

			
			return $this->show($mutation->id, $request);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		}
	}
}
