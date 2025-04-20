<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\User;

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
       return $this->belongsTo(User::class);
    }
    public function Category(){
       return $this->belongsTo(Category::class);
    }
}
