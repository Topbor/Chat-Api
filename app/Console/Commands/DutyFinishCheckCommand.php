<?php

namespace App\Console\Commands;

use App\Models\Duty;
use App\ServiceJobs\Marketplace\AvitoProductFeed;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DutyFinishCheckCommand extends Command
{
    protected $signature = 'app:duty:check';

    public function handle()
    {
        $duties = Duty::query()
            ->where('beginning_at', '<', Carbon::now()->addHours(3))
            ->where('started', true)
            ->get();

        foreach ($duties as $duty){
            if(Carbon::now()->addHours(3)->gt($duty->beginning_at->addHours($duty->duration))){
                $duty->delete();
            }
        }
    }
}
