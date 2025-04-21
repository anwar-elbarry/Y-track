<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Client;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'amount',
        'source',
        'date',
        'frequency',
        'status',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Client
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
