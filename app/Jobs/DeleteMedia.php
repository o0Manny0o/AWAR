<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class DeleteMedia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var TenantWithDatabase */
    protected $tenant;

    public function __construct(TenantWithDatabase $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle()
    {
        $tenantAnimals = $this->tenant->animals()->get();

        Log::info(
            'Deleting ' .
                count($tenantAnimals) .
                ' images for tenant ' .
                $this->tenant->getKey(),
        );

        foreach ($tenantAnimals as $animal) {
            $animal->detachMedia();
        }
    }
}
