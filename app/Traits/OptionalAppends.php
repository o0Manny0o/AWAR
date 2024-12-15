<?php

namespace App\Traits;

trait OptionalAppends
{
    /**
     * @var bool
     */
    public static bool $withoutAppends = false;

    public array $forceAppends = [];

    /**
     * Check if $withoutAppends is enabled.
     *
     * @return array
     */
    protected function getArrayableAppends()
    {
        if (self::$withoutAppends) {
            return $this->forceAppends;
        }
        return parent::getArrayableAppends();
    }

    public function setForceAppends(array $appends)
    {
        $this->forceAppends = array_merge($this->forceAppends, $appends);

        return $this;
    }
}
