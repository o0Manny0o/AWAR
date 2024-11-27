<?php

namespace App\Console\Commands;

use App\Models\Organisation;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Artisan;

class createOrganisation extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-org {name : The name of the organisation} {subdomain : The subdomain of the organisation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new organisation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $subdomain = $this->argument('subdomain');
        $centralApp = config("tenancy.central_domains")[0];

        $organisation = Organisation::create([
            'name' => $name,
        ]);

        $organisation->domains()->create([
            'subdomain' => $subdomain,
            'domain' => $subdomain . "." . $centralApp
        ]);
    }
}
