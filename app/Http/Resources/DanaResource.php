<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DanaResource extends BaseResource
{
    protected $availableRelations = ['user'];
    protected $resourceType = 'dana';

    public function toArray($request)
    {
        return $this->transformResponse([
            'id'            => $this->getIdentifier(),
            'amount'        => $this->amount,
            'user'          => $this->user->name,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at
        ]);
    }

    public function getUserRelation()
    {
        return new UserResource($this->user_id);
    }
}
