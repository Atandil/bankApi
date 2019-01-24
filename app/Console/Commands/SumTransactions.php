<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SumTransactions extends Command
{
    /**
     * TSum of transaction.
     *
     * @var string
     */
    protected $signature = 'transactions:sum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sum of all transactions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //yesterday
        $date=date('d.m.Y',strtotime("-1 days"));

        $this->info("Summary of Transactions for $date");


        $transactions = \App\Transaction::where('date', $date)
                ->get();


            $count = count($transactions);
            $sum = 0;
            foreach ($transactions as $tr) {
                $sum += $tr->amount;
            }

            $sum=number_format((float)$sum, 2, '.', ',');

            $this->info("Number: $count; Sum: $sum; save in file sum.txt");

            Storage::disk('local')->append('sum.txt', "$date:$sum");
    }
}