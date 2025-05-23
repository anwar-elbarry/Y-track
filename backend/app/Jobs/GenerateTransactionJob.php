<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Income;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $incomeId;
    /**
     * Create a new job instance.
     */
    public function __construct(int $incomeId)
    {
        $this->incomeId = $incomeId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $income = Income::find($this->incomeId);
        if(!$income || $income->status === 'inactive'){
                return ;
        }

        $today = Carbon::today();

        if($today->lt($income->next_run_at)){
            return;
        }

        $transaction = Transaction::create([
            'user_id'   => $income->user_id,
            'income_id' => $income->id,
            'amount'    => $income->amount,
            'type'    => 'income',
        ]);
         
        Notification::create([
            'user_id' => $income->user_id,
            'type' => 'income',
            'message' => "You have a income of {$income->amount}"
        ]);

        $user = User::find($transaction->user_id);
    
        if ($user) {
            $user->balance += $transaction->amount;
            $user->save();
        }
       

        $next = match($income->frequency){
            'daily'    => Carbon::parse($income->next_run_at)->addDay(),
            'weekly'   => Carbon::parse($income->next_run_at)->addWeek(),
            'monthly'  => Carbon::parse($income->next_run_at)->addMonth(),
            'yearly'   => Carbon::parse($income->next_run_at)->addYear(),
            'one-time'    =>  null,
            default    =>  null
        };

        if($next !== null){
            $income->next_run_at = $next;
            $income->save();

            self::dispatch($income->id)
            ->delay($next->startOfDay());
        }else {
            $income->status = 'inactive';
            $income->save();
        }
            }

}
