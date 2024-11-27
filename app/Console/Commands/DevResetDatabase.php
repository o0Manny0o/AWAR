<?php

namespace App\Console\Commands;

use App\Models\Organisation;
use Illuminate\Console\Command;

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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->components->info('Deleting Database.');
        $this->components->task('Deleting all organisations', function () {
            $organisations = Organisation::all();
            foreach ($organisations as $organisation) {
                try {
                    $organisation->delete();
                } catch (\Exception $e) {
                    continue;
                }
            }
        });

        $this->call('migrate:fresh', ['--seed' => true, '--seeder' => 'DevelopmentSeeder']);
    }
}
