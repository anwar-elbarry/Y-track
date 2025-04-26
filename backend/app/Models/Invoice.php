<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_path',
        'client_id',
        'service_price',
        'due_date',
        'service_name',
        'service_description',
        'user_id',
    ];
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}