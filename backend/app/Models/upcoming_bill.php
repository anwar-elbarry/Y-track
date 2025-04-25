<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class upcoming_bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original_bill_id',
        'due_date',
        'status',
        'amount',
    ];

    public function originalBill()
    {
        return $this->belongsTo(Bill::class, 'original_bill_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
