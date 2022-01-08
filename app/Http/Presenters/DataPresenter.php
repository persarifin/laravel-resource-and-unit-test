<?php

namespace App\Http\Presenters;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

class DataPresenter implements PresenterInterface
{
    protected $resource;
    protected $data;
    protected $expense;
    protected $rawResource;
    protected $included = [];
    protected $activeRelations = null;
    protected $request;
    protected $pagination = [
        'limit' => 10,
        'num' => 1,
    ];

    public function __construct(String $resource, $request)
    {
        $this->resource = $resource;
        $this->request = $request;

        $this->rawResource = new $this->resource(null);
    }
    
    public function render($query)
    {
        // \DB::enableQueryLog();
        $query = $this->parseIncludes($query);
        $data = $query->first();

        if ($data === null) {
			return response()->json([
				'success' => true,
				'message' => 'Record not found',
			], 200);
        }

        $resourceInstance = new $this->resource($data);

        foreach ($this->getActiveRelations() as $relationship) {
            $resourceInstance->addRelationship($relationship);

            $this->included[$relationship] = $resourceInstance->parseRelation($relationship);
        }

        $response = [
			'success' => true,
            'data' => $resourceInstance,
            'included' => $this->getIncluded(),
            'meta' => [
                'relations' => $this->getActiveRelations(),
                'available_relations' => $this->getAvailableRelations(),
                'links' => [
                    'self' => url()->current(),
                ]
            ],
        ];
        return $response;
    }

    public function renderCollection($query)
    {
        \DB::beginTransaction();
        try {
            $query = $this->parseIncludes($query);
            $query = $this->applyPagination($query);
			
			$baseQuery = $query->toBase();
            
			$total = $baseQuery->getCountForPagination();
            $table = $query->getModel()->getTable();
            $data = $query->orderBy($table.'.created_at', 'desc')->get();
            $count = $data->count();
            $resourceInstance = $this->resource::collection($data);
            

			foreach ($this->getActiveRelations() as $relationship) {
				foreach ($resourceInstance as $resource) {
					$resource->addRelationship($relationship);
				}
				$this->included[$relationship] = $resourceInstance->parseRelation($relationship);
			}

            DB::commit();
			return [
                'success' => $total > 0 ? true : false,
                'data' => $resourceInstance,
                'included' => $this->getIncluded(),
                'meta' => [
                    'relations' => $this->getActiveRelations(),
                    'available_relations' => $this->getAvailableRelations(),
                    'links' => [
                        'self' => url()->current(),
                    ],
                    'pagination' => [
                        'limit' => (int) $this->pagination['limit'],
                        'page' => (int) $this->pagination['num'],
                        'count' => $count,
                        'total' => $total,
                    ]
                ],
            ];
		} catch (Exception $e) {
			DB::rollback();
			return [
				'success' => false,
				'message' => $e->getMessage()
			];
		}
    }

    public function applyPagination($query)
    {
        return $query
            ->offset(($this->pagination['num'] - 1) * $this->pagination['limit'])
            ->limit($this->pagination['limit']);
    }

    public function getActiveRelations()
    {
        if ($this->activeRelations !== null) {
            return $this->activeRelations;
        }

        $include = $this->request->input('include');
        if ($include === null) {
            $this->activeRelations = $this->rawResource->getDefaultRelations();
        } else {
            $include = explode(',', $include);
            $validatedInclude = $this->validateInclude($include);

            $this->activeRelations = array_unique(array_merge(
                $validatedInclude,
                $this->rawResource->getDefaultRelations()
            ), SORT_REGULAR);
        }

        return $this->activeRelations;
    }

    public function validateInclude($includes)
    {
        $availableIncludes = $this->getAvailableRelations();
        return array_filter($includes, function ($item) use ($availableIncludes) {
            return in_array($item, $availableIncludes);
        });
    }

    public function getAvailableRelations()
    {
        return $this->rawResource->getAvailableRelations();
    }

    public function parseIncludes($query)
    {
        foreach ($this->getActiveRelations() as $include) {
            $query = $query->with($this->getActiveRelations());
        }

        return $query;
    }

    public function getRelationships()
    {
        return [];
    }

    public function getIncluded()
    {
        return $this->included;
    }

    public function preparePager()
    {
        $pagination = $this->request->input('page');
        $this->pagination['num'] = (int) isset($pagination['num']) ? $pagination['num'] : 1;
        $this->pagination['limit'] = (int) isset($pagination['limit']) ? $pagination['limit'] : 10;

        return $this;
    }
}
