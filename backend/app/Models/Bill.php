<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'amount',
        'category_id',
        'frequency',
        'due_date',
        'last_payment',
        'is_recurred',
        'logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(BillsCategory::class);
    }
}
