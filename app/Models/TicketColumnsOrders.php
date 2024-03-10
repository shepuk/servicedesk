<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketColumnsOrders extends Model
{
    protected $table = 'ticketcolumnsorder';
    use HasFactory;

    protected $fillable = ['columnorder', 'ticketboards_id'];

}
