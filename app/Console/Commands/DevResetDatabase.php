<?php

namespace App\Console\Commands;

use App\Models\Organisation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class DevResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dev-reset-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all organisations. Afterwards, completely reset the database and seed.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->components->task('Deleting all organisations', function () {
            if (!Schema::hasTable('organisations')) {
                return;
            }
            $organisations = Organisation::all();
            foreach ($organisations as $organisation) {
                try {
                    $organisation->delete();
                } catch (\Exception $e) {
                    continue;
                }
            }
        });

        $this->call('migrate:fresh', [
            '--seed' => true,
            '--seeder' => 'DevelopmentSeeder',
        ]);
    }
}
