<?php

namespace App;

interface Trackable
{
    /**
     * @return string[]
     */
    public function getTracked(): array;
}
