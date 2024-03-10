<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Helpers\UserHelpers;
use App\Models\TicketBoards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketBoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $boardname = $request->title;
        $boarddescription = $request->description ?? null;

        $currentBoards = UserHelpers::getUserBoards($user);

        // check for duplicate names
        if ($currentBoards) {
            foreach ($currentBoards as $board) {
                if ($board->boardname == $boardname) {
                    return redirect()->back();
                }
            }
        }

        $ticketboard = new TicketBoards();
        $ticketboard->boardname = $boardname;
        $ticketboard->boarddescription = $boarddescription;
        $ticketboard->save();

        $user->update(['currentactivekanbanboard' => $ticketboard->id]);
        $user->save();

        return redirect()->route('tickets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
