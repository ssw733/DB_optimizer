<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OffloadTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:migrate-to-s3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimizing the emails table in S3 storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emails = DB::table('emails')
        ->leftJoin('emails_s3_content', 'emails.id', '=', 'emails_s3_content.email_id')
        ->whereNull('emails_s3_content.id')
        ->limit(env('S3_EMAILS_BATCH_SIZE'))->get();

        foreach($emails as $email) {
            print_r($email);
        }
    }
}
