<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MutationResource extends BaseResource
{
    protected $availableRelations = ['from_dana','to_dana'];
    protected $resourceType = 'mutation';

    public function toArray($request)
    {
        return $this->transformResponse([
            'id'            => $this->getIdentifier(),
            'amount'        => $this->amount,
            'from_dana_id'  => $this->from_dana_id,
            'to_dana_id'    => $this->to_dana_id,
        ]);
    }
    
    public function getFromDanaRelation()
    {
        return new DanaResource($this->from_dana_id);
    }

    public function getToDanaRelation()
    {
        return new DanaResource($this->to_dana_id);
    }
}
