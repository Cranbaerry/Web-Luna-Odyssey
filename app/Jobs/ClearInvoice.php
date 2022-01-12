<?php

namespace App\Jobs;

use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ClearInvoice {
    function __construct() {
        // 00 success
        // 01 pending
        // 02 canceled
    }

    function __invoke() {
        $invoices = Invoice::where('date_created', '<=', Carbon::now()->subMinutes(30)->toDateTimeString())
            ->where('status_code', '01')
            ->where('method', '!=' , 'Manual_BCA')
            ->get();

        foreach ($invoices as $invoice) {
            Log::channel('stderr')
                ->info(sprintf('Canceling transaction id: %d' . PHP_EOL, $invoice->transaction_id));
            $invoice->status_code = '02';
            $invoice->save();
        }
    }
}
