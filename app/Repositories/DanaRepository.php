<?php

namespace App\Repositories;

use App\Models\Dana;
use App\Http\Criterias\SearchCriteria;
use App\Http\Presenters\DataPresenter;

class DanaRepository extends BaseRepository
{
    public function __construct() 
    {
        parent::__construct(Dana::class);
    }

    public function getByAuthId($request)
	{
		try{
			$this->query = $this->getModel()->where('user_id', \Auth::user()->id);
            
			$this->applyCriteria(new SearchCriteria($request));
            $presenter = new DataPresenter(\App\Http\Resources\DanaResource::class, $request);

            return $presenter->render($this->query);
		}catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		}
	}
}
