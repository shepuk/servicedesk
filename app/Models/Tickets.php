<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tickets extends Model
{
    use HasFactory;

    protected $fillable = ['tickettitle', 'ticketdescription', 'user_id', 'assignee', 'ticketpriority', 'ticketcustomfields', 'ticketstatus', 'ticketcolumns_id', 'ticketboards_id', 'team_id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $uuid = Str::uuid();
            $model->uuid = $uuid;
            $model->user_id = auth()->user()->id;
            $model->team_id = auth()->user()->currentTeam->id;
        });
    }

}
