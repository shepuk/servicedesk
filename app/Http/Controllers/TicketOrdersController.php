<?php

namespace App\Http\Controllers;

use App\Models\TicketOrders;
use Illuminate\Http\Request;

class TicketOrdersController extends Controller
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
        $column = $request->column;

        if (TicketOrders::where('ticketcolumns_id', $column)->exists()) {
            TicketOrders::where('ticketcolumns_id', $column)->update([
                'ticketorder' => $order,
                'ticketcolumns_id' => $column,
            ]);
        } else {
            TicketOrders::create([
                'ticketorder' => $order,
                'ticketcolumns_id' => $column,
            ]);
        }

        return Inertia::render('Tickets');
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
