<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class generateTypescriptRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-typescript-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a typescript file with all the routes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('route:cache');
        $contents = array_filter(array_map(fn($route) => $route->getName(), Route::getRoutes()->getRoutesByName()), fn($route) => stripos($route, "generated") === false);
        File::put(resource_path("js/types/routes.d.ts"), "type Routes =  '".implode("' | '", $contents)."'");
    }
}
