<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends BaseResource
{
    protected $availableRelations = [];
    protected $resourceType = 'user';

    public function toArray($request)
    {
        return $this->transformResponse([
            'id'            => $this->getIdentifier(),
            'name'          => $this->name,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'address'       => $this->address,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at
        ]);
    }
}
