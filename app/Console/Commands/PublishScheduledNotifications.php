<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PushNotification;

class PublishScheduledNotifications extends Command
{
    protected $signature = 'notifications:publish';
    protected $description = 'Publish scheduled push notifications';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $scheduledNot = PushNotification::where('status', 4) 
                              ->where('schedule_date', '<=', now()) 
                              ->get();

        foreach ($scheduledNot as $post) {
            $post->status = 1;
            $post->updated_at = $post->created_at;
            $post->save();
        }

        $this->info('Scheduled notification published successfully.');
    }
}
