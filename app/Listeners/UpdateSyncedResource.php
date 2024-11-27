<?php

namespace App\Listeners;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Contracts\SyncMaster;
use Stancl\Tenancy\Events\SyncedResourceChangedInForeignDatabase;
use Stancl\Tenancy\Listeners\UpdateSyncedResource as BaseUpdateSyncedResource;

class UpdateSyncedResource extends BaseUpdateSyncedResource
{
    protected function updateResourceInTenantDatabases($tenants, $event, $syncedAttributes)
    {
        tenancy()->runForMultiple($tenants, function ($tenant) use ($event, $syncedAttributes) {
            // Forget instance state and find the model,
            // again in the current tenant's context.

            $eventModel = $event->model;

            if ($eventModel instanceof SyncMaster) {
                // If event model comes from central DB, we get the tenant model name to run the query
                $localModelClass = $eventModel->getTenantModelName();
            } else {
                $localModelClass = get_class($eventModel);
            }

            /** @var Model|null */
            $localModel = $localModelClass::firstWhere($event->model->getGlobalIdentifierKeyName(), $event->model->getGlobalIdentifierKey());

            // Also: We're syncing attributes, not columns, which is
            // why we're using Eloquent instead of direct DB queries.

            // We disable events for this call, to avoid triggering this event & listener again.
            $localModelClass::withoutEvents(function () use ($localModelClass, $localModel, $syncedAttributes, $eventModel, $tenant) {
                if ($localModel) {
                    $localModel->update($syncedAttributes);
                } else {
                    // When creating, we use all columns, not just the synced ones.
                    $localModel = $localModelClass::create($eventModel->only($eventModel->getSyncedCreationAttributes()));
                }

                event(new SyncedResourceChangedInForeignDatabase($localModel, $tenant));
            });
        });
    }
}
