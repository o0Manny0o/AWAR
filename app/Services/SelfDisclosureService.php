<?php

namespace App\Services;

use App\Models\SelfDisclosure\UserSelfDisclosure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class SelfDisclosureService
{
    /** Get the user's self disclosure
     * @throws AuthenticationException
     */
    public function getDisclosure($user = null): UserSelfDisclosure
    {
        if (session()->has('self_disclosure')) {
            return session('self_disclosure');
        } else {
            if (!$user && !Auth::check()) {
                throw new AuthenticationException();
            }
            $disclosure = UserSelfDisclosure::ofUser(
                $user ?? Auth::user(),
            )->first();
            session()->flash('self_disclosure', $disclosure);
            return $disclosure;
        }
    }
}
