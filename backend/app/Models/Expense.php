<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'category_id',
        'description',
        'date',
    ];


    public function User(){
        $this->belongsTo(User::class);
    }
    public function Category(){
        $this->hasMany(Category::class);
    }
}
