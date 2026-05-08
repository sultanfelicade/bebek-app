<?php

namespace App\Http\Middleware;

use App\Jobs\CentralPullMasterJob;
use App\Jobs\CentralPushJob;
use App\Services\CentralSyncService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class AutoCentralSync
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $idBranch = (int) $request->session()->get('id_branch');
        if ($idBranch <= 0) {
            return $response;
        }

        /** @var CentralSyncService $sync */
        $sync = app(CentralSyncService::class);
        if (!$sync->isRemoteConfigured()) {
            return $response;
        }

        if (Cache::add('central-sync:push-dispatch:' . $idBranch, 1, now()->addSeconds(20))) {
            CentralPushJob::dispatch($idBranch)->afterResponse();
        }

        if (Cache::add('central-sync:pull-dispatch', 1, now()->addMinutes(30))) {
            CentralPullMasterJob::dispatch()->afterResponse();
        }

        return $response;
    }
}
