<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Income;
use App\Models\Invoice;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name', 
        'email', 
        'phone',
        'address',
        'linkedin',
        'instagram',
        'other_website'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Incomes
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    // Relationship with Invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
