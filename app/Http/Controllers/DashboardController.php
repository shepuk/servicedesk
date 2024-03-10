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

        // Gets all the invitations for this user and accepts them
        $pendingInvitations = TeamInvitation::where('email', '=', $user->email)->get();
        if ($pendingInvitations && count($pendingInvitations) > 0) {
            $justJoinedTeam = [];
            foreach ($pendingInvitations as $invitation) {
                app(AddsTeamMembers::class)->add(
                    $invitation->team->owner,
                    $invitation->team,
                    $invitation->email,
                    $invitation->role
                );
                array_push($justJoinedTeam, [$invitation->team->name]);
                $invitation->delete();
            }
        }
        $currentTeams = $user->allTeams();
        if ($currentTeams && count($currentTeams) == 1) {
            $user->switchTeam($currentTeams[0]);
        }
        if (isset($justJoinedTeam)) {
            return Inertia::render('Dashboard', [
                'justJoinedTeams' => $currentTeams,
            ]);
        }

        return Inertia::render('Dashboard');
    }
}
