<?php

$proxies = env('APP_TRUSTED_PROXIES', '');

if ($proxies !== '*' && $proxies !== '**') {
    $proxies = [...array_filter(
        explode(',', $proxies)
    )];
}

return [
    "proxies" => $proxies
];
