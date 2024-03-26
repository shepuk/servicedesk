<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Assets extends Model
{
    use HasFactory;

    protected $fillable = ['assetname', 'assettype', 'assetdescription', 'assetserialnumber', 'assetlocation', 'assetnotes', 'assetimage', 'companies_id', 'customers_id'];

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