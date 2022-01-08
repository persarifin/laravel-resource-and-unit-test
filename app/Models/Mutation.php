<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'from_dana_id',
        'to_dana_id'
    ];

    public function from_dana()
    {
        return $this->belongsTo(Dana::class,'from_dana_id');
    }
    public function to_dana()
    {
        return $this->belongsTo(Dana::class,'to_dana_id');
    }
}
