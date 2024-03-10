<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketOrders extends Model
{
    protected $table = 'ticketorders';
    use HasFactory;

    protected $fillable = ['ticketorder', 'ticketcolumns_id'];

}
