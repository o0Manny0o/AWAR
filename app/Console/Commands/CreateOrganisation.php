<?php

namespace App\Console\Commands;

use App\Enum\DefaultTenantUserRole;
use App\Models\Organisation;
use App\Models\Tenant\Member;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class CreateOrganisation extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-org {name : The name of the organisation} {subdomain : The subdomain of the organisation} {user? : The user to assign to the organisation}';

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
        $user = $this->argument('user');
        $centralApp = config("tenancy.central_domains")[0];

        $organisation = Organisation::create([
            'name' => $name,
        ]);

        $organisation->domains()->create([
            'subdomain' => $subdomain,
            'domain' => $subdomain . "." . $centralApp
        ]);

        if ($user) {
            $user = User::find($user);
            $user->tenants()->attach($organisation);
        }

        tenancy()->find($organisation->id)->run(function () use ($user) {
            $member = Member::firstWhere("global_id", $user->global_id);
            $member->assignRole(DefaultTenantUserRole::ADMIN);
        });
    }
}
