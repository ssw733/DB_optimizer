<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        echo 'Starting...' . PHP_EOL;

        while (true) {
            $emailsData = DB::table('emails')
            ->leftJoin('files', 'emails.id', '=', 'files.email_id')
            ->select('emails.id', 'emails.file_ids', 'emails.body')
            ->whereNull('files.email_id')
            ->limit(env('S3_EMAILS_BATCH_SIZE'))
            ->get();

            foreach($emailsData as $ed) {
                Storage::disk('s3')->put('body_' . $ed->id . '.html', $ed->body);
                $fileIds = explode(',', trim($ed->file_ids, '[]'));
                $files = DB::table('files')
                ->whereIn('id', $fileIds)
                ->get();
                foreach ($files as $f) {
                    Storage::disk('s3')->put($f->name . '.' . $f->type, Storage::disk('local')->get($f->path));
                }
            }
            DB::table('emails')->where()->update($toUpdateEmails);
            $progress = DB::table('emails')->whereNull('body_s3_path')->count();
            echo 'Added another ' . env('S3_EMAILS_BATCH_SIZE') . ' emails to S3, left ' . $progress . PHP_EOL;
        }
    }
}
