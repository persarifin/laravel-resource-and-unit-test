<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends BaseResource
{
    protected $availableRelations = ['wallet'];
    protected $resourceType = 'dana';

    public function toArray($request)
    {
        return $this->transformResponse([
            'id'            => $this->getIdentifier(),
            'amount'        => $this->amount,
            'date'          => $this->date,
            'wallet_id'     => $this->wallet_id,
            'wallet_name'   => $this->wallet->wallet_name,

        ]);
    }
    public function getWalletRelation()
    {
        return new WalletResource($this->wallet_id);
    }
}
