<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'email',
        'city',
        'postal_code',
        'country',
        'user_id',
    ];

    public function customers()
    {
        return $this->belongsTo(User::class);
    }
}
