<?php

namespace App\Interface;

interface Trackable
{
    /**
     * @return string[]
     */
    public function getTracked(): array;
}
