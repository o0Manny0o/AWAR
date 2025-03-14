<?php

namespace App\Events\Animals;

use App\Models\Animal\Animal;
use App\Models\Animal\Listing\Listing;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ListingCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Animal $animal,
        public User $user,
        public Listing $listing,
    ) {
        //
    }
}
