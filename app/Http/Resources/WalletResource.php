<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends BaseResource
{
    protected $availableRelations = [];
    protected $resourceType = 'wallet';

    public function toArray($request)
    {
        return $this->transformResponse([
            'id'            => $this->getIdentifier(),
            'wallett_name'  => $this->wallett_name,
        ]);
    }
}
