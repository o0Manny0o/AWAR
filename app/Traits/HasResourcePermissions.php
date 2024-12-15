<?php

namespace App\Traits;

use App\Enum\ResourcePermission;
use Illuminate\Support\Str;

trait HasResourcePermissions
{
    private bool $can_be_deleted = false;
    private bool $can_be_restored = false;
    private bool $can_be_updated = false;
    private bool $can_be_viewed = false;
    private bool $can_be_submitted = false;
    private bool $can_be_resend = false;
    private bool $can_be_published = false;
    private bool $can_assign_handler = false;
    private bool $can_assign_foster_home = false;

    public function __call($name, $arguments)
    {
        if (preg_match('/^get([^;]+)Attribute$/', $name, $match)) {
            $field = Str::snake($match[1]);
            if (
                !!ResourcePermission::tryFrom($field) &&
                property_exists($this, $field)
            ) {
                return $this->{$field};
            }
        }
        if (preg_match('/^can([^;]+)$/', $name, $match)) {
            $field = Str::snake($match[1]);
            if (
                !!ResourcePermission::tryFrom($field) &&
                property_exists($this, $field)
            ) {
                return $this->{$field};
            }
        }
        return parent::__call($name, $arguments);
    }

    public function setPermissions($user): void
    {
        $this->can_be_deleted = $user->can('delete', $this);
        $this->can_be_restored = $user->can('restore', $this);
        $this->can_be_viewed = $user->can('view', $this);
        $this->can_be_updated = $user->can('update', $this);
        $this->can_be_submitted = $user->can('submit', $this);
        $this->can_be_resend = $user->can('resend', $this);
        $this->can_be_published = $user->can('publish', $this);
        $this->can_assign_handler = $user->can('assign', $this);
        $this->can_assign_foster_home = $user->can('assignFosterHome', $this);
    }

    protected function initializeHasResourcePermissions(): void
    {
        $this->appends = array_merge($this->appends, $this->permissionsArray());
    }

    private function permissionsArray()
    {
        return array_map(
            fn($permission) => $permission->value,
            array_filter(
                $this->resource_permissions ?? [],
                fn($permission) => $permission instanceof ResourcePermission,
            ),
        );
    }
}
