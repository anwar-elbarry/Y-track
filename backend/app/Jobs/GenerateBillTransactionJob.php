<?php

namespace App\Jobs;

use App\Models\Bill;
use Carbon\Carbon;
use App\Models\upcoming_bill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateBillTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $billid;

    public function __construct(int $billid)
    {
        $this->billid = $billid;
    }

    public function handle(): void
    {
        \Log::info('Starting GenerateBillTransactionJob', ['bill_id' => $this->billid]);
    
        $bill = Bill::find($this->billid);
        if (!$bill) {
            \Log::error('Bill not found in database', ['bill_id' => $this->billid]);
            return;
        }
    
        $dueDate = Carbon::parse($bill->due_date);
        $now = Carbon::now();
        $daysUntilDue = $dueDate->diffInDays($now, false); 
        
        \Log::info('Due date analysis', [
            'due_date' => $dueDate,
            'now' => $now,
            'days_until_due' => $daysUntilDue,
            'is_future_or_today' => $dueDate->greaterThanOrEqualTo($now->startOfDay())
        ]);
    
        // Modify condition to include today's date
        if ($dueDate->greaterThanOrEqualTo($now->startOfDay()) && $daysUntilDue <= 7) {
            // Check if an upcoming bill already exists for this due date
            $existingUpcomingBill = upcoming_bill::where('original_bill_id', $bill->id)
                ->where('due_date', $bill->due_date)
                ->first();
    
            if (!$existingUpcomingBill) {
                \Log::info('Creating new upcoming bill', [
                    'bill_id' => $bill->id,
                    'due_date' => $bill->due_date
                ]);
    
                try {
                    $upcomingBill = upcoming_bill::create([
                        'user_id' => $bill->user_id,
                        'original_bill_id' => $bill->id,
                        'due_date' => $bill->due_date,
                        'status' => 'unpaid',
                        'amount' => $bill->amount,
                    ]);
                    \Log::info('Successfully created upcoming bill', ['upcoming_bill_id' => $upcomingBill->id]);
                } catch (\Exception $e) {
                    \Log::error('Failed to create upcoming bill', [
                        'error' => $e->getMessage(),
                        'bill_id' => $bill->id
                    ]);
                }
            } else {
                \Log::info('Upcoming bill already exists', [
                    'upcoming_bill_id' => $existingUpcomingBill->id,
                    'bill_id' => $bill->id
                ]);
            }
        } else {
            \Log::info('Bill due date not within next 7 days', [
                'bill_id' => $bill->id,
                'days_until_due' => $daysUntilDue
            ]);
        }
    
        // Recurring bill logic remains the same
        if ($bill->is_recurred && $bill->frequency !== 'one-time') {
            \Log::info('Processing recurring bill', [
                'bill_id' => $bill->id,
                'frequency' => $bill->frequency
            ]);
    
            $nextDueDate = match($bill->frequency) {
                'daily' => Carbon::parse($bill->due_date)->addDay(),
                'weekly' => Carbon::parse($bill->due_date)->addWeek(),
                'monthly' => Carbon::parse($bill->due_date)->addMonth(),
                'yearly' => Carbon::parse($bill->due_date)->addYear(),
                default => null
            };
    
            if ($nextDueDate) {
                \Log::info('Calculated next due date', [
                    'bill_id' => $bill->id,
                    'next_due_date' => $nextDueDate
                ]);
    
                try {
                    $bill->due_date = $nextDueDate;
                    $bill->save();
                    \Log::info('Updated bill with new due date', ['bill_id' => $bill->id]);
                    
                    self::dispatch($bill->id)
                        ->delay($nextDueDate);      
                    \Log::info('Scheduled next bill check', [
                        'bill_id' => $bill->id,
                        'next_due_date' => $nextDueDate
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to update bill or schedule next check', [
                        'error' => $e->getMessage(),
                        'bill_id' => $bill->id
                    ]);
                }
            }
        }
    
        \Log::info('Completed GenerateBillTransactionJob', ['bill_id' => $this->billid]);
    }
}