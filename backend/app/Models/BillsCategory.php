<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillsCategory extends Model
{
    use HasFactory;
    protected $table = 'bills_categories';
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bills(){
        return $this->hasMany(Bill::class ,'category_id','id');
    }
}
