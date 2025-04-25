<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateBillTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $billId;

    public function __construct(int $billId)
    {
        $this->billId = $billId;
    }

    public function handle(): void
    {
        $bill = Bill::find($this->billId);
        if (!$bill || $bill->status === 'inactive') {
            return;
        }

        if ($bill->frequency !== 'one-time') {
            $nextDueDate = match($bill->frequency) {
                'daily' => Carbon::parse($bill->due_date)->addDay(),
                'weekly' => Carbon::parse($bill->due_date)->addWeek(),
                'monthly' => Carbon::parse($bill->due_date)->addMonth(),
                'yearly' => Carbon::parse($bill->due_date)->addYear(),
                default => null
            };

            if ($nextDueDate) {
                $newBill = $bill->replicate();
                $newBill->due_date = $nextDueDate;
                $newBill->status = 'unpaid';
                $newBill->save();

                self::dispatch($newBill->id)
                    ->delay($nextDueDate);
            }
        }
    }
}