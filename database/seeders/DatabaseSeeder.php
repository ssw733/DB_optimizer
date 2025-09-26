<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Services\SeedGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        while (true) {
            $emails = $files = [];
            $currentTime = Carbon::today()->format('Y-m-d H:i:s');
            //Произвольные типы файлов
            $fileTypes = ['mp3', 'wav', 'doc', 'docx', 'avi', 'html', 'tiff', 'rar', 'zip'];
            $maxEmailId = DB::table('emails')->count('id');
            $maxFileId = DB::table('files')->max('id');
            foreach (range(1, env('SEEDER_BATCH_SIZE')) as $i) {
                $createdAt = Carbon::today()->subDays(rand(0, 365 * 10))->format('Y-m-d H:i:s');
                //Создаёт объект email
                $emails[$i] = [
                    'client_id' => random_int(1, 999999),
                    'loan_id' => random_int(1, 999999999),
                    'email_template_id' => random_int(1, 9),
                    'receiver_email' => Str::random(10) . '@' . Str::random(5) . '.com',
                    'sender_email' => 'company@email' . random_int(0, 9) . '.com',
                    'subject' => Str::random(10),
                    'body' => SeedGenerator::createRandomHtml(),
                    'file_ids' => [],
                    'created_at' => $createdAt,
                    'sent_at' => $createdAt
                ];
                //Создаёт файлы для email
                foreach (range(0, random_int(0, 2)) as $f) {
                    $maxFileId++;
                    $fileName = Str::uuid();
                    $fileType = $fileTypes[array_rand($fileTypes)];
                    $filePath = $i . '/' . $fileName . '.' . $fileType;
                    Storage::disk('local')->put($filePath, random_bytes(random_int(1000, 50000)));
                    $files[] = [
                        'name' => $fileName,
                        'path' => $filePath,
                        'size' => Storage::size($filePath),
                        'type' => $fileType
                    ];
                    $emails[$i]['file_ids'][] = $maxFileId;
                }
                $emails[$i]['file_ids'] = json_encode($emails[$i]['file_ids']);
            }

            DB::transaction(function () use ($emails, $files) {
                DB::table('emails')->insert($emails);
                DB::table('files')->insert($files);
            });

            echo 'Added another ' . env('SEEDER_BATCH_SIZE') . ' entries, total: ' . ($maxEmailId + env('SEEDER_BATCH_SIZE')) . PHP_EOL;
        }
    }
}
