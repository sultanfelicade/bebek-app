<?php

namespace App\Jobs;

use App\Services\CentralSyncService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CentralPushJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    /**
     * @var array<int>
     */
    public array $backoff = [10, 60, 300];

    public function __construct(public int $idBranch)
    {
    }

    public function handle(CentralSyncService $sync): void
    {
        $ok = $sync->pushForBranch($this->idBranch);
        if (!$ok) {
            throw new \RuntimeException('Central push failed');
        }
    }
}
