<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];
    protected $fillable = [
        'user_id',
        'type',
        'amount',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
