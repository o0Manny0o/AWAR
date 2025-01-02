<?php

namespace App\Console\Commands;

use App\Authorisation\Enum\OrganisationRole;
use App\Authorisation\PermissionContext;
use App\Models\Organisation;
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
    protected $signature = 'app:create-org {name : The name of the organisation} {subdomain : The subdomain of the organisation} {user_id? : The id of the user to assign to the organisation}';

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
        $user_id = $this->argument('user_id');
        $centralApp = config('tenancy.central_domains')[0];

        /** @var Organisation $organisation */
        $organisation = Organisation::create([
            'name' => $name,
        ]);

        $organisation->domains()->create([
            'subdomain' => $subdomain,
            'domain' => $subdomain . '.' . $centralApp,
        ]);

        if ($user_id) {
            /** @var User $user */
            $user = User::find($user_id);
            $user->tenants()->attach($organisation);

            PermissionContext::tenant(
                $user,
                function ($user) {
                    $user->assignRole(OrganisationRole::ADMIN);
                },
                $organisation,
            );
        }
    }
}
