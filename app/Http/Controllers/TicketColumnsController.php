<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelpers;
use App\Models\TicketColumns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketColumnsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('index!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd('create!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $columnname = $request->title;
        $columndescription = $request->description ?? null;
        $colour = $request->colour ?? null;
        $board_id = $request->boardId;

        $currentColumns = UserHelpers::getUserColumns($user);

        // check for duplicate names
        // if ($currentColumns) {
        //     foreach ($currentBoards as $board) {
        //         if ($board->boardname == $boardname) {
        //             return redirect()->back();
        //         }
        //     }
        // }

        $ticketcolumn = new TicketColumns();
        $ticketcolumn->columnname = $columnname;
        $ticketcolumn->columndescription = $columndescription;
        $ticketcolumn->colour = $colour;
        $ticketcolumn->ticketboards_id = $board_id;
        $ticketcolumn->save();

        //$user->update(['currentactivekanbanboard' => $ticketboard->id]);
        //$user->save();

        return redirect()->route('tickets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        dd('show!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        dd('edit!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd('update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd('destroy!');
    }
}
