<?php

namespace App\Events\Animals;

use App\Models\Animal\Animal;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnimalCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Animal $animal,
        public array $familyChanges,
        public User $user,
    ) {
        //
    }
}
