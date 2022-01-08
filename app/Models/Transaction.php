<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id', 'amount', 'date', 'dana_id', 'user_id'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
