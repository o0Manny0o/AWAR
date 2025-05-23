<?php

namespace App\Http\Controllers\Auth;

use App\Events\InvitationAccepted;
use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Messages\ToastMessage;
use App\Models\Organisation;
use App\Models\Tenant\OrganisationInvitation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): Response|RedirectResponse
    {
        $token = $request->input('token');
        $organisation = $request->input('organisation');

        if ($token && $organisation) {
            try {
                tenancy()->initialize($organisation);
                $invitation = OrganisationInvitation::firstWhere(
                    'token',
                    $token,
                );
                if (!$invitation || $invitation->isExpired()) {
                    return AppInertia::render('Auth/Register');
                }

                if (User::firstWhere('email', $invitation->email)) {
                    return redirect()->route('login');
                }

                return AppInertia::render('Auth/Register', [
                    'email' => $invitation->email,
                    'token' => $token,
                    'organisation' => $organisation,
                ]);
            } catch (\Exception $e) {
                return AppInertia::render('Auth/Register');
            }
        }

        return AppInertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' =>
                'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'token' => 'sometimes|uuid',
            'organisation' => 'sometimes|uuid',
        ]);

        /** @var User $user */
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'locale' => app()->getLocale(),
        ]);

        event(new Registered($user));

        if ($request->token && $request->organisation) {
            // Add user to the organisation they were invited to
            /** @var Organisation|null $organisation */
            $organisation = Organisation::find($request->organisation);
            if ($organisation) {
                $user->tenants()->attach($organisation);
                ToastMessage::success(
                    __('organisations.invitations.messages.accepted', [
                        'organisation' => $organisation->name,
                    ]),
                );
                event(
                    new InvitationAccepted(
                        $request->token,
                        $request->organisation,
                        $user,
                    ),
                );
            }
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
