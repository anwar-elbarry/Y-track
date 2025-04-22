<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'target_amount',
        'saved_amount',
        'status',
        'due_date',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
