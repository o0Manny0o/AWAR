<?php

namespace App\Jobs;

use App\Models\Tenant\OrganisationPublicSettings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class CreatePublicSettings implements ShouldQueue
{
    use Queueable,
        InteractsWithQueue,
        \Illuminate\Bus\Queueable,
        SerializesModels;

    /** @var TenantWithDatabase */
    protected $tenant;

    /**
     * Create a new job instance.
     */
    public function __construct(TenantWithDatabase $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        OrganisationPublicSettings::firstOrCreate([
            'name' => $this->tenant->name,
            'organisation_id' => $this->tenant->getKey(),
        ]);
    }
}
