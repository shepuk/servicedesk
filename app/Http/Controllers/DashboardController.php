<?php

namespace App\Http\Controllers;

use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Jetstream\Contracts\AddsTeamMembers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Gets all the invitations for this user and accept them
        $pendingInvitations = TeamInvitation::where('email', '=', $user->email)->get();

        if ($pendingInvitations && count($pendingInvitations) > 0) {
            foreach ($pendingInvitations as $invitation) {

                app(AddsTeamMembers::class)->add(
                    $invitation->team->owner,
                    $invitation->team,
                    $invitation->email,
                    $invitation->role
                );

                $invitation->delete();

            }
        }

        $currentTeams = $user->allTeams();
        if ($currentTeams && count($currentTeams) == 1) {
            $user->switchTeam($currentTeams[0]);
        }

        return Inertia::render('Dashboard');
    }
}
