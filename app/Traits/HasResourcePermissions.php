<?php

namespace App\Traits;

trait HasResourcePermissions
{
    private bool $deletable = false;
    private bool $restoreable = false;
    private bool $updatable = false;
    private bool $viewable = false;
    private bool $submittable = false;
    private bool $resendable = false;

    public function setPermissions($user): void
    {
        $this->deletable = $user->can('delete', $this);
        $this->restoreable = $user->can('restore', $this);
        $this->viewable = $user->can('view', $this);
        $this->updatable = $user->can('update', $this);
        $this->submittable = $user->can('submit', $this);
        $this->resendable = $user->can('resend', $this);
    }

    public function isDeletable(): bool
    {
        return $this->deletable;
    }

    public function getCanBeDeletedAttribute(): bool
    {
        return $this->isDeletable();
    }

    public function isRestoreable(): bool
    {
        return $this->restoreable;
    }

    public function getCanBeRestoredAttribute(): bool
    {
        return $this->isRestoreable();
    }

    public function isUpdatable(): bool
    {
        return $this->updatable;
    }

    public function getCanBeUpdatedAttribute(): bool
    {
        return $this->isUpdatable();
    }

    public function isViewable(): bool
    {
        return $this->viewable;
    }

    public function getCanBeViewedAttribute(): bool
    {
        return $this->isViewable();
    }

    public function isSubmittable(): bool
    {
        return $this->submittable;
    }

    public function getCanBeSubmittedAttribute(): bool
    {
        return $this->isSubmittable();
    }

    public function isResendable(): bool
    {
        return $this->resendable;
    }

    public function getCanBeResendedAttribute(): bool
    {
        return $this->isResendable();
    }
}
