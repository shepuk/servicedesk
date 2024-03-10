<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TicketBoards extends Model
{
    protected $table = 'ticketboards';
    use HasFactory;


    protected $fillable = ['boardname', 'boarddescription'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $uuid = Str::uuid();
            $model->uuid = $uuid;
            $model->team_id = auth()->user()->currentTeam->id;
        });
    }

}