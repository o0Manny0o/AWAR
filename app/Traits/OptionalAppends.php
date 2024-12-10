<?php

namespace App\Traits;

trait OptionalAppends
{
    /**
     * @var bool
     */
    public static bool $withoutAppends = false;

    /**
     * Check if $withoutAppends is enabled.
     *
     * @return array
     */
    protected function getArrayableAppends()
    {
        if (self::$withoutAppends) {
            return [];
        }
        return parent::getArrayableAppends();
    }
}
