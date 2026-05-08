<?php

namespace App\Jobs;

use App\Services\CentralSyncService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CentralPullMasterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;

    /**
     * @var array<int>
     */
    public array $backoff = [30, 300];

    public function handle(CentralSyncService $sync): void
    {
        $ok = $sync->pullMasterData();
        if (!$ok) {
            throw new \RuntimeException('Central master pull failed');
        }
    }
}
