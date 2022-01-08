<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dana extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
