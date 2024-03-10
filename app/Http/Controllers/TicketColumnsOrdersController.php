<?php

namespace App\Http\Controllers;

use App\Models\TicketColumnsOrders;
use Illuminate\Http\Request;

class TicketColumnsOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    dd('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = implode('|', $request->order);
        $board = $request->board;

        if (TicketColumnsOrders::where('ticketboards_id', $board)->exists()) {
            TicketColumnsOrders::where('ticketboards_id', $board)->update([
                'columnorder' => $order,
                'ticketboards_id' => $board,
            ]);
        } else {
            TicketColumnsOrders::create([
                'columnorder' => $order,
                'ticketboards_id' => $board,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd('update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd('destroy');
    }
}
