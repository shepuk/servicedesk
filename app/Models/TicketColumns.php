<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TicketColumns extends Model
{
    protected $table = 'ticketcolumns';
    use HasFactory;

    protected $fillable = ['columnname', 'columndescription', 'ticketboards_id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $uuid = Str::uuid();
            $model->uuid = $uuid;
            //$model->ticketboards_id = auth()->user()->currentTeam->id;
        });
    }

}
