<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelpers;
use App\Models\TicketColumnsOrders;
use App\Models\TicketOrders;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

//use App\Helpers\UserHelpers as UserHelper;

class TicketsController extends Controller
{
    public function index(Tickets $tickets)
    {

        $user = Auth::user();
        $team = $user->currentTeam;
        $teamUsers = null;
        if ($team) {
            $teamUsers = $team->allUsers();
        }   

        // check if user has teams - we'll display a message if they don't
        $currentTeams = $user->allTeams();
        if ($currentTeams && count($currentTeams) < 1) {
            return Inertia::render('Tickets', [
                'hasnoteams' => true,
            ]);
        }

        $boards = UserHelpers::getUserBoards($user);
        $columns = UserHelpers::getUserColumns($user);
        $tickets = UserHelpers::getUserTickets($user);

        $teamColumnIds = $columns->pluck('id')->toArray();
        $ticketOrder = TicketOrders::whereIn('ticketcolumns_id', $teamColumnIds)->get();

        $teamBoardIds = $boards->pluck('id')->toArray();
        $columnOrder = TicketColumnsOrders::whereIn('ticketboards_id', $teamBoardIds)->get();

        function appySortedOrder($object, $idOrder)
        {
            $sorted = $object->sortBy(function ($item) use ($idOrder) {
                return array_search($item->id, $idOrder);
            });
            return $sorted->values();
        }

        //sort the tickets into columns, and the columns into boards
        $boardsColumnsTickets = [];
        if (!$boards->isEmpty()) {
            $boardsColumnsTickets['boards'] = $boards;
            if (!$columns->isEmpty()) {
                foreach ($boardsColumnsTickets['boards'] as $board) {
                    $board['columns'] = $columns->where('ticketboards_id', $board->id);
                    // if columnOrder exists for this board, grab it and sort the columns
                    if ($columnOrder->where('ticketboards_id', $board->id)->value('columnorder') != null && $columnOrder->where('ticketboards_id', $board->id)->value('columnorder') != '') {
                        $board['columnorder'] = $columnOrder->where('ticketboards_id', $board->id)->value('columnorder');
                        $idOrder = explode('|', $board['columnorder']);
                        $board['columns'] = appySortedOrder($board['columns'], $idOrder);
                    }
                }
            }
        }

        if (!$tickets->isEmpty()) {
            foreach ($boardsColumnsTickets['boards'] as $board) {
                foreach ($board['columns'] as $column) {
                    $column['tickets'] = $tickets->where('ticketcolumns_id', $column->id);
                    // if tickeorder exists for this column, grab it and sort the tickets
                    if ($ticketOrder->where('ticketcolumns_id', $column->id)->value('ticketorder') != null && $ticketOrder->where('ticketcolumns_id', $column->id)->value('ticketorder') != '') {
                        $column['ticketorder'] = $ticketOrder->where('ticketcolumns_id', $column->id)->value('ticketorder');
                        $idOrder = explode('|', $column['ticketorder']);
                        $column['tickets'] = appySortedOrder($column['tickets'], $idOrder);
                    }
                }
            }
        }

        // collect uncategorised tickets
        $uncategorisedTickets = $tickets->where('ticketcolumns_id', null);


        return Inertia::render('Tickets', [
            //'activeBoard' => $user->currentactivekanbanboard,
            'sortedTickets' => $boardsColumnsTickets,
            'uncategorisedTickets' => $uncategorisedTickets,
            'teamUsers' => $teamUsers,
        ]);
    }

    public function create(Tickets $tickets)
    {
        dd('create');
        return Inertia::render('Tickets');
    }

    public function store(Tickets $tickets, Request $request)
    {
        $tickettitle = $request->title;
        $ticketdescription = $request->description ?? null;
        $creator = Auth::user()->id;
        $assignee = $request->assignee ?? 'Not Assigned';
        $ticketpriority = $request->severity ?? null;
        $ticketcustomfields = $request->customfields ?? null;
        $ticketstatus = $request->status ?? null;
        $ticketcolumn = $request->column ?? null;

        //todo: implement ticket comments feed (new table)
        //toto: implement fallback column selection on ticket creation

        Tickets::create([
            'tickettitle' => $tickettitle,
            'ticketdescription' => $ticketdescription,
            'creator' => $creator,
            'assignee' => $assignee,
            'ticketpriority' => $ticketpriority,
            'ticketcustomfields' => $ticketcustomfields,
            'ticketstatus' => $ticketstatus,
            "ticketcolumns_id" => $ticketcolumn,
        ]);

        return redirect()->back();
    }

    public function update(Tickets $ticket, Request $request)
    {
        // request:
        // ticket: ticketId,
        // column: colId,

        $ticket = Tickets::where('id', $request->ticket->id)->first();
        $ticket->update(['ticketcolumns_id' => $request->column]);
        $ticket->save();

        return redirect()->back();
    }

    public function destroy(Tickets $ticket)
    {
        $ticket->delete();
        return redirect()->back();
    }
}
