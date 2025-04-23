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

    protected $appends = ['formatted_deadline'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getFormattedDeadlineAttribute()
    {
        if (!$this->due_date) {
            return 'Not specified';
        }

        $deadline = \Carbon\Carbon::parse($this->due_date);
        $now = \Carbon\Carbon::now();
    
        if ($deadline->isPast()) {
            return 'Overdue';
        }
    
        if ($deadline->isToday()) {
            return 'Due today';
        }
    
        if ($deadline->isTomorrow()) {
            return 'Due tomorrow';
        }
    
        $difference = $now->diffInDays($deadline);
        return $difference . ' days left';
    }
}
