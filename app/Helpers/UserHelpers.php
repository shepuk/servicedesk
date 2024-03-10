<?php

namespace App\Helpers;

use App\Models\TicketBoards;
use App\Models\TicketColumns;
use App\Models\Tickets;
use App\Models\User;

class UserHelpers
{

    public static function getUserBoards(User $user)
    {
        $team = $user->currentTeam->id;
        return TicketBoards::where('team_id', $team)->get();
    }

    public static function getUserColumns(User $user)
    {
        $team = $user->currentTeam->id;
        $boards = TicketBoards::where('team_id', $team)->pluck('id')->toArray();
        return TicketColumns::whereIn('ticketboards_id', $boards)->get();
    }

    public static function getUserTickets(User $user)
    {
        $team = $user->currentTeam->id;
        return Tickets::where('team_id', $team)->get();
    }

}
